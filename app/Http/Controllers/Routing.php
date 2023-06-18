<?php

namespace App\Http\Controllers;

use App\Models\UserRegistrationRequest;
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

            $registration_requests = UserRegistrationRequest::all();

            return view('admin.dashboard',
                [
                    'registration_requests' => $registration_requests,
                ]
            );

        } elseif ($user->role == 'Employer') {

            return view('users.employers.employers');

        } elseif ($user->role == 'Employee') {

            return view('users.employees.employees');

        } else {
            return redirect("/")->withErrors(['msg' => "unauthorized access denied"]);
        }
    }

    public function dataCollection()
    {

    }
}
