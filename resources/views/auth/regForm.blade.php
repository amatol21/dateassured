<form id="reg-form" action="{{ route('register', [], false) }}" >
    @csrf

    <h2 class="reg-form__title">{{ __('auth.regForm.registration') }}</h2>

    <label class="w-100">
        <span class="label">{{ __('auth.labels.email') }}</span>
        <span class="input-placeholder shown">
            <input type="email" name="email" class="input" required autocomplete="off" style="display: none">
        </span>
        <span class="error" data-for="email"></span>
    </label>

    <label class="w-100 mt-1">
        <span class="label">{{ __('auth.labels.password') }}</span>
        <span class="input-placeholder shown">
            <input type="password" name="password" class="input" required autocomplete="off" style="display: none">
        </span>
        <span class="error" data-for="password"></span>
    </label>

    <label class="w-100 mt-1">
        <span class="label">{{ __('auth.labels.passwordConfirmed') }}</span>
        <span class="input-placeholder shown">
            <input type="password" name="password_confirmation" class="input" required autocomplete="off" style="display: none">
        </span>
        <span class="error" data-for="password"></span>
    </label>

    @guest
        <div class="flex column ai-center mt-2 w-100">
            @include('auth.googleLoginButton')
            <div class="mt-1"></div>
            @include('auth.facebookLoginButton')
        </div>
    @endguest

    <div class="flex w-100 mt-2">
        <a href="{{ route('register') }}" class="btn have-acc-button ml-auto">{{ __('auth.buttons.haveAnAccount') }}</a>
        <button type="submit" class="btn btn-pink ml-1">{{ __('auth.buttons.register') }}</button>
    </div>

</form>

<script>
    (() => {
        let form = document.getElementById('reg-form');

        @if(!request()->routeIs('login'))
        let haveAccButton = form.querySelector('.have-acc-button');
        haveAccButton.addEventListener('click', e => {
            e.preventDefault();
            document.dispatchEvent(new CustomEvent('hide-reg-modal', {detail: {backwards: true}}))
            setTimeout(() => {
                document.dispatchEvent(new CustomEvent('show-login-modal'));
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
