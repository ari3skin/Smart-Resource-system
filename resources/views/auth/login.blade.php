<!doctype html>
<html lang="en">
<head>
    <x-header-tag></x-header-tag>
    <title>Smart Resource - Login</title>
</head>
<body>

<x-login-header></x-login-header>

<section class="sign-in">
    <div class="login__container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="{{asset('icons/icon-2-1.png')}}" alt="sing up image"></figure>
                <a href="/auth/registration" class="signup-image-link">Make a Registration Request instead</a>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Log In</h2>
                <form method="POST" action="/auth/login" class="register-form" id="login-form">
                    @csrf
                    <div class="form-group">
                        <label for="username"><i class="uil uil-user"></i></label>
                        <input type="text" name="username" id="username" placeholder="Your Username" required autocomplete="off"/>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="uil uil-padlock"></i></label>
                        <input type="password" name="password" id="password" placeholder="Password" minlength="8"
                               required autocomplete="off"/>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember" id="remember" class="agree-term"
                               style="width: 20px; margin-left: 140px;"/>
                        <label for="remember" class="label-agree-term">Remember me</label>
                    </div>
                    <div class="">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                    </div>
                </form>
                <div class="social-login">
                    <a href="/auth/google" id="google-signin-button">
                        <span class="google-icon" style="background-image: url({{asset('icons/google.svg')}});"></span>
                        <p style="margin-left: -10px">oogle</p>
                    </a>
                    <a href="/auth/reset" id="reset-password">Forgot Password</a>
                </div>
            </div>
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
