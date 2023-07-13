<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\Team;
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

            //tasks info extraction while doing the necessary joins
            $tasks = Task::with([
                'project',
                'taskTeamManager.employer.department',
                'taskIndividualUser.employee.department',
                'taskIndividualUser.employer.department',
            ])->whereHas('project', function ($query) use ($user_id) {
                $query->where('project_manager', $user_id)
                    ->orWhere('sub_project_manager', $user_id);
            })->get();

            $tasks->each(function ($task) {
                $assigned_to = $task->taskTeamManager ?? $task->taskIndividualUser;

                if ($assigned_to) {
                    $user = $assigned_to->employee ?? $assigned_to->employer;
                    $task->assigned_to = [
                        'first_name' => $user->first_name ?? null,
                        'last_name' => $user->last_name ?? null,
                    ];
                } else {
                    $task->assigned_to = null;
                }
            });

            //manager and sub manager info extraction with the necessary joins
            $main_managers = User::with('employer')
                ->whereHas('projectsAsManager')
                ->where('role', 'Manager')
                ->where('task_occupancy', 'free')
                ->distinct()
                ->get();
            $sub_managers = User::with('employer')
                ->whereHas('projectsAsSubManager')
                ->where('role', 'Manager')
                ->where('task_occupancy', 'free')
                ->distinct()
                ->get();

            //fetching all employees of the same department based on the currently logged in manager
            $department_id = User::find($user_id)->employer->department_id;
            $employees = User::where('task_occupancy', 'free')
                ->where('role', 'Employee')
                ->whereHas('employee', function ($query) use ($department_id) {
                    $query->where('department_id', $department_id);
                })->with([
                    'employee' => function ($query) {
                        $query->with('department');
                    }
                ])
                ->get();

            //getting all projects where one is a manager or sub manager of a project and projects per department
            $projects = Project::where('status', 'ongoing')
                ->where(function ($query) use ($user_id) {
                    $query->where('project_manager', $user_id)
                        ->orWhere('sub_project_manager', $user_id);
                })
                ->with([
                    'manager' => function ($query) {
                        $query->with([
                            'employer' => function ($query) {
                                $query->with('department');
                            }
                        ]);
                    }
                ])
                ->get();

            //making an associative array to hold all the data and sending the response
            $data = [
                'tasks' => $tasks,
                'managers' => [
                    'project_manager' => $main_managers,
                    'sub_project_managers' => $sub_managers,
                ],
                'employees' => $employees,
                'projects' => $projects,
            ];
            return response()->json($data);

        } elseif (request()->route()->named('employees_tasks')) {

            //getting individual tasks as per project assigned to an employee
            $tasks = Task::with(['taskIndividualUser.employee', 'project'])
                ->where('task_individual_user', $user_id)
                ->get();
            $output = $tasks->map(function ($task) {
                return [
                    'task_title' => $task->task_title,
                    'task_description' => $task->task_description,
                    'first_name' => $task->taskIndividualUser->employee->first_name,
                    'last_name' => $task->taskIndividualUser->employee->last_name,
                    'project_title' => $task->project->project_title,
                ];
            });
            $grouped = $output->groupBy('project_title');

            $data = [
                'tasks' => $grouped
            ];
            return response()->json($data);

        } else {
            abort(400);
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

            $selectTeam = Team::all()->where('team_leader', '=', $task_team_manager)->first();

            $newTaskList->team_id = $selectTeam->id;
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
