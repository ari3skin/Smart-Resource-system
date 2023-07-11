<!doctype html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <x-header-tag></x-header-tag>
</head>
<body class="admin__body">

<section id="sidebar">
    <a href="/" class="brand">
        <i class="uil uil-user-square"></i>
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
{{--script for tab switching--}}

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
</script>
</body>
</html>

