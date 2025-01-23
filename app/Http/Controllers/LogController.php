<?php

namespace App\Http\Controllers;

use App\Models\LogProduct;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function products() {
        return view('pages.admin.logs.products', [
            'title' => 'Log Products',
            'logProducts' => LogProduct::all()
        ]);
    }
}
