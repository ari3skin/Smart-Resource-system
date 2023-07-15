<!doctype html>
<html lang="en">
<head>
    <title>Super Admin Dashboard</title>
    <x-header-tag></x-header-tag>
</head>
<body class="admin__body">

@include('admin.sections.navigation')

<section id="main_content">
    <nav>
        <div style="display: flex; align-items: center;">
            <i class="uil uil-bars"></i>
            <a href="#" class="nav-link">Actions</a>
        </div>

        <div class="user_info">
            <span>My department: {{session('department_name')}} Department</span>
        </div>
        <form action="#" style="display: none">
            <div class="form-input">
                <input type="search" placeholder="Search...">
                <button type="submit" class="search-btn">
                    <i class="uil uil-search"></i>
                </button>
            </div>
        </form>

        {{--top left navigation icons--}}
        <i class="uil uil-moon change-theme" id="dashboard-theme"></i>

        <a style="cursor: pointer;" class="profile notification" onclick="selectedInterface(this)" id="admin_chats"
           title="Chat Box">
            <i class="uil uil-comments-alt"></i>
            <span class="num">--</span>
        </a>
    </nav>

    {{--main navigation content--}}
    @include('admin.sections.main')
    @include('admin.sections.settings_content')

    @if($errors->has('error'))
        <div id="modal_fail" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__error">
                    <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
                    Access Denied.
                    <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
                </p>
                <p class="modal__text">{{ $errors->first('error') }}</p>
            </div>
        </div>
    @endif
    <div id="confirm_logout" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
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

</section>

<script src="{{asset('js/jsQuery.js')}}"></script>
<script src="{{asset('js/modals.js')}}"></script>
<script src="{{asset('js/admin.js')}}"></script>
<script src="{{asset('js/ajax.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    adminOnReady();
    switchcommon(evt, mainName);
</script>


</body>
</html>
