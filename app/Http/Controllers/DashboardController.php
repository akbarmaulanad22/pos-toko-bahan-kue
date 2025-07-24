<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        
        return view('pages.admin.dashboard', [
            'title' => 'Dashboard',
            'roleCount' => Role::count(),
            'staffCount' => User::count(),
            'categoryCount' => Category::count(),
            'productCount' => Product::count(),
        ]);
    }
}
