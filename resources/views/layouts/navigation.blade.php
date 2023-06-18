<section id="sidebar">
    <a href="/admin" class="brand">
        <i class="uil uil-star"></i>
        <span class="text">
            Welcome {{session('first_name')}}
        </span>
    </a>

    <ul class="side-menu top">

        @yield('nav_content')

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'settings')"
               style="cursor: pointer" title="Settings">
                <i class="uil uil-setting"></i>
                <span class="text">Settings</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu">
        <li>
            <a href="/auth/logout" class="logout" title="Logout">
                <i class="uil uil-signout"></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>

</section>
