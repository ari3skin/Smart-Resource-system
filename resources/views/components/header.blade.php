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

                @if(session()->has('sys_id'))
                    <li>
                        @if(session('role')=='Employee')
                            <a href="/admin/" style="margin-left: 1rem; margin-right: 1rem;"
                               title="Logged in as {{session('first_name')}} {{session('last_name')}}">
                                <i class="uil uil-user-md nav__icon"
                                   style="font-size: 1.5rem; color: var(--title-color);"></i>
                                {{session('role')}} {{session('first_name')}}
                            </a>
                        @elseif(session('role')=='Manager')
                            <a href="/admin/" style="margin-left: 1rem; margin-right: 1rem;"
                               title="Logged in as {{session('first_name')}} {{session('last_name')}}">
                                <i class="uil uil-user-md nav__icon"
                                   style="font-size: 1.5rem; color: var(--title-color);"></i>
                                {{session('role')}} {{session('first_name')}}
                            </a>
                        @elseif(session('role')=='Admin')
                            <a href="/admin/" style="margin-left: 1rem; margin-right: 1rem;"
                               title="Logged in as {{session('first_name')}} {{session('last_name')}}">
                                <i class="uil uil-user-md nav__icon"
                                   style="font-size: 1.5rem; color: var(--title-color);"></i>
                                {{session('role')}} {{session('first_name')}}
                            </a>
                        @endif
                    </li>
                @else
                    <li class="nav__item">
                        <a href="/auth/login" class="nav__link">
                            <i class="uil uil-user nav__icon"></i> Login
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="/auth/registration" class="nav__link">
                            <i class="uil uil-user nav__icon"></i> Registration Request
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
