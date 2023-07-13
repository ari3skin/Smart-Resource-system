<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\UserRegistrationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //
    //1. Login -- work in progress
    public function login(Request $request)
    {
        $user_confirmation = User::where('username', $request->input('username'))
            ->orWhere('google_id', $request->input('google_id'))
            ->first();
        if ($user_confirmation->account_status == 'activated') {

            $credentials = $request->only('username', 'password');
            $googleId = $request->input('google_id');

            if ($googleId) {
                $google_user = User::where('google_id', $googleId)->first();
                if ($google_user) {

                    Auth::login($google_user, $request->filled('remember'));
                    DB::table('users')->where('id', $google_user->id)->update(['last_login' => now()]);
                    $identifier = DB::table('users')->where('id', $google_user->id)->get('identifier')->first()->identifier;
                    $user_role = DB::table('users')->where('id', $google_user->id)->get('role')->first()->role;

                    //session creation depending on the user type logged in
                    if ($identifier == 'ADM_' || $identifier == 'MNGR_') {

                        $user_info = DB::table('employers')
                            ->select('id', 'first_name', 'last_name', 'identifier')
                            ->where('id', $google_user->employer_id)
                            ->first();
                        $employee = Employer::where('id', $google_user->employer_id)->first();
                        $department = Department::find($employee->department_id);
                        $departmentName = $department->department_name;

                        $request->setLaravelSession(app('session.store'));
                        $request->session()->put('department_name', $departmentName);
                        $request->session()->put('sys_id', $google_user->id);
                        $request->session()->put('first_name', $user_info->first_name);
                        $request->session()->put('last_name', $user_info->last_name);
                        $request->session()->put('role', $user_role);
                        $request->session()->put('chat_box_id', 'employer_chat');

                    } elseif ($identifier == 'EPE_') {

                        $user_info = DB::table('employees')
                            ->select('id', 'first_name', 'last_name', 'identifier')
                            ->where('id', $google_user->employee_id)
                            ->first();
                        $employee = Employee::where('id', $google_user->employer_id)->first();
                        $department = Department::find($employee->department_id);
                        $departmentName = $department->department_name;

                        $request->setLaravelSession(app('session.store'));
                        $request->session()->put('department_name', $departmentName);
                        $request->session()->put('sys_id', $google_user->id);
                        $request->session()->put('first_name', $user_info->first_name);
                        $request->session()->put('last_name', $user_info->last_name);
                        $request->session()->put('role', $user_role,);
                        $request->session()->put('chat_box_id', 'employee_chat');
                    }
                    return redirect()->intended('/admin/');
                }
            } elseif (Auth::attempt($credentials, $request->filled('remember'))) {

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
                    $employee = Employer::where('id', $user->employer_id)->first();
                    $department = Department::find($employee->department_id);
                    $departmentName = $department->department_name;

                    $request->session()->put('department_name', $departmentName);
                    $request->session()->put('sys_id', $user->id);
                    $request->session()->put('first_name', $user_info->first_name);
                    $request->session()->put('last_name', $user_info->last_name);
                    $request->session()->put('role', $user_role,);
                    $request->session()->put('chat_box_id', 'employer_chat');

                } elseif ($identifier == 'EPE_') {

                    $user_info = DB::table('employees')
                        ->select('id', 'first_name', 'last_name', 'identifier', 'department_id')
                        ->where('id', $user->employee_id)
                        ->first();
                    $employee = Employee::where('id', $user->employee_id)->first();
                    $department = Department::find($employee->department_id);
                    $departmentName = $department->department_name;

                    $request->session()->put('department_name', $departmentName);
                    $request->session()->put('sys_id', $user->id);
                    $request->session()->put('first_name', $user_info->first_name);
                    $request->session()->put('last_name', $user_info->last_name);
                    $request->session()->put('role', $user_role,);
                    $request->session()->put('chat_box_id', 'employee_chat');
                }
                return redirect()->intended('/admin/');

            } else {
                return redirect()->route('login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
            }
        } elseif ($user_confirmation->account_status == 'inactive') {
            return redirect()->route('login')->withErrors(['error' => 'Your Account has not been activated yet']);
        }
    }

    //2. Creating a Registration Request
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


    //2-1. account creation
    public function createAccount($data, $type)
    {
        // Extract the necessary fields from $data
        $id = $data->id;
        $first_name = $data->first_name;
        $last_name = $data->last_name;

        $username = strtolower($first_name . "_" . $last_name . "@arcadian.resource");
        $existing_user = User::where('username', $username)->exists();

        if (!$existing_user) {
            if ($type == 'Manager') {
                return User::create([
                    'identifier' => 'MNGR_',
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
                    'identifier' => 'EPE_',
                    'employee_id' => $id,
                    'employer_id' => null,
                    'role' => $type,
                    'username' => $username,
                    'password' => Hash::make('arcadian_user_resource_123'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        } else {
            return redirect()->intended('/')->withErrors(['error' => 'The selected user already exists.']);
        }
    }

    //3. password reset
    //the first method is for token generation mostly to verify the existence of the user and their credentials
    public function passwordReset(Request $request)
    {
        $token = str::random(60);
        $employer_search = Employer::where('email', '=', $request->input('email'))->exists();
        $employee_search = Employee::where('email', '=', $request->input('email'))->exists();

        if ($employer_search) {
            $employer = Employer::all()->where('email', '=', $request->input('email'))->first();
            $user = User::all()->where('employer_id', '=', $employer->id)->first();

            $reset = new PasswordReset();
            $reset->user_id = $user->id;
            $reset->token = $token;
            $reset->token_used = 'false';
            $reset->created_at = Carbon::now();
            $reset->save();

            Mail::to($employer->email)->send(new ResetPasswordMail($employer, $token));

        } elseif ($employee_search) {
            $employee = Employee::all()->where('email', '=', $request->input('email'))->first();
            $user = User::all()->where('employee_id', '=', $employee->id)->first();

            $reset = new PasswordReset();
            $reset->user_id = $user->id;
            $reset->token = $token;
            $reset->token_used = 'false';
            $reset->created_at = Carbon::now();
            $reset->save();

            Mail::to($employee->email)->send(new ResetPasswordMail($employee, $token));
        } else {
            return redirect()->intended('/auth/reset')->withErrors(['error' => 'Kindly confirm you have input your details correctly.']);
        }
        return redirect()->route('/')->withErrors(['msg' => 'Check your mail for instructions.']);
    }

    public function saveReset(Request $request)
    {
        $new_password = Hash::make($request->input('new_password'));

        if ($request->input('user_id') == null) {
            $token_info = PasswordReset::all()->where('token', '=', $request->input('token'))->first();
            $user_update = User::all()->where('id', '=', $token_info->user_id)->first();
            DB::table('users')->where('id', $user_update->id)->update(['account_status' => 'activated']);
            $user_update->password = $new_password;
            $user_update->email_verified_at = Carbon::now();
            $user_update->update();
            return redirect()->route('/')->withErrors(['msg' => 'Password Reset Successfully.']);

        } elseif ($request->input('token') == null) {
            $user_update = User::all()->where('id', '=', $request->input('user_id'))->first();
            DB::table('users')->where('id', $user_update->id)->update(['account_status' => 'activated']);
            $user_update->password = $new_password;
            $user_update->email_verified_at = Carbon::now();
            $user_update->update();
            return redirect()->route('/')->withErrors(['msg' => 'Password Reset Successfully.']);
        } else {
            abort(406);
        }
    }

    //5. logout
    public function logout(Request $request)
    {
        // Revoke Google access token
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->google_token) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])->post('https://accounts.google.com/o/oauth2/revoke', [
                    'token' => $user->google_token,
                ]);

                if ($response->successful()) {
                    $user->google_token = null;
                    $user->save();
                }
            }
        }
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        return redirect()->to('/auth/login')->with('loggedout', true);
    }
}
