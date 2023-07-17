<?php

namespace App\Http\Controllers;

use App\Mail\ProjectMails;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $currentUsersDepartmentId = User::find($user_id)->employer->department->id;

        if (request()->route()->named('projectInfo')) {

            if ($user_info->identifier == 'ADM_') {
                $projects = Project::where('status', 'under_review')
                    ->with([
                        'manager.employer.department'
                    ])
                    ->get();

                $data = [
                    'projects' => $projects,
                ];

                return response()->json($data);

            } elseif ($user_info->identifier == 'MNGR_') {

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

                $managers = User::where('role', 'Manager')
                    ->whereHas('employer', function ($query) use ($currentUsersDepartmentId) {
                        $query->where('department_id', $currentUsersDepartmentId);
                    })
                    ->with('employer')
                    ->get();

                $data = [
                    'projects' => $projects,
                    'managers' => $managers,
                ];
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Project not found']);
            }
        } else {
            return response()->json(['error' => 'Unauthorized Access']);
        }
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

        $user_manager = User::where('id', $projectManager)->first();

        if (!$user_manager) {
            return response()->json([
                'info' => [
                    'title' => 'Error',
                    'description' => 'Project manager not found.',
                ]
            ], 400);
        }

        // Get the department_id from the project manager's employer
        $department_id = $user_manager->employer->department_id;

        $sub_manager = null;

        if ($subProjectManager) {
            $sub_manager = User::where('id', $subProjectManager)->first();

            if (!$sub_manager) {
                return response()->json([
                    'info' => [
                        'title' => 'Error',
                        'description' => 'Sub project manager not found.',
                    ]
                ], 400);
            }
        }

        try {
            $newProject = new Project();
            $newProject->project_manager = $user_manager->id;
            $newProject->sub_project_manager = $sub_manager ? $sub_manager->id : null;
            $newProject->project_title = $projectName;
            $newProject->project_description = $projectDescription;
            // Set the department_id on the project
            $newProject->department_id = $department_id;
            $newProject->save();

            return response()->json([
                'info' => [
                    'title' => 'Success',
                    'description' => 'Project Created Successfully.
                                      The Selected Project Manager will receive further instructions
                                      concerning the created project',
                ]
            ]);
        } catch (\Exception $e) {
            // Handle any other exceptions or errors that may occur
            return response()->json([
                'info' => [
                    'title' => 'Error',
                    'description' => 'An error occurred while creating the project.',
                ]
            ], 400);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        //
        $project_id = $request->input('id');
        $update_type = $request->input('action');
        $project_manager = $request->input('project_manager');

        try {
            if ($update_type == "approve_project") {
                $project = Project::find($project_id);
                $project->status = 'ongoing';
                $project->save();

                $employer = Employer::findOrFail($project_manager);
                $type = "approve_project";
                Mail::to($employer->email)->send(new ProjectMails($employer, $type, $project));

                return response()->json([
                    'info' => [
                        'title' => 'Success',
                        'description' => 'Project Status Approved Successfully. Notification email sent successfully',
                    ]
                ]);
            } elseif ($update_type == "reject_project") {
                $project = Project::find($project_id);
                $project->status = 'rejected';
                $project->save();

                $employer = Employer::findOrFail($project_manager);
                $type = "reject_project";
                Mail::to($employer->email)->send(new ProjectMails($employer, $type, $project));

                return response()->json([
                    'info' => [
                        'title' => 'Success',
                        'description' => 'Project Status Rejected Successfully.Notification email sent successfully',
                    ]
                ]);
            } else {
                return response()->json([
                    'info' => [
                        'title' => 'Warning',
                        'description' => 'Invalid update type.',
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'info' => [
                    'title' => 'Error',
                    'description' => 'Database error: ' . $e->getMessage(),
                ]
            ], 500);
        }
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
