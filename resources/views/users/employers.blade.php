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
            <a class="tablinks" id="defaultOpen" onclick="switchcommon(event, 'project')"
               style="cursor: pointer" title="Projects">
                <i class="uil uil-clipboard-notes"></i>
                <span class="text">Projects</span>
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

    <ul class="side-menu" id="bottom">
        <li>
            <a href="/auth/logout" class="logout" title="Logout">
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
                    <h3>--</h3>
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
@endsection
