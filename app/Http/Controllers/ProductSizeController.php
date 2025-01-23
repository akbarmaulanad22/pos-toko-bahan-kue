<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSizeRequest;
use App\Models\Product;
use App\Models\ProductSize;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return view('pages.admin.sizes.index', [
            'title' => 'Sizes Of ' . $product->name,
            'sizes' => $product->sizes,
            'product' => $product
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('pages.admin.sizes.create', [
            'title' => 'Create Size Of ' . $product->name,
            'product' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param App\Models\Product $product
     * @param  \Illuminate\Http\ProductSizeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, ProductSizeRequest $request)
    {
        try {
            $slug = SlugService::createSlug(ProductSize::class, 'slug', $request->size);

            ProductSize::create([
                'size' => $request->size,
                'price' => $request->price,
                'modal' => $request->modal,
                'stock' => $request->stock,
                'product_id' => $product->id,
                'slug' => $slug,
            ]);

            return redirect()->route('sizes.index', ['product' => $product])->with('SUCCESS', 'Ukuran berhasil ditambahkan');
        } catch (Exception $exception) {
            return redirect()->route('sizes.index', ['product' => $product])->with('FAILED', 'Ukuran gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     * @param App\Models\Product $product
     * @param  \App\Models\ProductSize  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, ProductSize $size)
    {
        return view('pages.admin.sizes.show', [
            'title' => 'Detail Size Of ' . $product->name,
            'size' => $size,
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param App\Models\Product $product
     * @param  \App\Models\ProductSize  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, ProductSize $size)
    {
        return view('pages.admin.sizes.edit', [
            'title' => 'Edit Size Of ' . $product->name,
            'size' => $size,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param App\Models\Product $product
     * @param  \Illuminate\Http\ProductSizeRequest  $request
     * @param  \App\Models\ProductSize  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, ProductSizeRequest $request, ProductSize $size)
    {
        try {
            $slug = SlugService::createSlug(ProductSize::class, 'slug', $request->size);

            $size->update([
                'size' => $request->size,
                'price' => $request->price,
                'modal' => $request->modal,
                'stock' => $request->stock,
                'product_id' => $product->id,
                'slug' => $slug,
            ]);

            return redirect()->route('sizes.index', ['product' => $product])->with('SUCCESS', 'Ukuran berhasil diubah');
        } catch (Exception $exception) {
            return redirect()->route('sizes.index', ['product' => $product])->with('SUCCESS', 'Ukuran gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param App\Models\Product $product
     * @param  \App\Models\ProductSize  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductSize $size)
    {
        try {
            $size->delete();

            return redirect()->route('sizes.index', ['product' => $product])->with('SUCCESS', 'Ukuran berhasil dihapus');
        } catch (Exception $exception) {
            return redirect()->route('sizes.index', ['product' => $product])->with('SUCCESS', 'Ukuran gagal dihapus');
        }
    }
}
