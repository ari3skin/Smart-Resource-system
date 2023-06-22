<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\User;
use App\Models\UserRegistrationRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Routing extends Controller
{
    //
    public function showIndex()
    {
        return view('index');
    }

    //2. accessing the login and registration
    public function accounts()
    {
        if (request()->is('auth/login')) {
            $user = Auth::user();
            if ($user == null) {
                return view('auth.login');
            }
            return redirect("/")->withErrors(['msg' => "You are already logged in"]);

        } elseif (request()->is('auth/registration')) {

            return view('auth.registration');

        } else {
            abort(404);
        }
    }

    public function passwordReset($user_id)
    {
        if ($user_id == null) {

            return redirect("/")->withErrors(['msg' => "unauthorized access denied"]);

        } else {
            return view('auth.reset', ['user_id' => $user_id]);
        }
    }

    public function dashboards()
    {
        $user = Auth::user();

        if ($user->role == 'Admin') {
            //fetching all records
            $employers = Employer::all();
            $employees = Employee::all();
            $users = User::all();
            $registration_requests = UserRegistrationRequest::all()->where('status', '=', 'pending');

            //doing the numbers
            $requestsCount = $registration_requests->count();
            $employersCount = $employers->count();
            $employeesCount = $employees->count();
            $usersCount = $users->count();

            return view('admin.dashboard',
                [
                    'registration_requests' => $registration_requests,
                    'requestsCount' => $requestsCount,
                    'employersCount' => $employersCount,
                    'employeesCount' => $employeesCount,
                    'usersCount' => $usersCount,
                ]
            );

        } elseif ($user->role == 'Manager') {

            return view('users.employers.employers');

        } elseif ($user->role == 'Employee') {

            return view('users.employees.employees');

        } else {
            return redirect("/")->withErrors(['msg' => "Unauthorized access denied"]);
        }
    }
}
