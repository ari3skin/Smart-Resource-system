@php
    use Illuminate\Support\Facades\DB;
@endphp
<main class="tabcontent" id="dashboard">
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>

            <ul class="breadcrumb">
                <li>
                    <a href="#">{{session('first_name')}} {{session('last_name')}}</a>
                </li>
                <li><i class="uil uil-angle-right-b"></i></li>
                <li>
                    <a class="active" href="#">Summaries</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        <li>
            <a style="cursor: pointer" title="Registrations">
                <i class="uil uil-clipboard-alt"></i>
            </a>
            <div class="text">
                <h3>{{$requestsCount}} pending</h3>
                <p>Registration Requests</p>
            </div>
        </li>

        <li>
            <a style="cursor: pointer" title="Registrations">
                <i class="uil uil-clipboard-alt"></i>
            </a>
            <div class="text">
                <h3>{{$usersCount}}</h3>
                <p>User Accounts</p>
            </div>
        </li>

        <li>
            <a style="cursor: pointer" title="Company Employees">
                <i class="uil uil-user-square"></i>
            </a>
            <div class="text">
                <h3>{{$employeesCount}}</h3>
                <p>Available Employees</p>
            </div>
        </li>

        <li>
            <a style="cursor: pointer" title="Company Employers">
                <i class="uil uil-user-md"></i>
            </a>
            <div class="text">
                <h3>{{$employersCount}}</h3>
                <p>Available Employers</p>
            </div>
        </li>

        <li>
            <a style="cursor: pointer" title="Project Aprovals">
                <i class="uil uil-clipboard-notes"></i>
            </a>
            <div class="text">
                <h3>{{$projectsCount}}</h3>
                <p>Open Projects</p>
            </div>
        </li>
    </ul>

    {{--<div class="data_visuals">--}}
    {{--<div class="chart-container">--}}
    {{--<canvas id="open-projects-chart"></canvas>--}}
    {{--</div>--}}
    {{--</div>--}}

</main>

<main class="tabcontent" id="registration-request">
    <div class="head-title">
        <div class="left">
            <h1>Registration Requests</h1>

            <ul class="breadcrumb">
                <li>
                    <a href="#">{{session('first_name')}} {{session('last_name')}}</a>
                </li>
                <li><i class="uil uil-angle-right-b"></i></li>
                <li>
                    <a class="active" href="#">Sent Registration Requests</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <table id="tableData">
                <thead>
                <tr>
                    <th>Employer Id</th>
                    <th>Employee Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Work Email</th>
                    <th>Request Date</th>
                    <th>Approve</th>
                </tr>
                </thead>
                <tbody>
                @foreach($registration_requests as $item)
                    <tr style="border-bottom: solid var(--title-color) 1px">
                        @php
                            $userInfo = DB::table('user_registration_requests')
                                ->select('user_registration_requests.employer_id', 'user_registration_requests.employee_id',
                                         'employers.first_name as emlr_first', 'employers.last_name as emlr_last',
                                         'employees.first_name as emle_first', 'employees.last_name as emle_last',
                                         'employers.identifier as MNG_', 'employees.identifier as EMP_',
                                         'user_registration_requests.work_email', 'user_registration_requests.request_date', 'user_registration_requests.status')
                                ->leftJoin('employers', 'user_registration_requests.work_email', '=', 'employers.email')
                                ->leftJoin('employees', 'user_registration_requests.work_email', '=', 'employees.email')
                                ->where('user_registration_requests.work_email', '=', $item['work_email'])
                                ->first();
                            //store the respective data
                                $employerId = $userInfo->employer_id;
                                $employeeId = $userInfo->employee_id;
                                $employerRole = $userInfo->MNG_;
                                $employeeRole = $userInfo->EMP_;
                                $employerFirstName = $userInfo->emlr_first;
                                $employerLastName = $userInfo->emlr_last;
                                $employeeFirstName = $userInfo->emle_first;
                                $employeeLastName = $userInfo->emle_last;
                        @endphp

                        <td>
                            <p>{{$item->employer_id}}</p>
                        </td>
                        <td>
                            <p>{{$item->employee_id}}</p>
                        </td>
                        <td>
                            <p>{{$employerFirstName}}</p>
                            <p>{{$employeeFirstName}}</p>
                        </td>
                        <td>
                            <p>{{$employerLastName}}</p>
                            <p>{{$employeeLastName}}</p>
                        </td>
                        <td>{{$item->work_email}}</td>
                        <td>{{$item->request_date}}</td>
                        <td>
                            <form method="POST" action="/admin/creation/approved">
                                @csrf
                                <input type="hidden" name="request_mail" value="{{$item->work_email}}">
                                <input type="hidden" name="user_type" value="{{$employerRole}}{{$employeeRole}}">
                                <input type="hidden" name="status" value="approved">
                                <button type="submit">
                                    <i class="uil uil-envelope-check" style="cursor: pointer"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

<main class="tabcontent" id="projects">
    <div class="head-title">
        <div class="left">
            <h1>Projects</h1>

            <ul class="breadcrumb">
                <li>
                    <a href="#">{{session('first_name')}} {{session('last_name')}}</a>
                </li>
                <li><i class="uil uil-angle-right-b"></i></li>
                <li>
                    <a class="active" href="#">Projects Under Review</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="box-info empty-project" id="project-list"></ul>

</main>

<main class="tabcontent" id="reports">
    <div class="head-title">
        <div class="left">
            <h1>Reports</h1>

            <ul class="breadcrumb">
                <li>
                    <a href="#">{{session('first_name')}} {{session('last_name')}}</a>
                </li>
                <li><i class="uil uil-angle-right-b"></i></li>
                <li>
                    <a class="active" href="#">Submitted reports</a>
                </li>
            </ul>
        </div>
    </div>
</main>

<main class="tabcontent" id="settings">
    <div class="head-title">
        <div class="left">
            <h1>Settings</h1>

            <ul class="breadcrumb">
                <li>
                    <a href="#">{{session('first_name')}} {{session('last_name')}}</a>
                </li>
                <li><i class="uil uil-angle-right-b"></i></li>
                <li>
                    <a class="active" href="#">Setings</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        <li class="tablinks" onclick="switchcommon(event, 'reset_password')" style="cursor: pointer">
            <i class="uil uil-history-alt"></i>
            <div class="text">
                <p>Reset Your Password</p>
            </div>
        </li>

        <li class="tablinks" onclick="switchcommon(event, '')" style="cursor: pointer">
            <i class="uil uil-sliders-v-alt"></i>
            <div class="text">
                <p>User Settings</p>
            </div>
        </li>

        <li class="tablinks" onclick="switchcommon(event, 'new-employer')" style="cursor: pointer">
            <i class="uil uil-user-plus"></i>
            <div class="text">
                <p>Create new Employer</p>
            </div>
        </li>

        <li class="tablinks" onclick="switchcommon(event, 'new-employee')" style="cursor: pointer">
            <i class="uil uil-user-plus"></i>
            <div class="text">
                <p>Create new Employee</p>
            </div>
        </li>
    </ul>
</main>
