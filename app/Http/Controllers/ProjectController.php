<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\Project;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index($user_id)
    {
        $user_info = User::all()->where('id', '=', $user_id)->first();

        if (request()->route()->named('projectInfo')) {

            if ($user_info->identifier == 'ADM_') {
                $projects = Project::where('status', 'ongoing')->get();
                return response()->json($projects);

            } elseif ($user_info->identifier == 'MNGR_') {
                $projects = DB::table('projects')->where('status', '=', 'ongoing')
                    ->where('project_manager', '=', $user_id)->get();
                return response()->json($projects);
            } else {
                return response()->json(['error' => 'Project not found']);
            }
        } elseif (request()->route()->named('getUserInfo')) {

            $user = User::find($user_id);

            if (!$user) {
                return response()->json(['error' => 'User not found']);
            }
            return response()->json($user);
        } else {
            return response()->json(['error' => 'Unauthorized Access']);
        }
    }

    public function getEmployer($employerId)
    {
        $employer = Employer::find($employerId);

        if (!$employer) {
            return response()->json(['error' => 'Employer not found']);
        }

        return response()->json($employer);
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
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
