@extends('layouts.dashboard')

@section('content')
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
@endsection
