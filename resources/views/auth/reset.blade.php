<!doctype html>
<html lang="en">
<head>
    <x-header-tag></x-header-tag>
    <title>Smart Resource - Password Reset</title>
</head>
<body>

<x-registration-request-header></x-registration-request-header>

<section class="main_content">
    <div class="login__container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="{{asset('icons/icon-2-1.png')}}" alt="sing up image"></figure>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Reset Password</h2>
                <form method="POST" action="/auth/save-reset" class="register-form" id="login-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="first_password"><i class="uil uil-padlock"></i></label>
                        <input type="text" name="password" id="first_password" minlength="8"
                               placeholder="New Password"/>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="uil uil-padlock"></i></label>
                        <input type="password" name="new_password" id="password" minlength="8"
                               placeholder="Repeat New Password" required/>
                    </div>
                    <span id="password-error" style="margin: 5px 20px; color: red;"></span>
                    <div class="">
                        @if($user_id)
                            <input type="hidden" name="user_id" value="{{$user_id}}">
                        @elseif($token)
                            <input type="hidden" name="token" value="{{$token}}">
                        @endif
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Reset Password"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="{{asset('js/index.js')}}"></script>
<script>
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
