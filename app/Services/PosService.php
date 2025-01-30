<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class PosService
{
    public function validateStock(array $orderData)
    {
        // dd($orderData);

        $selectedProducts = $orderData['selectedProducts'];

        // Ambil semua ID product dan size_id sekaligus
        $productIds = array_column($selectedProducts, 'id');
        $sizeIds = array_column($selectedProducts, 'size_id');

        // Query semua stok yang relevan sekaligus
        $stocks = DB::table('product_sizes')
            ->whereIn('product_id', $productIds)
            ->whereIn('id', $sizeIds)
            ->get(['product_id', 'id', 'stock'])
            ->keyBy(function ($item) {
                return $item->product_id . '_' . $item->id;
            });

        $errors = [];

        // Validasi stok di PHP
        foreach ($selectedProducts as $product) {
            $key = $product['id'] . '_' . $product['size_id'];
            $stock = $stocks[$key]->stock ?? 0; // Default stok 0 jika tidak ditemukan

            if ($stock < $product['quantity']) {
                $errors[] = "Stok tidak mencukupi untuk produk {$product['name']} ({$product['size']}). Stok tersedia: $stock.";
            }
        }

        // Return hasil validasi
        if (!empty($errors)) {
            return [
                'status' => 'error',
                'message' => $errors,
            ];
        }

        return [
            'status' => 'success',
            'message' => ['Stok mencukupi untuk semua produk.'],
        ];
    }

    
}
