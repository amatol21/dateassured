<?php
use App\Helpers\Svg;
?>

<div id="forgot-password-modal" class="modal" onclick="closeModal(this)" style="z-index: 101">

    <div class="modal-content p-2">
        <div class="modal_close-button" onclick="closeModal(this)"><?= Svg::icon('cross', 24, 24, 14) ?></div>

        <div id="forgot-password-sent-msg" class="verify-email_sent-msg" style="display: none">
            <div class="verify-email_icon mr-1"><?= Svg::icon('email-sent', 120, 90, 15) ?></div>
            <div class="verify-email_title">Confirmation email sent</div>
            <div class="verify-email_hint">Check your mailbox and follow instructions</div>
            <div class="verify-email_buttons">
                <button type="button" class="btn btn-pink ml-auto mr-auto" onclick="closeModal(this)">Ok, great!
                </button>
            </div>
        </div>

        <form action="{{ route('forgotPassword', [], false) }}" id="forgot-pass-form">
            @csrf

            <div class="flex column ai-center" style="width: 25rem; max-width: 100%;">
                <div class="chat_no-conversations-title">Password reset</div>
                <div class="chat_no-conversations-hint">
                    To reset your password fill in your email in the field below and
                    follow instructions that will be sent you by email.
                </div>
            </div>

            <label class="flex column mt-2">
                <span class="label">Your email</span>
                <input type="email" name="email" class="input" required>
                <span class="error" data-for="email"></span>
            </label>

            <div class="flex jc-end mt-2">
                <button type="button" class="btn" onclick="closeModal(this)">Cancel</button>
                <button type="submit" class="btn btn-pink ml-1">Reset password</button>
            </div>
        </form>
    </div>
</div>

<script>
    (() => {
        let modal = document.getElementById('forgot-password-modal');
        let modalContent = modal.querySelector('.modal-content');
        let form = document.getElementById('forgot-pass-form');
        let successMsg = document.getElementById('forgot-password-sent-msg');

        modalContent.addEventListener('click', e => e.stopPropagation());

        document.addEventListener('forgot-password', () => {
            form.reset();
            clearFormErrors(form);
            modal.classList.add('shown');
            disableBodyScrollbar();
        });

        form.addEventListener('submit', async e => {
            e.preventDefault();
            clearFormErrors(form);
            await showSpinner(modalContent);
            try {
                let res = await fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {'X-Requested-With': 'XMLHttpRequest'}
                });

                if (res.ok) {
                    await fadeOut(form);
                    await fadeIn(successMsg);
                    await hideSpinner(modalContent);
                    modal.classList.remove('shown');
                } else {
                    let data = await res.json();
                    showFormErrors(form, data);
                    await hideSpinner(modalContent);
                }
            } catch (e) {
                console.error(e);
                await hideSpinner(modalContent);
            }
        });
    })();
</script>
