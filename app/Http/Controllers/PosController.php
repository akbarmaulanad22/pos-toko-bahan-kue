<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\PosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        return view('pages.admin.pos.index');
    }

    public function store(Request $request)
    {

        dd($request->all());
        
    //     $validateData = $request->validate([
    //         'selectedProducts' => 'required|array',
    //         'selectedProducts.*.id' => 'required|integer|exists:products,id',
    //         'selectedProducts.*.name' => 'required|string|max:255',
    //         'selectedProducts.*.size' => 'required|string',
    //         'selectedProducts.*.size_id' => 'required|integer',
    //         'selectedProducts.*.price' => 'required|integer|min:0',
    //         'selectedProducts.*.quantity' => 'required|integer|min:1',
    //         'totalPrice' => 'required|integer|min:0',
    //         'totalQuantity' => 'required|integer|min:0',
    //     ]);

    //     if (!$validateData) {
    //         return response()->json(['message' => 'Order submission failed.'], 401);
    //     }

    //     // validasi stock barang
    //     $posService = new PosService();
    //     $validateStock = $posService->validateStock($validateData);

    //     if ($validateStock['status'] === 'error') {
    //         return response()->json(['message' => $validateStock['message']], 401);
    //     }

    //     // // Mulai transaksi untuk menjaga konsistensi data
    //     DB::beginTransaction();

    //     try {
    //         // Simpan data pesanan utama (orders) dengan insertGetId
    //         $orderId = DB::table('orders')->insertGetId([
    //             'custumer_name' => '-', // Nama pelanggan
    //             'amount' => $validateData['totalPrice'],
    //             'quantities' => $validateData['totalQuantity'],
    //             'payment_method' => null, // Misalnya tidak ada metode pembayaran
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         // Persiapkan data untuk batch insert ke tabel order_product
    //         $orderProducts = array_map(function ($product) use ($orderId) {
    //             return [
    //                 'product_id' => $product['id'],
    //                 'order_id' => $orderId,
    //                 'size' => $product['size'],
    //                 'price' => $product['total'], // Harga total produk
    //                 'quantity' => $product['quantity'],
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //         }, $validateData['selectedProducts']);

    //         // Batch insert ke tabel order_product
    //         DB::table('order_product')->insert($orderProducts);

    //         // Commit transaksi jika semua berhasil
    //         DB::commit();

    //         return response()->json(['message' => 'Order successfully submitted!']);
    //     } catch (\Exception $e) {
    //         // Rollback jika terjadi error
    //         DB::rollBack();

    //         // Tangani exception dan kembalikan respons error
    //         return response()->json(['message' => 'Order submission failed.', 'error' => $e->getMessage()], 500);
        // }
    }
}
