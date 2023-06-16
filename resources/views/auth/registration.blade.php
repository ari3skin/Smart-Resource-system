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
                <a href="/auth/login" class="signup-image-link">Login Instead</a>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Registration Request</h2>
                <form method="POST" action="/auth/registration" class="register-form" id="login-form">
                    @csrf
                    <div class="form-group">
                        <label for="email"><i class="uil uil-user"></i></label>
                        <input type="text" name="email" id="email" placeholder="Your Work Email" required/>
                    </div>
                    <div class="form-group">
                        <label for="datetime"><i class="uil uil-calendar-alt"></i></label>
                        <input type="datetime-local" name="datetime" id="datetime" placeholder="Current Date" required/>
                    </div>

                    <div class="">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Place Request"/>
                    </div>
                </form>
                <div class="social-login">
                    <button id="google-signin-button">
                        <span class="google-icon"></span>
                        <span class="btn-text">Sign up with Google</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{asset('js/index.js')}}"></script>
</body>
</html>
