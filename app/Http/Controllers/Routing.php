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
        return view('admin.dashboard');
    }
}
