<!doctype html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <x-header-tag></x-header-tag>
</head>
<body class="admin__body">

<section id="sidebar">
    <a href="/" class="brand">
        <i class="uil uil-star"></i>
        <span class="text">
            Welcome {{session('first_name')}}
        </span>
    </a>

    <ul class="side-menu top">
        @yield('content')
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
</section>

<section id="content">
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
</section>


<script src="{{asset('js/admin.js')}}"></script>
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

    // for default page
    document.getElementById("defaultOpen").click();
</script>
</body>
</html>

