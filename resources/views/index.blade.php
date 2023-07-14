<!doctype html>
<html lang="en">
<head>
    <x-header-tag></x-header-tag>
    <title>Smart Resource - A Web Banking Resource System</title>
</head>
<body>
<x-header></x-header>

<main class="main" id="megan_css">

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
        <p>SmartResource has the knowledge, experience and commitment to serve all our clientele when you are looking for a job. Our expert team members will offer you their full attention and guidance so that you can make the most out of our services.Contact us to learn more </p>
    </div>

    <div class="word3_container">
        <h3>THE RIGHT BANKING EMPLOYMENT AGENCY FOR YOU</h3>
        <p>Excellence and Success</p>
    </div>

    <div class="img34_container">
    <img src="{{asset('icons/hp_img3.png')}}">
    <img src="{{asset('icons/hp_img4.png')}}">
    </div>

    <div class="word4_container">
        <h4>RETAIL</h4>
        <p>Recruiting top-notch candidates for leading employers is what we stand for. we specialize in short-term, long term and temporary hires withing the banking industry.Whatever your needs may be, we are here for you.</p>
    </div>

    <div class="img5_container">
    <img src="{{asset('icons/hp_img5.png')}}">
    </div>

    <div class="word5_container">
        <h5>CUSTOMER CARE</h5>
        <p>Let our team of experts do everything possible to take the pressure off. we specialize in sourcing and recruiting in the banking industry.Contact us to jumpstart your career and make the process as straightforward as it could be.</p>
        <h6>HOSPITALITY</h6>
        <p>We are very hospitable.Let us know what you arelooking for so our experts can make the match</p>
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
