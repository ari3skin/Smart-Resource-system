<!doctype html>
<html lang="en">
<head>
    <x-header-tag></x-header-tag>
    <title>Smart Resource - A Web Banking Resource System</title>
</head>
<body>
<x-header></x-header>

<main class="main" id="megan-css">

    <div class="img1_container">
    <img src="{{asset('icons/hp_img1.png')}}">
    </div>
    
    <div class="word1_container">
        <h1>WELCOME TO SMARTRESOURCE</h1>
        <p>Premier Staffing Solutions</p>
    </div>

    <div class="img2_container">
    <img src="{{asset('icons/hp_img2.png')}}">
    </div>

    <div class="word2_container">
        <h2>WORK WITH THE BEST</h2>
        <p>SmartResource has the knowledge, experience and commitment <br> to serve all our clientele when you are looking for a job allocation. Our expert team <br> members will offer you their full attention and guidance so that you can make <br> the most out of our services.Contact us to learn more </p>
    </div>

    <div class="word3_container">
        <h3>THE RIGHT BANKING JOB ALLOCATION SITE FOR YOU</h3>
        <p>Excellence and Success</p>
    </div>

    <div class="img3_container">
    <img src="{{asset('icons/hp_img3.png')}}">
    </div>

    <div class="img4_container">
    <img src="{{asset('icons/hp_img4.png')}}">
    </div>


    <div class="word4_container">
        <h4>TASKS</h4>
        <p>Assigning tasks to employees is what we major on. <br> For effective task assignment we have careful planning, employee selection and feedback to drive successful task execution and overall organizational perfomance.</p>
    </div>

    <div class="img5_container">
    <img src="{{asset('icons/hp_img5.png')}}">
    </div>

    <div class="word5_container">
        <h5>PROJECTS</h5>
        <p>Focused and coordinated efforts to achieve  <br> strategic objectives, address business needs, and  <br> drive organizational growth. Careful planning, <br> communication, resource allocation, monitoring <br> and performance evaluation to ensure <br> successful project execution.</p> 
    </div>

    <div class="word6_container">
    <h6>REPORTS</h6>
        <p>Collecting, analyzing, formatting and distributing <br> relevant information to support informed decision <br> making process across various levels and <br> functions within the bank.</p>
    </div>

    <div class="word7_container">
        <p>CONTACT US TODAY</p>
    </div>


    @if($errors->has('msg'))
        <div id="modal_fail" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__notice">!! Notice !!</p>
                <p class="modal__text">{{ $errors->first('msg') }}</p>
            </div>
        </div>
    @elseif($errors->has('error'))
        <div id="modal_fail" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__error">!! Warning !!</p>
                <p class="modal__text">{{ $errors->first('error') }}</p>
            </div>
        </div>
    @endif
</main>

<script src="{{asset('js/index.js')}}"></script>
<script>
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
</script>
</body>
</html>
