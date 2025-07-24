<?php

namespace App\Services;

use App\Models\LogCategory;
use Exception;
use Illuminate\Http\Request;

class LogCategoryService
{
    public function insert(Request $request, $action)
    {
        try {

            LogCategory::create([
                'input' => implode(', ', $request->only(['name', 'slug'])),
                'action' => $action,
                'created_by' => auth()->user()->name
            ]);
        } catch (Exception $th) {
            throw $th;
        }
    }
}
