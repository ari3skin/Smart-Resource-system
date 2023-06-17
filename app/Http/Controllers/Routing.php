<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Routing extends Controller
{
    //
    public function showIndex()
    {
        return view('index');
    }

    public function admin()
    {
        $user = auth()->user();
        if ($user == null || $user->role != "admin") {
            return redirect("/")->withErrors(['msg' => "unauthorized access denied"]);
        } else {
            return view('admin.dashboard');
        }

    }
}
