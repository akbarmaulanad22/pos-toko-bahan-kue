<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
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
}
