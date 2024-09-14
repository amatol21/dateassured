<header id="header">
    <div class="width-limiter header-content">
        <a href="{{ asset('/') }}" class="header__brand">  <!-- here -->
		  		<img src="/images/logo.jpg" class="header__brand__image" alt="DateAssured site logo" srcset="/images/logo.svg"> 

            <div class="header__brand__text">
                Date<br/>Assured
            </div>
        </a>


        <nav id="header-menu" class="header__menu">
            @auth
                @permission(App\Enums\Permission::ACCESS_ADMIN_PANEL)
                    <a href="{{ route('admin') }}" class="btn mr-1">Admin panel</a>
                @endpermission

                <a href="{{ route('account') }}" class="btn mr-1">Account</a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn">{{ __('auth.buttons.logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="btn mr-1"
                   style="width: 8rem"
                   onclick="event.preventDefault(); document.dispatchEvent(new CustomEvent('show-login-modal'))">
                    {{ __('menu.main.login') }}
                </a>

                <a href="{{ route('login') }}"
                   class="btn btn-pink"
                   style="width: 8rem"
                   onclick="event.preventDefault(); document.dispatchEvent(new CustomEvent('show-reg-modal'))">
                    {{ __('menu.main.register') }}
                </a>
            @endauth
        </nav>

        @auth
            @include('notifications.index')
        @endauth

        <div id="active-vs-icon"
             onclick="document.dispatchEvent(new CustomEvent('show-active-video-session'))"
             title="Active video session"
             style="display: none; opacity: 0; width: 0;">
            <?= \App\Helpers\Svg::icon('video-chat', 30, 30, 13) ?>
        </div>

        <div class="menu-button" onclick="this.classList.toggle('shown'); document.getElementById('header-menu').classList.toggle('shown')">
            <div></div>
        </div>
    </div>
</header>

<script>
    (() => {
        let header = document.getElementById('header');

        window.onscroll = function (e) {
            if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
                header.classList.add('with-shadow');
            } else {
                header.classList.remove('with-shadow');
            }
        }
    })();
</script>

@guest
    @include('auth.loginModal')
    @include('auth.regModal')
@endguest
