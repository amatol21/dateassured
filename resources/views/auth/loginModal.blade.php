@include('auth.forgotPasswordModal')

<div id="login-modal" style="display: none">
    <div class="login-modal__wrap">
        <div class="modal_close-button">
            <?= \App\Helpers\Svg::icon('cross', 24, 24, 14) ?>
        </div>
        <div class="login-modal__left">
            <img src="/images/login-form-banner.jpg" alt="Online dating">
        </div>
        <div class="login-modal__right">
            @include('auth.loginForm')
        </div>
    </div>
</div>

<script>
    (() => {
        let modal = document.getElementById('login-modal');
        let wrap = modal.querySelector('.login-modal__wrap');
        let closeButton = modal.querySelector('.modal_close-button');


        if (wrap !== null) wrap.addEventListener('click', e => e.stopPropagation());
        modal.addEventListener('click', () => {
            document.dispatchEvent(new CustomEvent('hide-login-modal'));
        });
        closeButton.addEventListener('click', () => {
            document.dispatchEvent(new CustomEvent('hide-login-modal'));
        });

        async function showModal() {
            clearFormErrors(modal);
            modal.style.opacity = '0';
            wrap.style.transform = 'perspective(1300px) rotate3d(1, 0, 0, 25deg)';
            modal.style.display = null;
            await animate(k => {
                modal.style.opacity = k.toString();
                wrap.style.transform = 'perspective(1300px) rotate3d(1, 0, 0, ' + (25 - (25 * k)) + 'deg)';
            }, 150);
            prepareForm(modal)
        }


        document.addEventListener('show-login-modal', showModal);

        document.addEventListener('hide-login-modal', async e => {
            let backwards = e.detail !== null && e.detail['backwards'] === true;
            wrap.style.transform = 'perspective(1300px) rotate3d(1, 0, 0, 0deg)';
            await animate(k => {
                modal.style.opacity = (1 - k).toString();
                wrap.style.transform = 'perspective(1300px) rotate3d(1, 0, 0, ' + (-25 * k) + 'deg)';
            }, 150);
            modal.style.display = 'none';
        });

        @if(request()->route()->named('login'))
            setTimeout(showModal, 500);
        @endif
    })();
</script>
