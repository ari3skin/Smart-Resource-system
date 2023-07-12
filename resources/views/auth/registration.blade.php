<!doctype html>
<html lang="en">
<head>
    <x-header-tag></x-header-tag>
    <title>Smart Resource - Login</title>
</head>
<body>

<x-registration-request-header></x-registration-request-header>

<section class="main_content">
    <div class="login__container">
        <div class="signup-content">
            <div class="signup-image">
                <figure><img src="{{asset('icons/icon-2-1.png')}}" alt="sing up image"></figure>
                <a href="/auth/login" class="signup-image-link">Login Instead</a>
            </div>

            <div class="signup-form">
                <h2 class="form-title">Registration Request</h2>
                <form method="POST" action="/auth/registration" class="register-form" id="registration_form"
                      autocomplete="of">
                    @csrf
                    <div class="form-group">
                        <label for="email"><i class="uil uil-user"></i></label>
                        <input type="text" name="email" id="email" placeholder="Your Work Email" required/>
                    </div>
                    <div id="email-notification" class="notification"></div>
                    <div class="form-group">
                        <label for="datetime"><i class="uil uil-calendar-alt"></i></label>
                        <input type="date" name="datetime" id="datetime" placeholder="Current Date" required/>
                    </div>

                    <div class="">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Place Request"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--Modal Content--}}

    <div id="modal_success" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p class="modal__text__success">Your Registration Request has been successfully placed.</p>
            <p class="modal__text">Kindly wait for a minimum of 5 hours for further system procedures and check your
                email for account creation, reset password and verification</p>
        </div>
    </div>

    <div id="modal_fail" class="modal">
        <div class="modal-content">
            <p class="modal__text__error">Registration Request has failed.</p>
            <p class="modal__text">Your request has already been placed</p>
            <p class="modal__text">OR</p>
            <p class="modal__text">There is an error in your inputs</p>
        </div>
    </div>
    @if($errors->has('error'))
        <div id="modal_fail" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__error">
                    <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
                    Access Denied.
                    <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
                </p>
                <p class="modal__text">{{ $errors->first('error') }}</p>
            </div>
        </div>
    @endif
</section>


<script src="{{asset('js/index.js')}}"></script>
<script src="{{asset('js/modals.js')}}"></script>
<script src="{{asset('js/ajax.js')}}"></script>
<script>
    var modal_success = document.getElementById("modal_success");
    var modal_fail = document.getElementById("modal_fail");
    var close_span = document.getElementsByClassName("close")[0];
    var registrationForm = document.getElementById("registration_form");

    // Events that close both modals
    close_span.onclick = function () {
        modal_success.style.display = "none";
        window.location.href = "/";
    };
    window.onclick = function (event) {
        if (event.target === modal_success) {
            modal_success.style.display = "none";
            window.location.href = "/auth/login";

        } else if (event.target === modal_fail) {
            modal_fail.style.display = "none";
        }
    };


    function showSuccessModal() {
        modal_success.style.display = "block";
    }

    function showFailedModal() {
        modal_fail.style.display = "block";
    }

    registrationForm.addEventListener("submit", function (event) {

        event.preventDefault();
        var formData = new FormData(registrationForm);

        // Make an AJAX request to the controller using fetch
        fetch('/auth/registration', {
            method: 'POST',
            body: formData
        })
            .then(function (response) {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Request failed');
                }
            })
            .then(function (data) {
                if (data.success) {
                    showSuccessModal();
                } else {
                    showFailedModal();
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
            });
    });
</script>
</body>
</html>
