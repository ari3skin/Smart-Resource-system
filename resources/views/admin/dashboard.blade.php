<!doctype html>
<html lang="en">
<head>
    <title>Super Admin Dashboard</title>
    <x-header-tag></x-header-tag>
</head>
<body class="admin__body">

@include('admin.sections.navigation')

<section id="content">
    <nav>
        <div style="display: flex; align-items: center;">
            <i class="uil uil-bars"></i>
            <a href="#" class="nav-link">Actions</a>
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

        <a href="#" class="profile notification" title="Chat Box">
            <i class="uil uil-comments-alt"></i>
            <span class="num">--</span>
        </a>
    </nav>

    {{--main navigation content--}}
    @include('admin.sections.main')
    @include('admin.sections.settings_content')
</section>


<script src="{{asset('js/admin.js')}}"></script>
<script src="{{asset('js/index.js')}}"></script>
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

    //modal views
    var modal_fail = document.getElementById("modal_fail");
    var close_span = document.getElementsByClassName("close")[0];

    // Events that close both modals
    close_span.onclick = function () {
        modal_fail.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target === modal_fail) {
            modal_fail.style.display = "none";
        }
    };

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
    });
</script>
</body>
</html>
