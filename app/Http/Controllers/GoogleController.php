<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    //
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callBackFromGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();
            dd($user);
        } catch (\Exception $err) {
            return redirect('/auth/login');
        }
    }
}
