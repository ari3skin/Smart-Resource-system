<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlStorage extends Controller
{

    /**
     * This project listing method below lists all projects as per the current logged-in user who must be a manager
     *
     */

    public function projectListing($userId)
    {
        $projects = Project::where('project_manager', $userId)
            ->orWhere('sub_project_manager', $userId)
            ->with(['tasks' => function ($query) use ($userId) {
                $query->select(
                    'tasks.id',
                    'tasks.project_id',
                    'tasks.task_title',
                    'tasks.task_description',
                    DB::raw('
                            CASE
                                WHEN task_team_manager IS NOT NULL THEN (SELECT users.id FROM users WHERE users.id = tasks.task_team_manager)
                                WHEN task_individual_user IS NOT NULL THEN (SELECT users.id FROM users WHERE users.id = tasks.task_individual_user)
                            END as user_id'
                    ),
                    DB::raw('
                            CASE
                                WHEN task_team_manager IS NOT NULL THEN "Team"
                                WHEN task_individual_user IS NOT NULL THEN "Individual"
                            END as task_type'
                    )
                )->where('task_team_manager', $userId)->orWhere('task_individual_user', $userId);
            }])->get();


        $projects->transform(function ($project) {
            $project->tasks->transform(function ($task) {
                $user = User::find($task->user_id);
                if ($user->employer_id) {
                    $employer = Employer::find($user->employer_id);
                    $task->assignee = $employer->first_name . ' ' . $employer->last_name;
                } else if ($user->employee_id) {
                    $employee = Employee::find($user->employee_id);
                    $task->assignee = $employee->first_name . ' ' . $employee->last_name;
                }
                unset($task->user_id);
                return $task;
            });
            return $project;
        });
        return response()->json($projects);
    }
}
