<?php

namespace App\Services;

use App\Models\LogFinancialTracker;
use Exception;
use Illuminate\Http\Request;

class LogFinancialTrackerService
{
    public function insert(Request $request, $action)
    {
        try {
            LogFinancialTracker::create([
                'input' => implode(', ', $request->only(['type', 'amount', 'description'])),
                'action' => $action,
                'created_by' => auth()->user()->name
            ]);
        } catch (Exception $th) {
            throw $th;
        }
    }
}
