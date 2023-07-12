<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
                    'tasks.project_id',
                    'tasks.task_title',
                    'tasks.task_description',
                    'tasks.type as task_type',
                    DB::raw("CASE
            WHEN tasks.task_team_manager IS NOT NULL THEN CONCAT(coalesce(team_manager_employers.first_name, team_manager_employees.first_name), ' ', coalesce(team_manager_employers.last_name, team_manager_employees.last_name))
            ELSE CONCAT(coalesce(individual_employer.first_name, individual_employee.first_name), ' ', coalesce(individual_employer.last_name, individual_employee.last_name))
            END AS assigned_to")
                ]);

            $tasks = $query->get();

            $main_managers = DB::table('users')
                ->join('projects', function ($join) {
                    $join->on('users.id', '=', 'projects.project_manager');
                })
                ->join('employers', 'users.employer_id', '=', 'employers.id')
                ->where(function ($query) {
                    $query->where('users.role', '=', 'Manager')
                        ->where('users.task_occupancy', '=', 'free');
                })
                ->select('users.id', 'users.identifier', 'users.role', 'users.username', 'employers.first_name', 'employers.last_name')
                ->distinct()
                ->get();

            $sub_manager = DB::table('users')
                ->join('projects', function ($join) {
                    $join->on('users.id', '=', 'projects.sub_project_manager');
                })
                ->join('employers', 'users.employer_id', '=', 'employers.id')
                ->where(function ($query) {
                    $query->where('users.role', '=', 'Manager')
                        ->where('users.task_occupancy', '=', 'free');
                })
                ->select('users.id', 'employers.first_name', 'employers.last_name')
                ->distinct()
                ->get();

            $employees = User::where('task_occupancy', 'free')
                ->join('employees', 'users.employee_id', '=', 'employees.id')
                ->where('role', 'Employee')
                ->select('users.*', 'employees.first_name', 'employees.last_name')
                ->get();
            $projects = Project::where('status', 'ongoing')->get();
            $data = [
                'tasks' => $tasks,
                'managers' => [
                    'project_manager' => $main_managers,
                    'sub_project_managers' => $sub_manager
                ],
                'employees' => $employees,
                'projects' => $projects,
            ];
            return response()->json($data);
        } elseif (request()->route()->named('employees_tasks')) {

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        //
        $newTask = new Task();
        $newTaskList = new TaskList();
        $project_id = $request->input('project_id');
        $task_title = $request->input('task_title');
        $task_description = $request->input('task_description');


        if ($request->filled('type_team')) {
            $type = "team";
            $task_team_manager = $request->input('task_team_manager');

            $newTask->project_id = $project_id;
            $newTask->task_title = $task_title;
            $newTask->task_description = $task_description;
            $newTask->task_team_manager = $task_team_manager;
            $newTask->task_individual_user = null;
            $newTask->type = $type;
            $newTask->save();

            $lastID = DB::getPdo()->lastInsertId();
            $newTaskList->task_id = $lastID;
            $newTaskList->individuals_id = null;
            $newTaskList->team_id = $task_team_manager;
            $newTaskList->save();

            return response()->json([
                'info' => [
                    'title' => 'Success',
                    'description' => 'Team Task Created Successfully.',
                ]
            ]);

        } elseif ($request->filled('type_individual')) {
            $type = "individual";
            $task_manager_individual = $request->input('task_manager_individual');
            $task_employee_individual = $request->input('task_employee_individual');

            if ($task_manager_individual && $task_employee_individual) {
                return response()->json([
                    'info' => [
                        'title' => 'Warning',
                        'description' => 'Select one of either Manager or Employee for an Individual task',
                    ]
                ], 500);
            } elseif ($task_manager_individual) {
                $newTask->project_id = $project_id;
                $newTask->task_title = $task_title;
                $newTask->task_description = $task_description;
                $newTask->task_team_manager = null;
                $newTask->task_individual_user = $task_manager_individual;
                $newTask->type = $type;
                $newTask->save();

                $lastID = DB::getPdo()->lastInsertId();
                $newTaskList->task_id = $lastID;
                $newTaskList->individuals_id = $task_manager_individual;
                $newTaskList->team_id = null;
                $newTaskList->save();

            } elseif ($task_employee_individual) {
                $newTask->project_id = $project_id;
                $newTask->task_title = $task_title;
                $newTask->task_description = $task_description;
                $newTask->task_team_manager = null;
                $newTask->task_individual_user = $task_employee_individual;
                $newTask->type = $type;
                $newTask->save();

                $lastID = DB::getPdo()->lastInsertId();
                $newTaskList->task_id = $lastID;
                $newTaskList->individuals_id = $task_employee_individual;
                $newTaskList->team_id = null;
                $newTaskList->save();
            }

            return response()->json([
                'info' => [
                    'title' => 'Success',
                    'description' => 'Individual Task Created Successfully.',
                ]
            ]);

        } else {
            return response()->json([
                'info' => [
                    'title' => 'Warning',
                    'description' => 'The task type has not been selected',
                ]
            ], 500);
        }
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
