<?php

namespace App\Http\Controllers;

use App\Models\Product;

class MainController extends Controller
{
    public function index()
    {
        return view('pages.main.index', [
            'title' => 'Main',
            'products' => Product::latest()->take(4)->get(),
        ]);
    }

    public function showProducts()
    {
        return view('pages.main.products', [
            'title' => 'Produk Konsumsi',
            'products' => Product::search()->latest()->simplePaginate(8)->withQueryString(),
        ]);
    }
}
