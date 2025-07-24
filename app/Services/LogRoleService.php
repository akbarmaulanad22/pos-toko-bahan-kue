<?php

namespace App\Services;

use App\Models\LogRole;
use Exception;
use Illuminate\Http\Request;

class LogRoleService
{
    public function insert(Request $request, $action)
    {
        try {

            LogRole::create([
                'input' => implode(', ', $request->only(['name', 'email', 'role_name'])),
                'action' => $action,
                'created_by' => auth()->user()->name
            ]);
        } catch (Exception $th) {
            throw $th;
        }
    }
}
