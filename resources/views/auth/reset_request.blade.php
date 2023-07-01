<!doctype html>
<html lang="en">
<head>
    <x-header-tag></x-header-tag>
    <title>Smart Resource - Password Reset</title>
</head>
<body>

<x-registration-request-header></x-registration-request-header>

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
                    {{--<div class="form-group">--}}
                    {{--<label for="username"><i class="uil uil-user"></i></label>--}}
                    {{--<input type="text" name="username" id="username" minlength="8" placeholder="Your Username"/>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                    {{--<span style="margin: 0 125px;">OR</span>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label for="email"><i class="uil uil-user"></i></label>
                        <input type="text" name="email" id="email" minlength="8" placeholder="Your Work Email" required/>
                    </div>
                    <div>
                        <input type="submit" name="signin" id="signin" class="form-submit"
                               value="Send me Instructions"/>
                    </div>
                </form>
            </div>
        </div>
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
