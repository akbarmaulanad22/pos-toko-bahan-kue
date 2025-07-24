<?php

namespace App\Http\Controllers;

use App\Models\LogCategory;
use App\Models\LogExpense;
use App\Models\LogOrder;
use App\Models\LogProduct;
use App\Models\LogRole;
use App\Models\LogStaff;

class LogController extends Controller
{
    public function products()
    {
        return view('pages.admin.logs.products', [
            'title' => 'Log Products',
            'logProducts' => LogProduct::all()
        ]);
    }

    public function staffs()
    {
        return view('pages.admin.logs.staffs', [
            'title' => 'Log Staffs',
            'logStaffs' => LogStaff::all()
        ]);
    }

    public function roles()
    {
        return view('pages.admin.logs.roles', [
            'title' => 'Log Roles',
            'logs' => LogRole::all()
        ]);
    }

    public function categories()
    {
        return view('pages.admin.logs.categories', [
            'title' => 'Log Categories',
            'logs' => LogCategory::all()
        ]);
    }

    public function expenses()
    {
        return view('pages.admin.logs.expenses', [
            'title' => 'Log Expenses',
            'logs' => LogExpense::all()
        ]);
    }

    public function orders()
    {
        return view('pages.admin.logs.orders', [
            'title' => 'Log Orders',
            'logs' => LogOrder::all()
        ]);
    }
}
