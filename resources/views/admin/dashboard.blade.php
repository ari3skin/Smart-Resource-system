<!doctype html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <x-header-tag></x-header-tag>
</head>
<body class="admin__body">

@include('admin.sections.navigation')

<section id="content">
    {{--top navigation--}}

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

        <a href="#" class="profile" title="Hello there User">
            {{--<img src="{{asset('images/profile-1.png')}}" alt="">--}}
            <i class="uil uil-user"></i>
        </a>
    </nav>

    {{--main navigation content--}}
    @include('admin.sections.main')
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
