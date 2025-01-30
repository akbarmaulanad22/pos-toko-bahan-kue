<?php

namespace App\Services;

use App\Models\LogStockFlow;
use Exception;
use Illuminate\Http\Request;

class LogStockFlowService
{
    public function insert(Request $request, $action)
    {
        try {
            LogStockFlow::create([
                'input' => implode(', ', $request->only(['product_name', 'size_name', 'type', 'quantity', 'description'])),
                'action' => $action,
                'created_by' => auth()->user()->name,
            ]);
        } catch (Exception $th) {
            throw $th;
        }
    }
}
