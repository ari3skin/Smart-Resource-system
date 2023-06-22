<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\User;
use App\Models\UserRegistrationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //
    //1. accessing the login and registration
    public function accounts()
    {
        if (request()->is('auth/login')) {
            $user = Auth::user();
            if ($user == null) {
                return view('auth.login');
            }
            return redirect("/")->withErrors(['msg' => "you are already logged in"]);

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
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            DB::table('users')->where('id', $user->id)->update(['last_login' => now()]);
            $identifier = DB::table('users')->where('id', $user->id)->get('identifier')->first()->identifier;
            $user_role = DB::table('users')->where('id', $user->id)->get('role')->first()->role;

            //session creations depending on the user type logged in
            if ($identifier == 'ADM_' || $identifier == 'MNGR_') {

                $user_info = DB::table('employers')
                    ->select('id', 'first_name', 'last_name', 'identifier')
                    ->where('id', $user->employer_id)
                    ->first();
                $request->session()->put('work_id', $user_info->id);
                $request->session()->put('first_name', $user_info->first_name);
                $request->session()->put('last_name', $user_info->last_name);
                $request->session()->put('role', $user_role,);

            } elseif ($identifier == 'EMP_') {

                $user_info = DB::table('employees')
                    ->select('id', 'first_name', 'last_name', 'identifier')
                    ->where('id', $user->employer_id)
                    ->first();
                $request->session()->put('work_id', $user_info->id);
                $request->session()->put('first_name', $user_info->first_name);
                $request->session()->put('last_name', $user_info->last_name);
                $request->session()->put('role', $user_role,);
            }

            if ($user_role == 'Admin') {
                return redirect()->intended('/admin/');

            } elseif ($user_role == 'Manager') {
                return redirect()->intended('/admin/');

            } elseif ($user_role == 'Employee') {
                return redirect()->intended('/admin/');
            }
        }
    }

    //2-2. Registration Request
    public function registration(Request $request)
    {
        $data = $request->all();
        $existingRequest = UserRegistrationRequest::where('work_email', $request->input('email'))->exists();
        $existingEmployer = Employer::where('email', $request->input('email'))->exists();
        $existingEmployee = Employee::where('email', $request->input('email'))->exists();

        if (!$existingRequest) {
            if ($existingEmployer || $existingEmployee) {
                $this->createRequest($data);
                return response()->json(['success' => true]);

            } else {
                return response()->json(['success' => false]);
            }
        } else {
            return response()->json(['success' => false]);
        }

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

    //3. account creation
    public function createAccount($data, $type)
    {
        // Extract the necessary fields from $data
        $id = $data->id;
        $first_name = $data->first_name;
        $last_name = $data->last_name;

        $username = strtolower($first_name . "_" . $last_name . "@resource.arcadian.org");

        if ($type == 'Manager') {
            return User::create([
                'identifier'=>'MNGR_',
                'employer_id' => $id,
                'employee_id' => null,
                'role' => $type,
                'username' => $username,
                'password' => Hash::make('arcadian_user_resource_123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } elseif ($type == 'Employee') {
            return User::create([
                'identifier'=>'EPE_',
                'employee_id' => $id,
                'employer_id' => null,
                'role' => $type,
                'username' => $username,
                'password' => Hash::make('arcadian_user_resource_123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }


    //4. logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
