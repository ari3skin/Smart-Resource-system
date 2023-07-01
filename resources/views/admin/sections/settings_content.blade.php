<main class="sign-in tabcontent" id="reset_password">

    <div class="head-title">
        <div class="left">
            <h1>Settings</h1>

            <ul class="breadcrumb">
                <li class="tablinks" onclick="switchcommon(event, 'dashboard')" style="cursor: pointer">
                    <a href="#">{{session('first_name')}} {{session('last_name')}}</a>
                </li>
                <li><i class="uil uil-angle-right-b"></i></li>
                <li class="tablinks" onclick="switchcommon(event, 'settings')" style="cursor: pointer">
                    <a class="active" href="#">Setings</a>
                </li>
                <li><i class="uil uil-angle-right-b"></i></li>
                <li>
                    <a class="active" href="#">Reset Password</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="login__container" style="margin: 0px auto; border: none">
        <div class="signin-content" style="padding-top: 60px; padding-bottom: 80px;">
            <div class="signin-image" style="margin-right: 0;">
                <figure><img src="{{asset('icons/icon-2-1.png')}}" alt="sing up image"></figure>
            </div>
            <div class="signin-form">
                <h2 class="form-title">Reset Password</h2>
                <form method="POST" action="#" class="register-form" id="login-form">
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
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Reset Password"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($errors->has('error'))
        <div id="modal_fail" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__error">Login Request Failed.</p>
                <p class="modal__text">{{ $errors->first('error') }}</p>
            </div>
        </div>
    @endif
</main>
