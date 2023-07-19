@extends('layouts.dashboard')

@section('nav-content')
    <ul class="side-menu top">
        <li class="active">
            <a class="tablinks" id="defaultOpen" onclick="switchcommon(event, 'dashboard')"
               style="cursor: pointer" title="Dashboard">
                <i class="uil uil-estate"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="taskListing(this,{{session('sys_id')}}); switchcommon(event, 'tasks')"
               style="cursor: pointer" title="tasks" id="employees_tasks" data-sys-id="{{session('sys_id')}}">
                <i class="uil uil-clipboard-notes"></i>
                <span class="text">Tasks</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="teamListing(this, {{session('sys_id')}}); switchcommon(event, 'teams')"
               style="cursor: pointer" title="teams" id="employees_teams">
                <i class="uil uil-users-alt"></i>
                <span class="text">Teams</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="reportListing(this,{{session('sys_id')}}); switchcommon(event, 'reports')"
               style="cursor: pointer" title="teams" id="employee_reports">
                <i class="uil uil-file-graph"></i>
                <span class="text">Reports</span>
            </a>
        </li>

        <li style="display: none">
            <a class="tablinks" onclick="switchcommon(event, 'settings')"
               style="cursor: pointer" title="Settings">
                <i class="uil uil-setting"></i>
                <span class="text">Settings</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu">
        <li id="logout_btn" onclick="logoutModal()">
            <a style="cursor: pointer" class="logout" title="Logout">
                <i class="uil uil-signout"></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
@endsection

@section('dashboard-content')
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
                        <a class="active" href="#">Home</a>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="box-info">
            <li>
                <a style="cursor: pointer" title="">
                    <i class="uil uil-constructor"></i>
                </a>
                <div class="text">
                    <h3>{{$tasksCount}}</h3>
                    <p>Ongoing Individual Tasks</p>
                </div>
            </li>

            <li>
                <a style="cursor: pointer" title="">
                    <i class="uil uil-constructor"></i>
                </a>
                <div class="text">
                    <h3>{{$teamsCount}}</h3>
                    <p>Active Designated Teams</p>
                </div>
            </li>
        </ul>
    </main>

    <main class="tabcontent" id="tasks">
        <div class="head-title">
            <div class="left">
                <h1>Project Tasks</h1>

                <ul class="breadcrumb">
                    <li>
                        <a href="#">{{session('first_name')}} {{session('last_name')}}</a>
                    </li>
                    <li><i class="uil uil-angle-right-b"></i></li>
                    <li>
                        <a class="active" href="#">Ongoing Assigned Project Tasks</a>
                    </li>
                </ul>
            </div>

            <button class="btn-download" onclick="selectedInterface(this)" style="border: none; cursor: pointer;"
                    id="new_task_report">
                <i class="uil uil-plus-circle"></i>
                <span class="text">New Task Report</span>
            </button>
        </div>

        <div class="table-data">
            <div class="order">
                <div class="filter-wrapper">
                    <label>
                        Project Filter:
                        <select id="projectFilter">
                            <option value="">All Reports</option>
                        </select>
                    </label>
                </div>
                <table id="tableData">
                    <thead>
                    <tr>
                        <th>Project Title</th>
                        <th>Task Title</th>
                        <th>Task Description</th>
                        <th>Assigned To</th>
                    </tr>
                    </thead>

                    <tbody id="task_table"></tbody>
                </table>
            </div>
        </div>
    </main>

    <main class="tabcontent" id="teams">
        <div class="head-title">
            <div class="left">
                <h1>Project Teams</h1>

                <ul class="breadcrumb">
                    <li>
                        <a href="#">{{session('first_name')}} {{session('last_name')}}</a>
                    </li>
                    <li><i class="uil uil-angle-right-b"></i></li>
                    <li>
                        <a class="active" href="#">Active Project/Task Teams</a>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="box-info" style="grid-template-columns: repeat(3, minmax(240px, 1fr));" id="team-list"></ul>
    </main>

    <main class="tabcontent" id="reports">
        <div class="head-title">
            <div class="left">
                <h1>Project Documentations</h1>

                <ul class="breadcrumb">
                    <li>
                        <a href="#">{{session('first_name')}} {{session('last_name')}}</a>
                    </li>
                    <li><i class="uil uil-angle-right-b"></i></li>
                    <li>
                        <a class="active" href="#">Submitted Documentations and Reports</a>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="box-info" id="report-list"></ul>
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
    </main>
@endsection

@section('create_form_modals')
    <div id="new_task_report_modal" class="modal" style="z-index: 1500;">
        <div class="modal-content" style="margin: 2% 25%; width: 50%;">
            <span class="close task_report_close">&times;</span>
            <div class="dashboard-form">
                <h2 class="form-title">New Task Report</h2>
                <form method="POST" class="dashboard-form" id="create-task-report-form" autocomplete="off"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="my_tasks"><i class="uil uil-file-plus-alt"></i></label>
                        <select name="my_task" id="my_tasks" required></select>
                    </div>
                    <div class="form-group">
                        <label for="team-name"><i class="uil uil-file-plus-alt"></i></label>
                        <input type="text" name="report_title" id="team-name" placeholder="Task Report title"/>
                    </div>
                    <div class="form-group">
                        <label for="report_summary"><i class="uil uil-file-plus-alt"></i></label>
                        <textarea rows="5" cols="80" name="report_summary" id="report_summary"
                                  placeholder="Task Report Summary"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="report_file"><i class="uil uil-file-plus-alt"></i></label>
                        <input type="file" name="report_file" accept="application/pdf" id="report_file"
                               placeholder="Select PDF file">
                    </div>
                    <div style="display: flex; justify-content: space-evenly;">
                        <input type="hidden" name="account_type" value="employees">
                        <input type="hidden" name="report_type" value="task_report">
                        <input type="hidden" name="submitter" value="{{session('sys_id')}}">
                        <input type="button" onclick="createItem(this)" name="signin" id="create_task_report"
                               class="form-submit" value="Create Report" style="margin: 0 20px;"/>
                        <input type="reset" id="signin" class="form-submit" value="Reset Form" style="margin: 0 20px;">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('logout')
    <div id="confirm_logout" class="modal">
        <div class="modal-content">
            <span class="close logout_close">&times;</span>
            <p class="modal__text__error">
                <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
                Warning
                <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
            </p>
            <p class="modal__text">You are about to logout</p>
            <a href="/auth/logout" class="modal_button" title="Logout">
                <i class="uil uil-signout"></i>
                <span class="text">Logout</span>
            </a>
        </div>
    </div>
@endsection
