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

        <a style="cursor: pointer;" class="profile notification" onclick="selectedInterface(this)" id="admin_chats" title="Chat Box">
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


<script src="{{asset('js/admin.js')}}"></script>
<script src="{{asset('js/ajax.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

{{--scripts that load upon opening the document itself--}}
<script>
    //password comparison
    $(document).ready(function () {
        $('#password').on('keyup', function () {
            var newPassword = $('#first_password').val();
            var confirmPassword = $(this).val();

            if (newPassword !== confirmPassword) {
                $('#password-error').text('Passwords do not match');
            } else {
                $('#password-error').text('');
            }
        });

        //configuring my datatable
        $('#tableData').DataTable(
            {
                "aLengthMenu": [[5, 10, 25, 50, 75, -1], [5, 10, 25, 50, 75, "All"]],
                "iDisplayLength": 5
            }
        );
    });
</script>
{{--script for tab switching and modals--}}

<script>
    // tab switching
    function switchcommon(evt, mainName) {
        var i, tabcontent, tablinks;
        //get all elements under tabcontent and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(mainName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementById("defaultOpen").click();

    //modal script
    function setupModalEvents(modal, button, closeSpan) {
        button.onclick = function () {
            modal.style.display = "block";
        }
        closeSpan.onclick = function () {
            modal.style.display = "none";
        }
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    }

    var modal_logout = document.getElementById("confirm_logout");
    var btn = document.getElementById("logout_btn");
    var close_span = document.getElementsByClassName("close")[0];

    setupModalEvents(modal_logout, btn, close_span);
</script>
</body>
</html>
