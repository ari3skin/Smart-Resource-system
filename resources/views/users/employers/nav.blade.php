@extends('layouts.navigation')

@section('nav_content')
    <li class="active">
        <a class="tablinks" id="defaultOpen" onclick="switchcommon(event, 'dashboard')"
           style="cursor: pointer" title="Dashboard">
            <i class="uil uil-estate"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
@endsection
