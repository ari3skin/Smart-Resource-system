<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    //1. accessing the login and registration
    public function accounts()
    {
        if (request()->is('auth/login')) {

            return view('auth.login');

        } elseif (request()->is('auth/registration')) {

            return view('auth.registration');

        } else {
            // Handle the case when neither the login nor the registration route is matched
            abort(404);
        }
    }

    //2-1. Login
    public function login()
    {

    }

    //2-2. Registration Request
    public function registration(Request $request)
    {
        $data = $request->all();
    }


    //3. logout procedures
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
