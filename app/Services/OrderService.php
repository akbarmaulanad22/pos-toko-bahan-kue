<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class OrderService
{
    public function validateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'entity_name' => 'required|string|max:255',
            'entity_type' => 'required',
            // 'order_type' => 'required',
            'status' => 'required',
            'payment_method' => 'required',
            'details' => 'required|array',
            'details.*.product_size_id' => 'required|integer',
            'details.*.product_name' => 'required',
            'details.*.quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first(), 422);
        }

        // Retrieve the validated input...
        return $validator->validated();
    }

    public function validateStockOut(array $order)
    {
        // ambil details dari order
        $details = $order['details'];

        // Ambil semua size_id sekaligus
        $productSizeIds = array_column($details, 'product_size_id');

        // Query semua stok yang relevan sekaligus
        $stocks = DB::table('product_sizes')
            ->whereIn('id', $productSizeIds)
            ->get(['id', 'stock'])
            ->keyBy('id');

        foreach ($details as $product) {
            $stock = $stocks[$product['product_size_id']]->stock ?? 0; // Default stok 0 jika tidak ditemukan

            if ($stock < $product['quantity']) {
                throw new \Exception("Stok tidak mencukupi untuk produk {$product['product_name']}. Stok tersedia: $stock.", 422);
            }
        }
    }

    function decreaseStock(array $order)
    {
        $details = $order['details'];

        // Siapkan data untuk query
        $caseQuery = 'CASE ';
        $productSizeIds = [];
        foreach ($details as $product) {
            $caseQuery .= "WHEN id = {$product['product_size_id']} THEN stock - {$product['quantity']} ";
            $productSizeIds[] = $product['product_size_id'];
        }
        $caseQuery .= 'ELSE stock END';

        // Eksekusi query batch update
        DB::table('product_sizes')
            ->whereIn('id', $productSizeIds)
            ->update(['stock' => DB::raw($caseQuery)]);
    }

    function increaseStock(array $order)
    {
        $details = $order['details'];

        // Siapkan data untuk query
        $caseQuery = 'CASE ';
        $productSizeIds = [];
        foreach ($details as $product) {
            $caseQuery .= "WHEN id = {$product['product_size_id']} THEN stock + {$product['quantity']} ";
            $productSizeIds[] = $product['product_size_id'];
        }
        $caseQuery .= 'ELSE stock END';

        // Eksekusi query batch update
        DB::table('product_sizes')
            ->whereIn('id', $productSizeIds)
            ->update(['stock' => DB::raw($caseQuery)]);
    }

    public function createOrder(array $order)
    {
        // Validasi stok dan pengurangan stok dalam satu transaksi
        DB::beginTransaction();

        try {
            $details = $order['details'];

            // Ambil semua product_size_id dari order details
            $productSizeIds = array_column($details, 'product_size_id');

            $orderId = DB::table('orders')->insertGetId([
                'entity_name' => $order['entity_name'],
                'entity_type' => $order['entity_type'],
                'type' => $order['entity_type'] === 'Customer' ? 'Out' : 'In',
                'status' => $order['status'],
                'payment_method' => $order['payment_method'],
                'pay_at' => now(),
            ]);

            // Ambil harga untuk semua product_size_id yang ada dalam satu query
            $prices = DB::table('product_sizes')
                ->whereIn('id', $productSizeIds)
                ->get(['id', 'price'])
                ->keyBy('id'); // Menggunakan id sebagai key

            $totalPrice = 0;

            // memetakan detail order
            $orderProducts = array_map(function ($product) use ($orderId, $prices, &$totalPrice) {

                $totalPrice += ($prices->get($product['product_size_id'])->price * $product['quantity']);
                
                return [
                    'order_id' => $orderId,
                    'product_size_id' => $product['product_size_id'],
                    'price' => $prices->get($product['product_size_id'])->price,
                    'quantity' => $product['quantity'],
                ];
            }, $details);

            // Simpan detail order dalam jumlah banyak
            DB::table('order_details')->insert($orderProducts);

            // Commit transaksi
            DB::commit();

            return [
                'order_id' => $orderId, 
                'total_price' => $totalPrice
            ];
        } catch (\Exception $exception) {
            // Rollback jika ada error
            DB::rollBack();
            throw $exception;
        }
    }

    public function incrementStock(Collection $orderDetails)
    {
        if ($orderDetails->isEmpty()) {
            throw new \Exception('Tidak ada detail order untuk diproses.');
        }

        $field = 'stock';
        $cases = [];

        foreach ($orderDetails as $detail) {
            $id = (int) ($detail->product_size_id ?? 0); // Default ke 0 jika tidak valid
            $quantity = (int) ($detail->quantity ?? 0); // Default ke 0 jika tidak valid

            // Abaikan jika ID atau quantity tidak valid
            if ($id === 0 || $quantity === 0) {
                continue;
            }

            $cases[] = "WHEN id = {$id} THEN {$field} + ({$quantity})";
        }

        // Jika tidak ada CASE yang valid, hentikan proses
        if (empty($cases)) {
            throw new \Exception('Tidak ada data valid untuk di-update.');
        }

        // Buat query CASE
        $caseQuery = 'CASE ' . implode(' ', $cases) . " ELSE {$field} END";

        return $caseQuery;
    }

     public function decrementStock(Collection $orderDetails)
    {
        if ($orderDetails->isEmpty()) {
            throw new \Exception('Tidak ada detail order untuk diproses.');
        }

        $field = 'stock';
        $cases = [];

        foreach ($orderDetails as $detail) {
            $id = (int) ($detail->product_size_id ?? 0); // Default ke 0 jika tidak valid
            $quantity = (int) ($detail->quantity ?? 0); // Default ke 0 jika tidak valid

            // Abaikan jika ID atau quantity tidak valid
            if ($id === 0 || $quantity === 0) {
                continue;
            }

            $cases[] = "WHEN id = {$id} THEN {$field} - ({$quantity})";
        }

        // Jika tidak ada CASE yang valid, hentikan proses
        if (empty($cases)) {
            throw new \Exception('Tidak ada data valid untuk di-update.');
        }

        // Buat query CASE
        $caseQuery = 'CASE ' . implode(' ', $cases) . " ELSE {$field} END";

        return $caseQuery;
    }

}
