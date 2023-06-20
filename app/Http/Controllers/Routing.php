<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\User;
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

        } elseif ($user->role == 'Employer') {

            return view('users.employers.employers');

        } elseif ($user->role == 'Employee') {

            return view('users.employees.employees');

        } else {
            return redirect("/")->withErrors(['msg' => "unauthorized access denied"]);
        }
    }
}
