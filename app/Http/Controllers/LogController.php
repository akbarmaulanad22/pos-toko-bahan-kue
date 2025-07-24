<?php

namespace App\Http\Controllers;

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
}
