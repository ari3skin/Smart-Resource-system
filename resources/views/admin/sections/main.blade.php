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
                <h3>--</h3>
                <p>Open Projects</p>
            </div>
        </li>
    </ul>
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
                    <a class="active" href="#">Proposed Projects</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="box-info" style="grid-template-columns: repeat(3, minmax(240px, 1fr));">
        <li>
            <div>
                PID.101
            </div>
            <div class="text">
                <h3>Auditing South Africa</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat ante vel massa vulputate, at
                    dignissim lectus volutpat. Sed interdum felis ac suscipit interdum. In aliquam tellus in efficitur
                    bibendum. Quisque congue sollicitudin eros, non pharetra enim lacinia nec. Proin semper posuere
                    erat, ac tincidunt ex auctor non. Nulla facilisi. Nulla facilisis dui vitae finibus auctor. Nulla
                    consectetur accumsan tellus vitae placerat.
                </p>
            </div>
        </li>

        <li>
            <div>
                PID.102
            </div>
            <div class="text">
                <h3>Auditing Namibia</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat ante vel massa vulputate, at
                    dignissim lectus volutpat. Sed interdum felis ac suscipit interdum. In aliquam tellus in efficitur
                    bibendum. Quisque congue sollicitudin eros, non pharetra enim lacinia nec. Proin semper posuere
                    erat, ac tincidunt ex auctor non. Nulla facilisi. Nulla facilisis dui vitae finibus auctor. Nulla
                    consectetur accumsan tellus vitae placerat.
                </p>
            </div>
        </li>

        <li>
            <div>
                PID.103
            </div>
            <div class="text">
                <h3>Auditing Kenya</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat ante vel massa vulputate, at
                    dignissim lectus volutpat. Sed interdum felis ac suscipit interdum. In aliquam tellus in efficitur
                    bibendum. Quisque congue sollicitudin eros, non pharetra enim lacinia nec. Proin semper posuere
                    erat, ac tincidunt ex auctor non. Nulla facilisi. Nulla facilisis dui vitae finibus auctor. Nulla
                    consectetur accumsan tellus vitae placerat.
                </p>
            </div>
        </li>

        <li>
            <div>
                PID.104
            </div>
            <div class="text">
                <h3>Auditing Nigeria</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat ante vel massa vulputate, at
                    dignissim lectus volutpat. Sed interdum felis ac suscipit interdum. In aliquam tellus in efficitur
                    bibendum. Quisque congue sollicitudin eros, non pharetra enim lacinia nec. Proin semper posuere
                    erat, ac tincidunt ex auctor non. Nulla facilisi. Nulla facilisis dui vitae finibus auctor. Nulla
                    consectetur accumsan tellus vitae placerat.
                </p>
            </div>
        </li>

        <li>
            <div>
                PID.105
            </div>
            <div class="text">
                <h3>Auditing Uganda</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat ante vel massa vulputate, at
                    dignissim lectus volutpat. Sed interdum felis ac suscipit interdum. In aliquam tellus in efficitur
                    bibendum. Quisque congue sollicitudin eros, non pharetra enim lacinia nec. Proin semper posuere
                    erat, ac tincidunt ex auctor non. Nulla facilisi. Nulla facilisis dui vitae finibus auctor. Nulla
                    consectetur accumsan tellus vitae placerat.
                </p>
            </div>
        </li>
    </ul>

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
