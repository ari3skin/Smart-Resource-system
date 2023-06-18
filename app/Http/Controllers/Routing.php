<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Routing extends Controller
{
    //
    public function showIndex()
    {
        return view('index');
    }

    public function dashboards()
    {
        $user = Auth::user();

        if ($user->role == 'Admin') {

            return view('admin.dashboard');

        } elseif ($user->role == 'Employer') {

            return view('users.employers.employers');

        } elseif ($user->role == 'Employee') {

            return view('users.employees.employees');

        } else {
            return redirect("/")->withErrors(['msg' => "unauthorized access denied"]);
        }
    }
}
