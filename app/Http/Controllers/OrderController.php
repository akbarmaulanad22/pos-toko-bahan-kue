<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    public function index()
    {
        return view('pages.admin.orders.index', [
            'title' => 'Form Order',
            'products' => Product::latest()->limit(5)->get()
        ]);
    }

    public function addOrder(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*' => 'required|array|min:1',
            'products.*.productId' => 'required',
            'products.*.sizes' => 'required|array|min:1',
            'products.*.sizes.*' => 'required',
            'products.*.quantities' => 'required|array|min:1',
            'products.*.quantities.*' => 'required|numeric',
            'products.*.price' => 'required|array|min:1',
            'products.*.price.*' => 'required|numeric',
        ]);

        $order = Order::create([
            'name' => $request->get('name', 'unknown'),
            'date_transaction' => now(),
        ]);

        $products = collect($request->get('products', []))->map(function ($product) use ($order) {
            return [
                'order_id' => $order->id,
                'product_id' => $product['productId'],
                'price' => collect($product['price'])->implode('<br/>'),
                'sizes' => collect($product['sizes'])->implode('<br/>'),
                'quantities' => collect($product['quantities'])->implode('<br/>'),
            ];
        });

        $order->products()->attach($products);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
        ]);
    }

    
}
