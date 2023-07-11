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
                <a class="tablinks" onclick="switchcommon(event, 'sent-messages')"
                   style="cursor: pointer" title="Sent Messages">
                    <i class="uil uil-constructor"></i>
                </a>
                <div class="text">
                    <h3>10</h3>
                    <p>Ongoing Employee Assigned Projects</p>
                </div>
            </li>

            <li>
                <a class="tablinks" onclick="switchcommon(event, 'verifications')"
                   style="cursor: pointer" title="Verifications">
                    <i class="uil uil-user-square"></i>
                </a>
                <div class="text">
                    <h3>10</h3>
                    <p>Available Employees</p>
                </div>
            </li>

            <li>
                <a class="tablinks" onclick="switchcommon(event, 'to-do')"
                   style="cursor: pointer" title="To Do">
                    <i class="uil uil-clipboard-notes"></i>
                </a>
                <div class="text">
                    <h3>10</h3>
                    <p>Open Projects</p>
                </div>
            </li>

            <li>
                <a class="tablinks" onclick="switchcommon(event, 'chat-zone')"
                   style="cursor: pointer" title="Chat Zone">
                    <i class="uil uil-comments-alt"></i>
                </a>
                <div class="text">
                    <h3>10</h3>
                    <p>Number of Chats</p>
                </div>
            </li>
        </ul>
    </main>
@endsection

@section('modals')

    <div id="dashboard_modal" class="modal" style="z-index: 1500;">
        <div class="modal-content" style="margin: 8% 20%;">
            <span class="close">&times;</span>
            <div class="dashboard-form">
                <h2 class="form-title">Create New Project</h2>
                <form method="POST" action="#" class="dashboard-form" id="login-form">
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
                        <input type="text" name="project_manager" id="project-manager"
                               placeholder="Leading Project Manager" required/>
                    </div>
                    <div class="">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Create Project"/>
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
