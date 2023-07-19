<!doctype html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <x-header-tag></x-header-tag>
</head>
<body class="admin__body">

<section id="sidebar">
    <a href="/admin" class="brand">

        @if (!Auth::user()->profile_picture)
            <i class="uil uil-user-square"></i>
        @else
            <img src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="User Avatar" class="project_pic">
        @endif
        <span class="text">
            {{session('first_name')}} {{session('last_name')}}
        </span>
    </a>

    @yield('nav-content')

</section>

<section id="main_content">
    <nav>
        <div style="display: flex; align-items: center;">
            <i class="uil uil-bars"></i>
            <a href="#" class="nav-link">Actions</a>
        </div>

        <div class="user_info">
            <span>My department: {{session('department_name')}} Department</span>
        </div>
        <form action="#" style="display: none;">
            <div class="form-input">
                <input type="search" placeholder="Search...">
                <button type="submit" class="search-btn">
                    <i class="uil uil-search"></i>
                </button>
            </div>
        </form>

        <i class="uil uil-moon change-theme" id="dashboard-theme"></i>

        <a style="cursor: pointer;display: none;" class="profile notification" onclick="selectedInterface(this)"
           title="Chat Box" id="{{session('chat_box_id')}}">
            <i class="uil uil-comments-alt"></i>
            <span class="num">--</span>
        </a>
    </nav>
    {{--main navigation content--}}
    @yield('dashboard-content')
    @yield('create_form_modals')
    @yield('other_form_modals')
    @yield('logout')
</section>

<script src="{{asset('js/jsQuery.js')}}"></script>
<script src="{{asset('js/admin.js')}}"></script>
<script src="{{asset('js/modals.js')}}"></script>
<script src="{{asset('js/ajax.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    onReady();
</script>
</body>
</html>

