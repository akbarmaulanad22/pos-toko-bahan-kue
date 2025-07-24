<?php

namespace App\Services;

use App\Models\LogExpense;
use Exception;
use Illuminate\Http\Request;

class LogExpenseService
{
    public function insert(Request $request, $action)
    {
        try {
            LogExpense::create([
                'input' => implode(', ', $request->only(['amount', 'description'])),
                'action' => $action,
                'created_by' => auth()->user()->name
            ]);
        } catch (Exception $th) {
            throw $th;
        }
    }
}
