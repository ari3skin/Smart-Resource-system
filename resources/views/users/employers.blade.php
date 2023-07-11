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
            <a class="tablinks" onclick="projectListing({{session('sys_id')}}); switchcommon(event, 'projects')"
               style="cursor: pointer" title="Projects">
                <i class="uil uil-clipboard-notes"></i>
                <span class="text">Projects</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'tasks')"
               style="cursor: pointer" title="tasks">
                <i class="uil uil-clipboard-notes"></i>
                <span class="text">Tasks</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'teams')"
               style="cursor: pointer" title="teams">
                <i class="uil uil-users-alt"></i>
                <span class="text">Teams</span>
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
                    <h3>--</h3>
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

            <button class="btn-download" onclick="selectedInterface()" style="border: none; cursor: pointer;">
                <i class="uil uil-plus-circle"></i>
                <span class="text">New Project</span>
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
                        <a class="active" href="#">Assigned Project Tasks</a>
                    </li>
                </ul>
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
                        <a class="active" href="#">Active Task Teams</a>
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

@section('modals')

    <div id="dashboard_modal" class="modal" style="z-index: 1500;">
        <div class="modal-content" style="margin: 8% 20%;">
            <span class="close project_close">&times;</span>
            <div class="dashboard-form">
                <h2 class="form-title">Create New Project</h2>
                <form method="POST" action="#" class="dashboard-form" id="create-project-form">
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
                        <input type="button" onclick="createProject()" name="signin" id="signin" class="form-submit"
                               value="Create Project"/>
                        <input type="reset" id="signin" class="form-submit" value="Reset Form">
                    </div>
                </form>
            </div>
        </div>
    </div>

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
