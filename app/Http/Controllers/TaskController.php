<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($user_id)
    {
        //
        $user_info = User::all()->where('id', '=', $user_id)->first();

        if (request()->route()->named('managers_tasks')) {
            $query = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->where('projects.project_manager', $user_id)
                ->orWhere('projects.sub_project_manager', $user_id)
                ->leftJoin('users as team_manager_users', 'tasks.task_team_manager', '=', 'team_manager_users.id')
                ->leftJoin('users as individual_user', 'tasks.task_individual_user', '=', 'individual_user.id')
                ->leftJoin('employers as team_manager_employers', 'team_manager_users.employer_id', '=', 'team_manager_employers.id')
                ->leftJoin('employees as team_manager_employees', 'team_manager_users.employee_id', '=', 'team_manager_employees.id')
                ->leftJoin('employers as individual_employer', 'individual_user.employer_id', '=', 'individual_employer.id')
                ->leftJoin('employees as individual_employee', 'individual_user.employee_id', '=', 'individual_employee.id')
                ->select([
                    'projects.project_title',
                    'tasks.task_title',
                    'tasks.task_description',
                    'tasks.type as task_type',
                    DB::raw("CASE
            WHEN tasks.task_team_manager IS NOT NULL THEN CONCAT(coalesce(team_manager_employers.first_name, team_manager_employees.first_name), ' ', coalesce(team_manager_employers.last_name, team_manager_employees.last_name))
            ELSE CONCAT(coalesce(individual_employer.first_name, individual_employee.first_name), ' ', coalesce(individual_employer.last_name, individual_employee.last_name))
            END AS assigned_to")
                ]);

            $tasks = $query->get();

            return response()->json($tasks);
        }elseif (request()->route()->named('employees_tasks')) {

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
