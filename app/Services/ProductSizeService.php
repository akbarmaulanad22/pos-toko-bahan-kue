<?php namespace App\Services;

use App\Models\ProductSize;
use App\Models\StockFlow;
use Exception;
use Illuminate\Http\Request;

class ProductSizeService
{
    public function updateStock(Request $request, ?StockFlow $stockFlow = null)
    {
        // Ambil data stockflow lama berdasarkan ID (asumsikan ID diterima dari request)
        $size = ProductSize::where('id', $request->size_id)->first();

        if (is_null($size)) {
            throw new Exception('No Data Found');
        }

        if (!is_null($stockFlow)) {
            // // Jika ini update, kembalikan stok ke kondisi sebelum perubahan
            if ($stockFlow->type == 'INCOMING') {
                $size->stock -= $stockFlow->quantity; // Kurangi stok lama
            } else {
                $size->stock += $stockFlow->quantity; // Tambahkan stok lama
            }
        }

        // Hitung ulang stok berdasarkan input baru
        if ($request->type == 'INCOMING') {
            $size->stock += $request->quantity;
        } else {
            if ($size->stock < $request->quantity) {
                throw new Exception('Stock cannot be negative');
            }
            $size->stock -= $request->quantity;
        }

        // Simpan perubahan stok
        $size->save();
    }

    public function cancelUpdateStock(StockFlow $stockFlow)
    {
        $size = ProductSize::where('id', $stockFlow->size_id)->first();

        if (is_null($size)) {
            throw new Exception('No Data Found');
        }

        // Sesuaikan stok berdasarkan tipe stockFlow
        if ($stockFlow->type == 'INCOMING') {
            $size->stock -= $stockFlow->quantity; // Kurangi stok karena INCOMING
        } else {
            $size->stock += $stockFlow->quantity; // Tambahkan stok karena OUTGOING
        }

        // Validasi untuk memastikan stok tidak negatif
        if ($size->stock < 0) {
            throw new Exception('Stock cannot be negative');
        }

        // Simpan perubahan stok
        $size->save();
    }

    public function getSizes(?int $product_id)
    {
        if (is_null($product_id)) {
            return [];
        }

        $sizes = ProductSize::where('product_id', $product_id)->get();

        return $sizes;
    }
}
