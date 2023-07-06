<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $projects = Project::where('status', 'ongoing')->get();
        return response()->json($projects);
    }

    public function getUser(Request $request)
    {
        $managerId = $request->input('managerId');

        // Retrieve the user's details based on the managerId
        $user = User::find($managerId);

        if ($user) {
            if ($user->employer_id) {
                // User is an employer, retrieve employer's information
                $employer = Employer::find($user->employer_id);
                if ($employer) {
                    return response()->json($employer);
                }
            } elseif ($user->employee_id) {
                // User is an employee, retrieve employee's information
                $employee = Employee::find($user->employee_id);
                if ($employee) {
                    return response()->json($employee);
                }
            }
        }
        return response()->json(['error' => 'User not found'], 404);
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
