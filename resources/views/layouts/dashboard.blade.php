<!doctype html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <x-header-tag></x-header-tag>
</head>
<body class="admin__body">

<section id="sidebar">
    <a href="/" class="brand">

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
        <i class="uil uil-bars"></i>
        <a href="#" class="nav-link">Actions</a>

        <form action="#">
            <div class="form-input">
                <input type="search" placeholder="Search...">
                <button type="submit" class="search-btn">
                    <i class="uil uil-search"></i>
                </button>
            </div>
        </form>

        <i class="uil uil-moon change-theme" id="dashboard-theme"></i>

        <a href="#" class="notification">
            <i class="uil uil-bell"></i>
            <span class="num">8</span>
        </a>
    </nav>
    {{--main navigation content--}}
    @yield('dashboard-content')
    @yield('modals')
</section>


<script src="{{asset('js/admin.js')}}"></script>
<script src="{{asset('js/modals.js')}}"></script>
<script src="{{asset('js/ajax.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

{{--scripts that load upon opening the document itself--}}
<script>
    document.getElementById("defaultOpen").click();

    $(document).ready(function () {

        //password comparison
        $('#password').on('keyup', function () {
            var newPassword = $('#first_password').val();
            var confirmPassword = $(this).val();

            if (newPassword !== confirmPassword) {
                $('#password-error').text('Passwords do not match');
            } else {
                $('#password-error').text('');
            }
        });

        //Initially hide all select fields
        let taskTM = $('#task-team-manager');
        let taskMI = $('#task-manager-individual');
        let taskEI = $('#task-employee-individual');
        taskTM.hide();
        taskMI.hide();
        taskEI.hide();

        // Event listener for checkbox of id 'teamManager'
        $('#teamManager').click(function () {
            if ($(this).prop("checked") === true) {
                // Uncheck other checkbox
                $('#individual').prop('checked', false);

                // Show related select and hide others
                taskTM.show();
                taskMI.hide();
                taskEI.hide();
            } else {
                // Hide all selects if checkbox is unchecked
                taskTM.hide();
            }
        });
        // Event listener for checkbox of id 'individual'
        $('#individual').click(function () {
            if ($(this).prop("checked") === true) {
                // Uncheck other checkbox
                $('#teamManager').prop('checked', false);

                // Show related selects and hide others
                taskMI.show();
                taskEI.show();
                taskTM.hide();
            } else {
                // Hide related selects if checkbox is unchecked
                taskMI.hide();
                taskEI.hide();
            }
        });
    });
</script>
</body>
</html>

