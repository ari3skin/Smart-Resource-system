<?php

namespace App\Http\Controllers;

use App\Models\UserRegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            abort(404);
        }
    }

    //2-1. Login -- work in progress
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $rememberMe = $request['remember-me'];
        if (Auth::attempt($credentials)) {
            return "able to login";
        } else {
            return "not able to login";
        }
    }

    //2-2. Registration Request
    public function registration(Request $request): void
    {
        $data = $request->all();
        $this->createRequest($data);
    }

    public function createRequest(array $data)
    {
        $email = $data['email'];
        $employer = DB::table('employers')
            ->select('id')
            ->where('email', $email)
            ->first();

        if ($employer) {
            $employer_id = $employer->id;
            $employee_id = null;

        } else {
            $employee = DB::table('employees')
                ->select('id')
                ->where('email', $email)
                ->first();

            if ($employee) {
                $employee_id = $employee->id;
                $employer_id = null;
            }
        }
        return UserRegistrationRequest::create([
            'employer_id' => $employer_id,
            'employee_id' => $employee_id,
            'work_email' => $email,
            'request_date' => $data['datetime'],
            'status' => 'pending',
        ]);
    }


    //3. logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
