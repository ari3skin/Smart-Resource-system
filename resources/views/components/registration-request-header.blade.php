<header class="header" id="header">

    <nav class="nav container">

        <div class="logo__container">
            <img src="{{asset('icons/icon-2.png')}}">
            <a href="/" class="nav__logo">Smart Resource</a>
        </div>

        <div class="nav__menu" id="nav-menu">

            <ul class="nav__list grid">

                <li class="nav__item">
                    <a href="#main_portal" class="nav__link">
                        <i class="uil uil-user nav__icon"></i> Main Portal
                    </a>
                </li>

                <li class="nav__item">
                    <a href="/" class="nav__link">
                        <i class="uil uil-user nav__icon"></i> Home
                    </a>
                </li>

                @if(session()->has('email'))
                    @if(session('role')=='employee')
                        <a href="#" style="margin-left: 1rem; margin-right: 1rem;"
                           title="Logged in as {{session('first_name')}} {{session('last_name')}}">
                            <i class="uil uil-user-check" style="font-size: 1.5rem; color: var(--title-color);"></i>
                        </a>
                    @elseif(session('role')=='employer')
                        <a href="#" style="margin-left: 1rem; margin-right: 1rem;"
                           title="Logged in as {{session('first_name')}} {{session('last_name')}}">
                            <i class="uil uil-user-check" style="font-size: 1.5rem; color: var(--title-color);"></i>
                        </a>
                    @endif
                @else
                    <li class="nav__item">
                        <a href="/auth/login" class="nav__link">
                            <i class="uil uil-user nav__icon"></i> Login Instead
                        </a>
                    </li>
                @endif
            </ul>
            <i class="uil uil-times nav__close" id="nav-close"></i>

        </div>

        <div class="nav__btns">
            <!--Theme changing-->
            <i class="uil uil-moon change-theme" id="theme-button"></i>

            {{--access to the shortcut menu--}}
            <div class="nav__toggle" id="nav-toggle">
                <i class="uil uil-apps nav__icon"></i>
            </div>
        </div>

    </nav>

</header>
