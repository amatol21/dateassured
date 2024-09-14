<div id="reg-modal" style="display: none">
    <div class="reg-modal__wrap">
        <div class="modal_close-button">
            <?= \App\Helpers\Svg::icon('cross', 24, 24, 14) ?>
        </div>
        <div class="reg-modal__left">
            <img src="/images/reg-form-banner.jpg" alt="Online dating">
        </div>
        <div class="reg-modal__right">
            @include('auth.regForm')
        </div>
    </div>
</div>

<script>
    (() => {
        let modal = document.getElementById('reg-modal');
        let wrap = modal.querySelector('.reg-modal__wrap');
        let closeButton = modal.querySelector('.modal_close-button');

        if (wrap !== null) wrap.addEventListener('click', e => e.stopPropagation());
        modal.addEventListener('click', () => {
            document.dispatchEvent(new CustomEvent('hide-reg-modal'));
        });
        closeButton.addEventListener('click', () => {
            document.dispatchEvent(new CustomEvent('hide-reg-modal'));
        });

        async function showModal() {
            clearFormErrors(modal);
            disableBodyScrollbar();
            modal.style.opacity = '0';
            wrap.style.transform = 'perspective(1300px) rotate3d(1, 0, 0, 25deg)';
            modal.style.display = null;
            await animate(k => {
                modal.style.opacity = k.toString();
                wrap.style.transform = 'perspective(1300px) rotate3d(1, 0, 0, ' + (25 - (25 * k)) + 'deg)';
            }, 150);
            prepareForm(modal);
        }

        document.addEventListener('show-reg-modal', showModal);

        document.addEventListener('hide-reg-modal', async e => {
            wrap.style.transform = 'perspective(1300px) rotate3d(1, 0, 0, 0deg)';
            await animate(k => {
                modal.style.opacity = (1 - k).toString();
                wrap.style.transform = 'perspective(1300px) rotate3d(1, 0, 0, ' + (-35 * k) + 'deg)';
            }, 150);
            modal.style.display = 'none';
            enableBodyScrollbar();
        });

        @if(request()->route()->named('register'))
        setTimeout(showModal, 500);
        @endif
    })();
</script>
