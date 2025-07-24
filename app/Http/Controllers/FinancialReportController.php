<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;

        // Orders In (Barang masuk)
        $ordersInQuery = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.type', 'In')
            ->where('orders.status', 'Completed')
            ->where('order_details.is_cancelled', false)
            ->when($search, function ($query, $search) {
                $query->where('orders.entity_name', 'like', "%{$search}%");
            })
            ->select([
                'orders.pay_at as date',
                DB::raw("'Penjualan' as type"),
                DB::raw('(order_details.quantity * order_details.price) as amount'),
            ]);

        // Orders Out (Barang keluar)
        $ordersOutQuery = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.type', 'Out')
            ->where('orders.status', 'Completed')
            ->where('order_details.is_cancelled', false)
            ->when($search, function ($query, $search) {
                $query->where('orders.entity_name', 'like', "%{$search}%");
            })
            ->select([
                'orders.pay_at as date',
                DB::raw("'Barang Keluar' as type"),
                DB::raw('(order_details.quantity * order_details.price) as amount'),
            ]);

        // Expenses
        $expensesQuery = DB::table('expenses')
            ->when($search, function ($query, $search) {
                $query->where('description', 'like', "%{$search}%");
            })
            ->select([
                'created_at as date',
                DB::raw("'Pengeluaran' as type"),
                'amount',
            ]);

        $combinedReportsQuery = $ordersInQuery
            ->unionAll($ordersOutQuery)
            ->unionAll($expensesQuery)
            ->orderBy('date', 'desc');

        // Untuk pagination:
        $combinedReports = DB::table(DB::raw("({$combinedReportsQuery->toSql()}) as combined"))
            ->mergeBindings($combinedReportsQuery)
            ->orderBy('date', 'desc')
            ->get();

        // Total Pendapatan Kotor (total orders OUT)
        $totalPendapatanKotor = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.type', 'Out')
            ->where('orders.status', 'Completed')
            ->where('order_details.is_cancelled', false)
            ->when($search, function ($query, $search) {
                $query->where('orders.entity_name', 'like', "%{$search}%");
            })
            ->selectRaw('SUM(order_details.quantity * order_details.price) as total')
            ->value('total') ?? 0;

        // Total Pengeluaran
        $totalPengeluaran = DB::table('expenses')
            ->when($search, function ($query, $search) {
                $query->where('description', 'like', "%{$search}%");
            })
            ->sum('amount');

        // Pendapatan Bersih
        $totalPendapatanBersih = $totalPendapatanKotor - $totalPengeluaran;


        return view('pages.admin.financial-reports.index', [
            'title' => 'Financial Reports',
            'combinedReports' => $combinedReports,
            'totalPendapatanKotor' => $totalPendapatanKotor,
            'totalPendapatanBersih' => $totalPendapatanBersih,
            'totalPengeluaran' => $totalPengeluaran,
        ]);
    }

    function export(Request $request)
    {

        $search = $request->search;

        // Orders In (Barang masuk)
        $ordersInQuery = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.type', 'In')
            ->where('orders.status', 'Completed')
            ->where('order_details.is_cancelled', false)
            ->when($search, function ($query, $search) {
                $query->where('orders.entity_name', 'like', "%{$search}%");
            })
            ->select([
                'orders.pay_at as date',
                DB::raw("'Penjualan' as type"),
                DB::raw('(order_details.quantity * order_details.price) as amount'),
            ]);

        // Orders Out (Barang keluar)
        $ordersOutQuery = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.type', 'Out')
            ->where('orders.status', 'Completed')
            ->where('order_details.is_cancelled', false)
            ->when($search, function ($query, $search) {
                $query->where('orders.entity_name', 'like', "%{$search}%");
            })
            ->select([
                'orders.pay_at as date',
                DB::raw("'Barang Keluar' as type"),
                DB::raw('(order_details.quantity * order_details.price) as amount'),
            ]);

        // Expenses
        $expensesQuery = DB::table('expenses')
            ->when($search, function ($query, $search) {
                $query->where('description', 'like', "%{$search}%");
            })
            ->select([
                'created_at as date',
                DB::raw("'Pengeluaran' as type"),
                'amount',
            ]);

        $combinedReportsQuery = $ordersInQuery
            ->unionAll($ordersOutQuery)
            ->unionAll($expensesQuery)
            ->orderBy('date', 'desc');

        // Untuk pagination:
        $combinedReports = DB::table(DB::raw("({$combinedReportsQuery->toSql()}) as combined"))
            ->mergeBindings($combinedReportsQuery)
            ->orderBy('date', 'desc');

        $filename = 'employee-data.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($combinedReports) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'Date',
                'Type',
                'Amout',
            ]);

            // Fetch and process data in chunks
            $combinedReports->chunk(25, function ($reports) use ($handle) {
                foreach ($reports as $report) {
                    // Extract data from each report.
                    $data = [
                        isset($report->date) ? $report->date : '',
                        isset($report->type) ? $report->type : '',
                        isset($report->amount) ? $report->amount : '',
                    ];

                    // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });

            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
}
