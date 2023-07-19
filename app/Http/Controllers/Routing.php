<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\Project;
use App\Models\User;
use App\Models\UserRegistrationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            return redirect("/")->withErrors(['error' => "You are already logged in"]);

        } elseif (request()->is('auth/registration')) {

            return view('auth.registration');

        } elseif (request()->is('auth/reset')) {

            return view('auth.reset_request');

        } else {
            abort(404);
        }
    }

    public function showabout()
    {
        return view('about');
    }

    public function showemployers()
    {
        return view('employers');
    }

    public function showjobseekers()
    {
        return view('job_seekers');
    }

    public function showbookonline()
    {
        return view('book_online');
    }

    public function showprogramlist()
    {
        return view('program_list');
    }

    public function fromEmailReset($user_token)
    {
        if (request()->route()->named('create_reset')) {

            return view('auth.reset', ['user_id' => $user_token, 'token' => null]);

        } elseif (request()->route()->named('form_reset')) {

            return view('auth.reset', ['token' => $user_token, 'user_id' => null]);

        } else {
            abort(404);
        }
    }

    public function dashboards()
    {
        $user = Auth::user();
        if (Auth::check()) {

            if ($user->role == 'Admin') {
                //fetching all records
                $employers = Employer::all();
                $employees = Employee::all();
                $projects = Project::all();
                $users = User::all();
                $registration_requests = UserRegistrationRequest::all()->where('status', '=', 'pending');

                //doing the numbers
                $requestsCount = $registration_requests->count();
                $employersCount = $employers->count();
                $employeesCount = $employees->count();
                $projectsCount = $projects->count();
                $usersCount = $users->count();

                return view('admin.dashboard',
                    [
                        'registration_requests' => $registration_requests,
                        'requestsCount' => $requestsCount,
                        'employersCount' => $employersCount,
                        'employeesCount' => $employeesCount,
                        'projectsCount' => $projectsCount,
                        'usersCount' => $usersCount,
                    ]
                );

            } elseif ($user->role == 'Manager') {

                $user_id = $user->id;
                $projects = DB::table('projects')
                    ->where('status', '=', 'ongoing')
                    ->where(function ($query) use ($user_id) {
                        $query->where('project_manager', $user_id)
                            ->orWhere('sub_project_manager', $user_id);
                    })->count();

                $teams = DB::table('teams')
                    ->where('team_leader', $user_id)
                    ->count();

                return view('users.employers',
                    [
                        'projectsCount' => $projects,
                        'teamsCount' => $teams,
                    ]);

            } elseif ($user->role == 'Employee') {

                $user_id = $user->id;
                $tasks = DB::table('tasks')
                    ->where('status', '=', 'ongoing')
                    ->where(function ($query) use ($user_id) {
                        $query->where('task_individual_user', $user_id);
                    })->count();

                $teamsQuery = DB::table('teams');

                for ($i = 1; $i <= 5; $i++) {
                    $teamsQuery->orWhere('member_' . $i, $user_id);
                }

                $teamsCount = $teamsQuery->count();


                return view('users.employees',
                    [
                        'tasksCount' => $tasks,
                        'teamsCount' => $teamsCount,
                    ]);

            } else {
                return redirect("/")->withErrors(['error' => "Unauthorized access denied."]);
            }
        } else {
            return redirect("/auth/login")->withErrors(['error' => "Unauthorized access denied. Kindly Login"]);
        }
    }
}
