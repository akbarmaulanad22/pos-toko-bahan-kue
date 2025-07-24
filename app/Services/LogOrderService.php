<?php

namespace App\Services;

use App\Models\LogOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogOrderService
{
    public function insert($request, $action, $orderID)
    {
         try {
            DB::table('log_orders')->insert([
                'action' => $action,
                'input' => implode(', ', ['Order ID: ' . $orderID, 'Entity Name: ' . $request['entity_name'], 'Entity Type: ' . $request['entity_type']]),
                'created_by' => auth()->user()->name,
            ]);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
