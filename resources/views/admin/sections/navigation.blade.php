<section id="sidebar">
    <a href="/" class="brand">
        <i class="uil uil-star"></i>
        <span class="text">First Name</span>
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
            <a class="tablinks" onclick="switchcommon(event, 'employers')"
               style="cursor: pointer" title="List of Employers">
                <i class="uil uil-envelope-download"></i>
                <span class="text">List of Employers</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'employees')"
               style="cursor: pointer" title="List of Employees">
                <i class="uil uil-check-circle"></i>
                <span class="text">List of Employees</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'registration')"
               style="cursor: pointer" title="Registration Requests">
                <i class="uil uil-comments-alt"></i>
                <span class="text">Registration Requests</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'emailing')"
               style="cursor: pointer" title="Email">
                <i class="uil uil-envelope-edit"></i>
                <span class="text">Emailing</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'to-do')"
               style="cursor: pointer" title="To Do">
                <i class="uil uil-clipboard"></i>
                <span class="text">Todo List</span>
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
