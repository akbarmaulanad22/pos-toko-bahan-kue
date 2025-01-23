<?php

namespace App\Http\Controllers;

use App\Models\LogEmployee;
use App\Models\LogFinancialTracker;
use App\Models\LogProduct;
use App\Models\LogStaff;
use App\Models\LogStockflow;

class LogController extends Controller
{
    public function products() {
        return view('pages.admin.logs.products', [
            'title' => 'Log Products',
            'logProducts' => LogProduct::all()
        ]);
    }

    public function financialTrackers() {
        return view('pages.admin.logs.financial-trackers', [
            'title' => 'Log Financial Trackers',
            'logFinancialTrackers' => LogFinancialTracker::all()
        ]);
    }

    public function stockFlows() {
        return view('pages.admin.logs.stockflows', [
            'title' => 'Log StockFlows',
            'logStockflows' => LogStockflow::all()
        ]);
    }

    public function staffs() {
        return view('pages.admin.logs.staffs', [
            'title' => 'Log Staffs',
            'logStaffs' => LogStaff::all()
        ]);
    }
    
}
