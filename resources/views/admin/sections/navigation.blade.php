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
            <a class="tablinks" onclick="switchcommon(event, 'sent-messages')"
               style="cursor: pointer" title="Sent Messages">
                <i class="uil uil-envelope-download"></i>
                <span class="text">Sent Messages</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'verifications')"
               style="cursor: pointer" title="Verifications">
                <i class="uil uil-check-circle"></i>
                <span class="text">Verifications</span>
            </a>
        </li>

        <li>
            <a class="tablinks" onclick="switchcommon(event, 'chat-zone')"
               style="cursor: pointer" title="Chat Zone">
                <i class="uil uil-comments-alt"></i>
                <span class="text">Chat Zone</span>
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
