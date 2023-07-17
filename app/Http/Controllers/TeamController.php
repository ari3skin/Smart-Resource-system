<?php

namespace App\Http\Controllers;

use App\Mail\ProjectMails;
use App\Mail\TeamMails;
use App\Models\Employer;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($user_id)
    {
        //
        if (request()->route()->named('managers_teams')) {
            //fetching all the teams
            $memberRelationships = [];
            for ($i = 1; $i <= 5; $i++) {
                $memberRelationships["member$i"] = function ($query) {
                    $query->with(['employee' => function ($query) {
                        $query->select('id', 'first_name', 'last_name');
                    }]);
                };
            }

            $teams = Team::with(array_merge([
                'teamLeader' => function ($query) {
                    $query->with(['employer' => function ($query) {
                        $query->select('id', 'first_name', 'last_name');
                    }]);
                },
            ], $memberRelationships))
                ->where('team_leader', $user_id)
                ->where('team_status', '=', 'active')
                ->get();

            $teamInfo = Team::with(array_merge([
                'teamLeader' => function ($query) {
                    $query->with(['employer' => function ($query) {
                        $query->select('id', 'first_name', 'last_name');
                    }]);
                },
            ], $memberRelationships))
                ->where('team_status', '=', 'under_review')
                ->get();


            //fetching the data to populate the form
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
            //making an associative array to hold all the data and sending the response
            $data = [
                'teams' => $teams,
                'teamInfo' => $teamInfo,
                'managers' => [
                    'project_manager' => $main_managers,
                    'sub_project_managers' => $sub_managers,
                ],
                'employees' => $employees,
            ];
            return response()->json($data);

        } elseif (request()->route()->named('employee_teams')) {

//            dd($user_id);
            $memberRelationships = [];
            for ($i = 1; $i <= 5; $i++) {
                $memberRelationships["member$i.employee"] = function ($query) {
                    $query->select('id', 'first_name', 'last_name');
                };
            }
            $teams = Team::with(array_merge([
                'teamLeader' => function ($query) {
                    $query->with(['employer' => function ($query) {
                        $query->select('id', 'first_name', 'last_name');
                    }]);
                },
            ], $memberRelationships))->where(function ($query) use ($user_id) {
                $query->where('team_leader', $user_id);
                for ($i = 1; $i <= 5; $i++) {
                    $query->orWhere("member_$i", $user_id);
                }
            })->get();

            $data = [
                'teams' => $teams,
            ];
            return response()->json($data);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $teamLeaderCheck = $request->input('team_leader');
        $member1 = $request->input('member_1');
        $member2 = $request->input('member_1');
        $member3 = $request->input('member_1');
        $member4 = $request->input('member_1');
        $member5 = $request->input('member_1');

        if ($teamLeaderCheck && ($member1 || $member2 || $member3 || $member4 || $member5)) {
            try {
                $selectTeam = Team::where('team_leader', $request->input('team_leader'))
                    ->where(function ($query) {
                        $query->where('team_status', 'under_review')
                            ->orWhere('team_status', 'active');
                    })
                    ->first();


                $employer_name = User::join('employers', 'users.employer_id', '=', 'employers.id')
                    ->where('users.id', '=', $request->input('team_leader'))
                    ->select('employers.first_name', 'employers.last_name', 'employers.email')
                    ->first();

                if (!$selectTeam) {
                    $team = new Team();
                    $team->team_name = $request->input('team_name');
                    $team->team_leader = $request->input('team_leader');
                    $team->member_1 = $request->input('member_1');
                    $team->member_2 = $request->input('member_2');
                    $team->member_3 = $request->input('member_3');
                    $team->member_4 = $request->input('member_4');
                    $team->member_5 = $request->input('member_5');
                    $team->save();

                    $lastID = DB::getPdo()->lastInsertId();
                    $teamInfo = Team::all()->where('id', '=', $lastID)->first();

                    $emails = new Collection();
                    $names = new Collection();

                    for ($i = 1; $i <= 5; $i++) {
                        $memberId = $request->input('member_' . $i);
                        if ($memberId) {
                            $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
                                ->where('users.id', '=', $memberId)
                                ->select('employees.email', 'employees.first_name', 'employees.last_name')
                                ->first();

                            if ($employee) {
                                $emails->push($employee->email);
                                $names->push($employee->first_name . ' ' . $employee->last_name);
                            }
                        }
                    }
                    $emails->push($employer_name->email);
                    $type = "create_team";
                    try {
                        foreach ($emails as $email) {
                            Mail::to($email)->send(new TeamMails($employer_name, $names, $teamInfo, $type));
                        }

                        return response()->json([
                            'info' => [
                                'title' => 'Success',
                                'description' => 'Your team has been created successfully and all members have been notified via email
                                 The team is currently under review thus kindly check your email after 1 working day for further instructions ',
                            ]
                        ]);
                    } catch (\Exception $e) {
                        return response()->json([
                            'info' => [
                                'title' => 'Error',
                                'description' => 'An error occurred while sending emails.',
                            ]
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'info' => [
                            'title' => 'Error',
                            'description' =>
                                'The selected Team Leader ' . $employer_name->first_name . " " . $employer_name->last_name .
                                ' already has been assigned a team',
                        ]
                    ], 400);
                }

            } catch (\Exception $e) {
                return response()->json([
                    'info' => [
                        'title' => 'Error',
                        'description' => $e,
                    ]
                ], 400);
            }
        } else {
            return response()->json([
                'info' => [
                    'title' => 'Error',
                    'description' => "No Team Manager or at least one member selected",
                ]
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        //
        $team_id = $request->input('id');
        $update_type = $request->input('action');
        $team_leader = $request->input('team_leader');
        try {
            if ($update_type == "approve_team") {
                $status_type = "active";
                $type = "approve_team";
                $this->updateTeamStatusCommon($team_id, $team_leader, $status_type, $type);
                $info = [
                    'title' => 'Success',
                    'description' => 'Team Status Approved Successfully. Notification emails sent successfully',
                ];
                return response()->json($info);

            } elseif ($update_type == "reject_team") {
                $status_type = "disbanded";
                $type = "reject_team";
                $this->updateTeamStatusCommon($team_id, $team_leader, $status_type, $type);
                $info = [
                    'title' => 'Success',
                    'description' => 'Team Status Rejected Successfully. Notification emails sent successfully',
                ];
                return response()->json($info);
            }
        } catch (\Exception $e) {
            return response()->json([
                'info' => [
                    'title' => 'Warning',
                    'description' => 'Database error: ' . $e->getMessage(),
                ]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateTeamStatusCommon($team_id, $team_leader, $status_type, $type): void
    {
        $team = Team::find($team_id);
        $team->team_status = $status_type;
        $team->save();

        $user_info = User::findOrFail($team_leader);
        $employer = Employer::findOrFail($user_info->employer_id);
        $names = new Collection();
        $emails = new Collection();

        for ($i = 1; $i <= 5; $i++) {
            $memberColumn = 'member_' . $i;
            $memberId = $team->$memberColumn;
            if ($memberId) {
                $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
                    ->where('users.id', '=', $memberId)
                    ->select('employees.email', 'employees.first_name', 'employees.last_name')
                    ->first();

                if ($employee) {
                    $emails->push($employee->email);
                    $names->push($employee->first_name . ' ' . $employee->last_name);
                }
            }
        }
        $emails->push($employer->email);

        foreach ($emails as $email) {
            Mail::to($email)->send(new TeamMails($employer, $names, $team, $type));
        }
    }
}
