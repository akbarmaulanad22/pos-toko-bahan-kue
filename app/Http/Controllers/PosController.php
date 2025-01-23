<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        return view('pages.admin.pos.index');
    }

    public function store(PosRequest $request)
    {
        if(!$request->validated())
        {
            return response()->json(['message' => 'Order submission failed.'], 401);
        }
        
        // Validasi data
        $data = $request->validated();

        // Mulai transaksi untuk menjaga konsistensi data
        DB::beginTransaction();

        try {
            // Simpan data pesanan utama (orders) dengan insertGetId
            $orderId = DB::table('orders')->insertGetId([
                'custumer_name' => '-', // Nama pelanggan
                'amount' => $data['totalPrice'],
                'quantities' => $data['totalQuantity'],
                'payment_method' => null, // Misalnya tidak ada metode pembayaran
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Persiapkan data untuk batch insert ke tabel order_product
            $orderProducts = array_map(function ($product) use ($orderId) {
                return [
                    'product_id' => $product['id'],
                    'order_id' => $orderId,
                    'size' => $product['size'],
                    'price' => $product['total'], // Harga total produk
                    'quantity' => $product['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['selectedProducts']);

            // Batch insert ke tabel order_product
            DB::table('order_product')->insert($orderProducts);

            // Commit transaksi jika semua berhasil
            DB::commit();

            return response()->json(['message' => 'Order successfully submitted!']);
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();

            // Tangani exception dan kembalikan respons error
            return response()->json(['message' => 'Order submission failed.', 'error' => $e->getMessage()], 500);
        }
    }
}
