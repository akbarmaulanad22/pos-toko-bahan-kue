<?php

namespace App\Services;

use App\Models\LogStaff;
use Exception;
use Illuminate\Http\Request;

class LogStaffService
{
    public function insert(Request $request, $action)
    {
        try {
                
            LogStaff::create([
                'input' => implode(', ', $request->only(['name', 'email', 'role_name'])),
                'action' => $action,
                'created_by' => auth()->user()->name
            ]);
        } catch (Exception $th) {
            throw $th;
        }
    }
}
