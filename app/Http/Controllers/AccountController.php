<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use App\Models\User;

class AccountController extends Controller
{
    public function index() {
        return view('pages.admin.account.index', [
            'title' => 'Account Setting'
        ]);
    }

    public function update(AccountUpdateRequest $request, User $user) {
        $user->update($request->safe()->except('password_confirmation'));

        return redirect()->back();
    }
}
