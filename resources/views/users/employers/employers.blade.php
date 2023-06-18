@extends('layouts/dashboard')

@section('dashboard_content')
    <main class="tabcontent" id="dashboard">
        <div class="head-title">
            <div class="left">
                <h1>Dashboard</h1>

                <ul class="breadcrumb">
                    <li>
                        <a href="#">John Smith</a>
                    </li>
                    <li><i class="uil uil-angle-right-b"></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li>
                </ul>
            </div>

            <a href="#" class="btn-download">
                <i class="uil uil-cloud-download"></i>
                <span class="text">Download Resume</span>
            </a>
        </div>

        <ul class="box-info">
            <li>
                <a class="tablinks" onclick="switchcommon(event, 'sent-messages')"
                   style="cursor: pointer" title="Sent Messages">
                    <i class="uil uil-at"></i>
                </a>
                <div class="text">
                    <h3>10</h3>
                    <p>Pending "Contact Me" Messages</p>
                </div>
            </li>

            <li>
                <a class="tablinks" onclick="switchcommon(event, 'verifications')"
                   style="cursor: pointer" title="Verifications">
                    <i class="uil uil-user"></i>
                </a>
                <div class="text">
                    <h3>10</h3>
                    <p>Unverified Users</p>
                </div>
            </li>

            <li>
                <a class="tablinks" onclick="switchcommon(event, 'to-do')"
                   style="cursor: pointer" title="To Do">
                    <i class="uil uil-clipboard"></i>
                </a>
                <div class="text">
                    <h3>10</h3>
                    <p>To Do Items</p>
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
