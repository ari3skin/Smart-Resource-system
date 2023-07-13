<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

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
                $team = new Team();
                $team->team_name = $request->input('team_name');
                $team->team_leader = $request->input('team_leader');
                $team->member_1 = $request->input('member_1');
                $team->member_2 = $request->input('member_2');
                $team->member_3 = $request->input('member_3');
                $team->member_4 = $request->input('member_4');
                $team->member_5 = $request->input('member_5');
                $team->save();

                return response()->json([
                    'info' => [
                        'title' => 'Success',
                        'description' => 'Team Created Successfully.',
                    ]
                ]);

            } catch (\Exception $e) {
                // Handle any other exceptions or errors that may occur
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
