<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

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
                $data = [
                    'projects' => $projects,
                ];
                return response()->json($data);

            } elseif ($user_info->identifier == 'MNGR_') {
                $projects = DB::table('projects')
                    ->where('status', '=', 'ongoing')
                    ->where(function ($query) use ($user_id) {
                        $query->where('project_manager', $user_id)
                            ->orWhere('sub_project_manager', $user_id);
                    })
                    ->get();

                $managers = User::where('role', 'Manager')->get();
                $data = [
                    'projects' => $projects,
                    'managers' => $managers,
                ];
                return response()->json($data);
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
    public function store(Request $request)
    {
        //
        $projectName = $request->input('project_name');
        $projectDescription = $request->input('project_description');
        $projectManager = $request->input('project_manager');
        $subProjectManager = $request->input('sub_project_manager');
        if ($subProjectManager) {

            $user_manager = User::all()->where('employer_id', '=', $projectManager)->first();
            $sub_manager = User::all()->where('employer_id', '=', $subProjectManager)->first();

            try {
                $newProject = new Project();
                $newProject->project_manager = $user_manager->id;
                $newProject->sub_project_manager = $sub_manager->id;
                $newProject->project_title = $projectName;
                $newProject->project_description = $projectDescription;
                $newProject->save();

                return response()->json([
                    'error' => [
                        'title' => 'Success',
                        'info' => 'Project Created Successfully.',
                    ]
                ], 200);
            } catch (\Exception $e) {
                // Handle any other exceptions or errors that may occur
                return response()->json([
                    'error' => [
                        'title' => 'Error',
                        'info' => 'An error occurred while creating the project.',
                    ]
                ]);
            }
        } else {
            $user_manager = User::all()->where('employer_id', '=', $projectManager)->first();

            try {
                $newProject = new Project();
                $newProject->project_manager = $user_manager->id;
                $newProject->project_title = $projectName;
                $newProject->project_description = $projectDescription;
                $newProject->save();

                return response()->json([
                    'error' => [
                        'title' => 'Success',
                        'info' => 'Project Created Successfully.',
                    ]
                ], 200);
            } catch (\Exception $e) {
                // Handle any other exceptions or errors that may occur
                return response()->json([
                    'error' => [
                        'title' => 'Error',
                        'info' => 'An error occurred while creating the project.',
                    ]
                ]);
            }
        }
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
