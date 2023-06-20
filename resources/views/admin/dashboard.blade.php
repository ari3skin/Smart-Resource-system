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
