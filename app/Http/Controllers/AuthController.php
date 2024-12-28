<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRegistrationRequest $request
     * @return redirect
     */

    public function registration(UserRegistrationRequest $request)
    {
        // Retrieve a portion of the validated input data
        $validatedUser = $request->safe()->except(['password_confirmation']);

        // hashing user password
        $validatedUser['password'] = Hash::make($validatedUser['password']);

        // create valid user
        User::create($validatedUser);

        // redirect login if user has been created
        return redirect('/diaapalahjir/login')->with('registerSuccessfully', 'Registration Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserLoginRequest $request
     * @return redirect
     */

    public function login(UserLoginRequest $request)
    {
        // Retrieve a portion of the validated input data
        $credential = $request->safe()->all();

        if (Auth::attempt($credential)) {
            // regenerate session and redirect to dashboard if user login successfully
            $request->session()->regenerate();
            return redirect()->intended('/areaorangpadang/dashboard');
        }

        // redirect back if user login failed
        return back()->with('loginFailed', 'Please check your email or password');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function registrationPage()
    {
        return view('pages.auth.register', [
            'title' => 'register',
        ]);
    }

    public function loginPage()
    {
        return view('pages.auth.login', [
            'title' => 'login',
        ]);
    }
}
