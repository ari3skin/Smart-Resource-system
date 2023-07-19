<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($user_id)
    {
        //
        if (request()->route()->named('managers_reports')) {
            $user = User::with(['employer', 'employee'])->find($user_id);
            $department_id = $user->employer ? $user->employer->department_id : $user->employee->department_id;

            $reports = Report::with([
                'submitter' => function ($query) {
                    $query->with(['employer:id,first_name,last_name', 'employee:id,first_name,last_name']);
                }, 'project', 'task',
            ])->where('submitter_id', '=', $user_id)
                ->whereHas('project', function ($query) use ($department_id) {
                    $query->where('department_id', $department_id);
                })->orWhereHas('task', function ($query) use ($department_id) {
                    $query->whereHas('project', function ($query) use ($department_id) {
                        $query->where('department_id', $department_id);
                    });
                })->get();

            $reports = $reports->map(function ($report) {

                $fileUrl = $report->report_file ? Storage::url($report->report_file) : null;

                return [
                    'report' => $report,
                    'file_url' => $fileUrl, // Add the file URL to the returned data
                ];
            });

            $data = [
                'reports' => $reports
            ];
            return response()->json($data);

        } elseif (request()->route()->named('employee_reports')) {

            $user = User::with(['employer', 'employee'])->find($user_id);
            $department_id = $user->employer ? $user->employer->department_id : $user->employee->department_id;

            $team_ids = Team::where('member_1', $user_id)
                ->orWhere('member_2', $user_id)
                ->orWhere('member_3', $user_id)
                ->orWhere('member_4', $user_id)
                ->orWhere('member_5', $user_id)
                ->pluck('team_leader')
                ->toArray();

            $reports = Report::with([
                'submitter' => function ($query) {
                    $query->with(['employer:id,first_name,last_name', 'employee:id,first_name,last_name']);
                }, 'project', 'task',
            ])->where(function ($query) use ($user_id, $team_ids) {
                $query->whereHas('task', function ($query) use ($user_id) {
                    $query->where('task_individual_user', $user_id);
                })->orWhereHas('task', function ($query) use ($team_ids) {
                    $query->whereIn('task_team_manager', $team_ids);
                });
            })->get();

            $reports = $reports->map(function ($report) {
                $fileUrl = $report->report_file ? Storage::url($report->report_file) : null;
                return [
                    'report' => $report,
                    'file_url' => $fileUrl,
                ];
            });

            $data = [
                'reports' => $reports
            ];
            return response()->json($data);


        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function store(Request $request)
    {
        //
        try {
            $account_type = $request->input('account_type');

            if ($account_type == "employers") {

                $validator = $request->validate([
                    'report_file' => 'required|mimes:pdf',
                ]);

                if ($validator) {
                    try {

                        $report_type = $request->input('report_type');

                        if ($report_type == 'project_documentation') {
                            $newReport = new Report();

                            $user_id = $request->input('submitter');
                            $timeStamp = Carbon::now()->format('d-m-Y-H-i-s');
                            $file_name = $user_id . "_" . $timeStamp;
                            $filePath = 'public/reports/employers/project_documentations/' . $file_name . '.pdf';
                            $fileContents = file_get_contents($request->file('report_file'));
                            Storage::put($filePath, $fileContents);

                            $newReport->submitter_id = $user_id;
                            $newReport->project_id = $request->input('my_projects');
                            $newReport->task_id = null;
                            $newReport->report_type = "project_documentation";
                            $newReport->report_title = $request->input('report_title');
                            $newReport->report_summary = $request->input('report_summary');
                            $newReport->report_file = $filePath;
                            $newReport->save();

                            return response()->json([
                                'info' => [
                                    'title' => 'Success',
                                    'description' => 'Your Project Documentation has successfully been made',
                                ]
                            ]);
                        } elseif ($report_type == "task_report") {
                            $newReport = new Report();

                            $user_id = $request->input('submitter');
                            $timeStamp = Carbon::now()->format('d-m-Y-H-i-s');
                            $file_name = $user_id . "_" . $timeStamp;
                            $filePath = 'public/reports/employers/task_reports/' . $file_name . '.pdf';
                            $fileContents = file_get_contents($request->file('report_file'));
                            Storage::put($filePath, $fileContents);

                            $newReport->submitter_id = $user_id;
                            $newReport->project_id = null;
                            $newReport->task_id = $request->input('my_task');
                            $newReport->report_type = "task_report";
                            $newReport->report_title = $request->input('report_title');
                            $newReport->report_summary = $request->input('report_summary');
                            $newReport->report_file = $filePath;
                            $newReport->save();

                            return response()->json([
                                'info' => [
                                    'title' => 'Success',
                                    'description' => 'Your Task Report has successfully been made',
                                ]
                            ]);
                        }

                    } catch (\Exception $e) {

                        return response()->json([
                            'info' => [
                                'title' => 'Error',
                                'description' => 'Database error: ' . $e->getMessage(),
                            ]
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'info' => [
                            'title' => 'Warning',
                            'description' => 'The requested file type is invalid',
                        ]
                    ], 400);
                }
            } elseif ($account_type == "employees") {

                $validator = $request->validate([
                    'report_file' => 'required|mimes:pdf',
                ]);

                if ($validator) {

                    $report_type = $request->input('report_type');
                    if ($report_type == "task_report") {
                        $newReport = new Report();

                        $user_id = $request->input('submitter');
                        $timeStamp = Carbon::now()->format('d-m-Y-H-i-s');
                        $file_name = $user_id . "_" . $timeStamp;
                        $filePath = 'public/reports/employees/task_reports/' . $file_name . '.pdf';
                        $fileContents = file_get_contents($request->file('report_file'));
                        Storage::put($filePath, $fileContents);

                        $newReport->submitter_id = $user_id;
                        $newReport->project_id = null;
                        $newReport->task_id = $request->input('my_task');
                        $newReport->report_type = "task_report";
                        $newReport->report_title = $request->input('report_title');
                        $newReport->report_summary = $request->input('report_summary');
                        $newReport->report_file = $filePath;
                        $newReport->save();

                        return response()->json([
                            'info' => [
                                'title' => 'Success',
                                'description' => 'Your Task Report has successfully been made',
                            ]
                        ]);
                    } else {
                        return response()->json([
                            'info' => [
                                'title' => 'Warning',
                                'description' => 'You are not allowed to submit any other report type',
                            ]
                        ], 400);
                    }

                } else {
                    return response()->json([
                        'info' => [
                            'title' => 'Warning',
                            'description' => 'The requested file type is invalid',
                        ]
                    ], 400);
                }
            }
        } catch (\Exception $e) {

            return response()->json([
                'info' => [
                    'title' => 'Error',
                    'description' => 'Error: ' . $e->getMessage(),
                ]
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public
    function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public
    function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Report $report)
    {
        //
    }
}
