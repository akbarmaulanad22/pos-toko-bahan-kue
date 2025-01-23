<?php

namespace App\Services;

use App\Models\LogProduct;
use Exception;
use Illuminate\Http\Request;

class LogProductService
{
    public function insert(Request $request, $action)
    {
        try {
                
            LogProduct::create([
                'input' => implode(', ', $request->only(['name', 'sku', 'file'])),
                'action' => $action,
                'created_by' => auth()->user()->name
            ]);
        } catch (Exception $th) {
            throw $th;
        }
    }
}
