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
            <a class="tablinks" onclick="switchcommon(event, 'tasks')"
               style="cursor: pointer" title="tasks">
                <i class="uil uil-clipboard-notes"></i>
                <span class="text">Tasks</span>
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
        </div>

        <div class="table-data">
            <div class="order">
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
@endsection

@section('modals')

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
