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

        <li class="active">
            <a class="tablinks" onclick="projectListing(this, {{session('sys_id')}}); switchcommon(event, 'projects')"
               style="cursor: pointer" title="Projects" id="employers_projects">
                <i class="uil uil-clipboard-notes"></i>
                <span class="text">Projects</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="taskListing(this,{{session('sys_id')}}); switchcommon(event, 'tasks')"
               style="cursor: pointer" title="tasks" id="employers_tasks" data-sys-id="{{session('sys_id')}}">
                <i class="uil uil-clipboard-notes"></i>
                <span class="text">Tasks</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="teamListing(this, {{session('sys_id')}}); switchcommon(event, 'teams')"
               style="cursor: pointer" title="teams" id="employers_team">
                <i class="uil uil-users-alt"></i>
                <span class="text">Teams</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'reports')"
               style="cursor: pointer" title="teams">
                <i class="uil uil-file-graph"></i>
                <span class="text">Reports</span>
            </a>
        </li>

        <li>
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
                    <h3>{{$projectsCount}}</h3>
                    <p>Ongoing Designated Projects</p>
                </div>
            </li>

            <li>
                <a style="cursor: pointer" title="">
                    <i class="uil uil-constructor"></i>
                </a>
                <div class="text">
                    <h3>{{$teamsCount}}</h3>
                    <p>Assigned Teams</p>
                </div>
            </li>
        </ul>
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
                        <a class="active" href="#">My Ongoing Projects</a>
                    </li>
                </ul>
            </div>

            <button class="btn-download" onclick="selectedInterface(this)" style="border: none; cursor: pointer;"
                    id="new_project">
                <i class="uil uil-plus-circle"></i>
                <span class="text">New Project</span>
            </button>

            <button class="btn-download" onclick="" style="border: none; cursor: pointer;"
                    id="new_project_report">
                <i class="uil uil-plus-circle"></i>
                <span class="text">New Project Documentation</span>
            </button>
        </div>

        <ul class="box-info" style="grid-template-columns: repeat(3, minmax(240px, 1fr));" id="project-list"></ul>

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
                    id="new_task">
                <i class="uil uil-plus-circle"></i>
                <span class="text">New Task</span>
            </button>

            <button class="btn-download" onclick="selectedInterface(this)" style="border: none; cursor: pointer;"
                    id="new_task_report">
                <i class="uil uil-plus-circle"></i>
                <span class="text">New Task Report</span>
            </button>
        </div>

        <div class="table-data">
            <div class="order">
                <label style="margin: 0 210px;">
                    Project Filter:
                    <select id="projectFilter">
                        <option value="">All Projects</option>
                    </select>
                </label>
                <table id="tableData">
                    <thead>
                    <tr>
                        <th>Project Title</th>
                        <th>Task Title</th>
                        <th>Task Description</th>
                        <th>Assigned To</th>
                        <th>Task Type</th>
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

            <button class="btn-download" onclick="selectedInterface(this)" style="border: none; cursor: pointer;"
                    id="new_team">
                <i class="uil uil-plus-circle"></i>
                <span class="text">New Team</span>
            </button>
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

    <div id="new_project_modal" class="modal" style="z-index: 1500;">
        <div class="modal-content" style="margin: 6% 20%;">
            <span class="close project_close">&times;</span>
            <div class="dashboard-form">
                <h2 class="form-title">Create New Project</h2>
                <form method="POST" action="#" class="dashboard-form" id="create-project-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="project-name"><i class="uil uil-file-plus-alt"></i></label>
                        <input type="text" name="project_name" id="project-name" placeholder="Project Name" required/>
                    </div>
                    <div class="form-group">
                        <label for="project-description"><i class="uil uil-file-plus-alt"></i></label>
                        <textarea rows="5" cols="80" name="project_description" id="project-description"
                                  placeholder="Project Description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="project-manager"><i class="uil uil-user-plus"></i></label>
                        <select name="project_manager" id="project-manager" required></select>
                    </div>
                    <div class="form-group">
                        <label for="sub-project-manager"><i class="uil uil-user-plus"></i></label>
                        <select name="sub_project_manager" id="sub-project-manager" required></select>
                    </div>
                    <div>
                        <input type="button" onclick="createItem(this)" name="signin" id="create_project"
                               class="form-submit" value="Create Project"/>
                        <input type="reset" id="signin" class="form-submit" value="Reset Form">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="new_task_modal" class="modal" style="z-index: 1500;">
        <div class="modal-content" style="margin: 2% 25%; width: 50%;">
            <span class="close task_close">&times;</span>
            <div class="dashboard-form">
                <h2 class="form-title">Create New Task</h2>
                <form method="POST" class="dashboard-form" id="create-task-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="project"><i class="uil uil-file-plus-alt"></i></label>
                        <select name="project_id" id="project" required></select>
                    </div>
                    <div class="form-group">
                        <label for="task-name"><i class="uil uil-file-plus-alt"></i></label>
                        <input type="text" name="task_title" id="task-name" placeholder="Task Title" required/>
                    </div>
                    <div class="form-group">
                        <label for="task-description"><i class="uil uil-file-plus-alt"></i></label>
                        <textarea rows="5" cols="80" name="task_description" id="task-description"
                                  placeholder="Task Description" required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <input type="checkbox" name="type_team" id="teamManager" value="team" class="agree-term"
                                   style="width: 20px; margin-left: 140px;"/>
                            <label for="teamManager" class="label-agree-term">Team task ?</label>
                        </div>
                        <span id="team_notice" style="margin: 5px 20px; color: var(--first-color);"></span>
                        <div class="form-group" style="align-items: center;">
                            <input type="checkbox" name="type_individual" id="individual" value="individual"
                                   class="agree-term"
                                   style="width: 20px; margin-left: 140px;"/>
                            <label for="individual" class="label-agree-term">Individual task ?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="task-team-manager"><i class="uil uil-user-plus"></i></label>
                        <select name="task_team_manager" id="task-team-manager" required></select>
                    </div>
                    <div class="form-group">
                        <label for="task-manager-individual"><i class="uil uil-user-plus"></i></label>
                        <select name="task_manager_individual" id="task-manager-individual" required></select>
                    </div>
                    <div class="form-group">
                        <label for="task-employee-individual"><i class="uil uil-user-plus"></i></label>
                        <select name="task_employee_individual" id="task-employee-individual" required></select>
                    </div>
                    <div>
                        <input type="button" onclick="createItem(this)" name="signin" id="create_task"
                               class="form-submit"
                               value="Create Task"/>
                        <input type="reset" id="signin" class="form-submit" value="Reset Form">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="new_team_modal" class="modal" style="z-index: 1500;">
        <div class="modal-content" style="margin: 2% 25%; width: 50%;">
            <span class="close team_close">&times;</span>
            <div class="dashboard-form">
                <h2 class="form-title">Create New Team</h2>
                <form method="POST" class="dashboard-form" id="create-team-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="team-name"><i class="uil uil-file-plus-alt"></i></label>
                        <input type="text" name="team_name" id="team-name" placeholder="Team Name" required/>
                    </div>
                    <div class="form-group">
                        <label for="team_leader"><i class="uil uil-user-plus"></i></label>
                        <select name="team_leader" id="team_leader" required></select>
                    </div>
                    <div class="form-group">
                        <label for="member1"><i class="uil uil-user-plus"></i></label>
                        <select name="member_1" id="member1" class="member" required></select>
                    </div>
                    <div class="form-group">
                        <label for="member2"><i class="uil uil-user-plus"></i></label>
                        <select name="member_2" id="member2" class="member" required></select>
                    </div>
                    <div class="form-group">
                        <label for="member3"><i class="uil uil-user-plus"></i></label>
                        <select name="member_3" id="member3" class="member" required></select>
                    </div>
                    <div class="form-group">
                        <label for="member4"><i class="uil uil-user-plus"></i></label>
                        <select name="member_4" id="member4" class="member" required></select>
                    </div>
                    <div class="form-group">
                        <label for="member5"><i class="uil uil-user-plus"></i></label>
                        <select name="member_5" id="member5" class="member" required></select>
                    </div>
                    <div>
                        <input type="button" onclick="createItem(this)" name="signin" id="create_team"
                               class="form-submit"
                               value="Create Team"/>
                        <input type="reset" id="signin" class="form-submit" value="Reset Form">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="new_task_report_modal" class="modal" style="z-index: 1500;">
        <div class="modal-content" style="margin: 2% 25%; width: 50%;">
            <span class="close task_report_close">&times;</span>
            <div class="dashboard-form">
                <h2 class="form-title">New Task Report</h2>
                <form method="POST" class="dashboard-form" id="create-team-form" autocomplete="off">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection

@section('other_form_modals')

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
