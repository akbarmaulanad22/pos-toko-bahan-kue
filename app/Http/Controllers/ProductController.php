<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductOrderCollection;
use App\Http\Resources\ProductOrderResource;
use App\Models\Category;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.products.index', [
            'title' => 'Products',
            'products' => Product::with(['category'])->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.products.create', [
            'title' => 'Create Product',
            'categories' => Category::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        
        try {
            $path = $request->file('image') ? $request->file('image')->store('products') : '';

            Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'sku' => $request->sku,
                'image' => $path,
            ]);

            return redirect()->route('products.index')->with('SUCCESS', 'Produk berhasil ditambahkan');
        } catch (Exception $exception) {
            return redirect()->route('products.index')->with('FAILED', 'Produk gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('pages.admin.products.show', [
            'title' => 'Detail Product',
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.admin.products.edit', [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => Category::latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $path = $product->image;

            if ($request->file('image') && $path) {
                Storage::delete($path);
                $path = $request->file('image')->store('products');
            } elseif ($request->file('image')) {
                $path = $request->file('image')->store('products');
            }

            $product->update([
                'name' => $request->name,
                'sku' => $request->sku,
                'image' => $path,
                'category_id' => $request->category_id
            ]);

            return redirect()->route('products.index')->with('SUCCESS', 'Produk berhasil diubah');
        } catch (Exception $exception) {
            return redirect()->route('products.index')->with('SUCCESS', 'Produk gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            Storage::delete($product->image);

            return redirect()->route('products.index')->with('SUCCESS', 'Produk berhasil dihapus');
        } catch (Exception $exception) {
            return redirect()->route('products.index')->with('SUCCESS', 'Produk gagal dihapus');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function ajax() {
        return ProductOrderResource::collection(Product::search()->latest()->paginate(5));
    }
}
