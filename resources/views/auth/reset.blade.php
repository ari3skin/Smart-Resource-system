<!doctype html>
<html lang="en">
<head>
    <x-header-tag></x-header-tag>
    <title>Smart Resource - Password Reset</title>
</head>
<body>

<x-login-header></x-login-header>

<section class="sign-in">
    <div class="login__container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="{{asset('icons/icon-2-1.png')}}" alt="sing up image"></figure>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Reset Password</h2>
                <form method="POST" action="/auth/reset-password" class="register-form" id="login-form">
                    @csrf
                    <div class="form-group">
                        <label for="username"><i class="uil uil-padlock"></i></label>
                        <input type="text" name="username" id="username" placeholder="Current Password"/>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="uil uil-padlock"></i></label>
                        <input type="password" name="new_password" id="password" placeholder="New Password" required/>
                    </div>
                    <div class="">
                        <input type="hidden" name="user_id" value="{{$user_id}}">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Reset Password"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="{{asset('js/index.js')}}"></script>
</body>
</html>
