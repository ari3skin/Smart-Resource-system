<header class="header" id="header">

    <nav class="nav container">

        <div class="logo__container">
            <img src="{{asset('icons/icon-1-1.png')}}">
            <a href="/" class="nav__logo">Smart Resource</a>
        </div>

        <div class="nav__menu" id="nav-menu">

            <ul class="nav__list grid">

                <li class="nav__item">
                    <a href="#home" class="nav__link">
                        <i class="uil uil-estate nav__icon"></i> Home
                    </a>
                </li>

                <li class="nav__item">
                    <a href="#main_portal" class="nav__link">
                        <i class="uil uil-user nav__icon"></i> Main Portal
                    </a>
                </li>

            </ul>
            <i class="uil uil-times nav__close" id="nav-close"></i>

        </div>

        <div class="nav__btns">
            <!--Theme changing-->
            <i class="uil uil-moon change-theme" id="theme-button"></i>

            @if(session()->has('email'))
                @if(session('role')=='admin')
                    <a href="/admin" style="margin-left: 1rem; margin-right: 1rem;"
                       title="Logged in as {{session('first_name')}} {{session('last_name')}}">
                        <i class="uil uil-user-check" style="font-size: 1.5rem; color: var(--title-color);"></i>
                    </a>
                @elseif(session('role')=='customer')
                    <a href="/customer" style="margin-left: 1rem; margin-right: 1rem;"
                       title="Logged in as {{session('first_name')}} {{session('last_name')}}">
                        <i class="uil uil-user-check" style="font-size: 1.5rem; color: var(--title-color);"></i>
                    </a>
                @endif
            @else
                {{--authentication access accesses--}}
                <div class="services__button" style="margin-left: 1rem; margin-right: 1rem;" title="Not Logged in">
                    <i class="uil uil-user-times" style="font-size: 1.5rem; color: var(--title-color);"></i>
                </div>
                <div class="services__modal">
                    <div class="services__modal-content">
                        <h4 class="services__modal-title">User Access:</h4>
                        <i class="uil uil-times services__modal-close"></i>

                        <ul class="services__modal-services grid">
                            <li class="services__modal-service">
                                <i class="uil uil-signin services__modal-icon" style="font-size: 2rem;"></i>
                                <a href="#"
                                   style="margin-top: 10px; margin-left: 10px ; color: var(--text-color);">Login</a>
                            </li>

                            <li class="services__modal-service">
                                <i class="uil uil-signin services__modal-icon" style="font-size: 2rem;"></i>
                                <a href="#"
                                   style="margin-top: 10px; margin-left: 10px ; color: var(--text-color);">Register Request</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            {{--access to the shortcut menu--}}
            <div class="nav__toggle" id="nav-toggle">
                <i class="uil uil-apps nav__icon"></i>
            </div>
        </div>

    </nav>

</header>
