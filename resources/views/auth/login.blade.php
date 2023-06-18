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
                        <input type="text" name="username" id="username" placeholder="Your Username" required/>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="uil uil-padlock"></i></label>
                        <input type="password" name="password" id="password" placeholder="Password" required/>
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
                    <button id="google-signin-button">
                        <span class="google-icon"></span>
                        <span class="btn-text">Sign in with Google</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{asset('js/index.js')}}"></script>
</body>
</html>
