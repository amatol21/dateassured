<form id="login-form" action="{{ route('login', [], false) }}" >
    @csrf

    <h2 class="login-form__title">{{ __('auth.loginForm.authorization') }}</h2>

    <label class="w-100">
        <span class="label">{{ __('auth.labels.login') }}</span>
        <input type="email" name="email" class="input" required>
        <span class="error" data-for="email"></span>
    </label>

    <label class="w-100 mt-1">
        <span class="label">{{ __('auth.labels.password') }}</span>
        <input type="password" name="password" class="input" required>
        <span class="error" data-for="password"></span>
    </label>

    <div class="login-form__forgot-pass-link pt-1 mt-1"
         style="cursor: pointer"
         onclick="document.dispatchEvent(new CustomEvent('forgot-password'))">
        {{ __('auth.loginForm.forgotPassword') }}
    </div>

    @guest
    <div class="flex column ai-center mt-2 w-100">
        @include('auth.googleLoginButton')
        <div class="mt-1"></div>
        @include('auth.facebookLoginButton')
    </div>
    @endguest


    <div class="flex w-100 mt-2">
        <a href="{{ route('register') }}" class="btn no-acc-button ml-auto">{{ __('auth.buttons.noAccount') }}</a>
        <button type="submit" class="btn btn-pink ml-1">{{ __('auth.buttons.signIn') }}</button>
    </div>

</form>

<script>
    (() => {
        let form = document.getElementById('login-form');
        let noAccButton = form.querySelector('.no-acc-button');

        @if(!request()->routeIs('login'))
        noAccButton.addEventListener('click', e => {
            e.preventDefault();
            document.dispatchEvent(new CustomEvent('hide-login-modal', {detail: {backwards: true}}))
            setTimeout(() => {
                document.dispatchEvent(new CustomEvent('show-reg-modal'));
            }, 250);
        });
        @endif

        form.addEventListener('submit', async e => {
            e.preventDefault();
            clearFormErrors(form);
            await showSpinner(form);

            try {
                let res = await fetch(form.getAttribute('action'), {
                    method: 'POST',
                    headers: {'X-Requested-With': 'XMLHttpRequest'},
                    body: new FormData(form)
                });
                if (res.ok) {
                    if (res.redirected) {
                        window.location = res.url;
                    }
                } else {
                    let data = await res.json();
                    showFormErrors(form, data);
                    await hideSpinner(form);
                }
            } catch (e) {
                console.error(e);
                await hideSpinner(form);
            }
        });
    })();
</script>
