<section id="sidebar">
    <a href="/" class="brand">
        <img src="{{asset('icons/icon-2.png')}}">
        <span class="text">
            Welcome {{session('first_name')}}
        </span>
    </a>

    <ul class="side-menu top">
        <li class="active">
            <a class="tablinks" id="defaultOpen" onclick="switchcommon(event, 'dashboard')"
               style="cursor: pointer" title="Dashboard">
                <i class="uil uil-estate"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'registration-request')"
               style="cursor: pointer" title="Registration Requests">
                <i class="uil uil-clipboard-alt"></i>
                <span class="text">Registration Requests</span>
            </a>
        </li>


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
