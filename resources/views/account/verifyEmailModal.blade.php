<?php

use App\Helpers\Svg;
use Illuminate\Support\Facades\DB;

?>

<div id="verify-email-modal" class="modal" onclick="closeModal(this)">
    <div class="modal-content p-2" style="min-height: 18rem; width: 27rem; max-width: calc(100% - 2rem)">
        <div class="verify-email_send-form">
            <div class="verify-email_icon"><?= Svg::icon('verify-email', 100, 90, 14) ?></div>
            <div class="verify-email_title">Your email is not verified yet</div>
            <div class="verify-email_hint">To send verification mail click button below</div>
            <div class="verify-email_time-hint" style="display: none">Re-sending email will be available after
                <span></span> seconds
            </div>
            <div class="verify-email_buttons">
                <button type="button" class="btn ml-auto" onclick="closeModal(this)">Cancel</button>
                <button type="button" class="btn btn-pink ml-1">Verify email</button>
            </div>
        </div>

        <div class="verify-email_sent-msg" style="display: none">
            <div class="verify-email_icon mr-1"><?= Svg::icon('email-sent', 120, 90, 15) ?></div>
            <div class="verify-email_title">Confirmation email sent</div>
            <div class="verify-email_hint">Check your mailbox and follow instructions</div>
            <div class="verify-email_buttons">
                <button type="button" class="btn btn-pink ml-auto mr-auto" onclick="closeModal(this)">Ok, great!
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        let modal = document.getElementById('verify-email-modal');
        let modalContent = modal.querySelector('.modal-content');
        let sendForm = modal.querySelector('.verify-email_send-form');
        let sendButton = sendForm.querySelector('.btn-pink');
        let sentMessage = modal.querySelector('.verify-email_sent-msg');
        let hint = modal.querySelector('.verify-email_hint');
        let timeHint = modal.querySelector('.verify-email_time-hint');
        let seconds = timeHint.querySelector('span');

        modalContent.addEventListener('click', e => e.stopPropagation());

        // Calculate seconds on the database to avoid timezone mismatch.
        let lastEmailSentAt = Math.round(Date.now()/1000) - {{ auth()->user()->email_verification_sent_at === null ? '61' : DB::select("SELECT (NOW() - email_verification_sent_at) AS t FROM users where id = :id", ['id' => auth()->id()])[0]->t }};

        setInterval(() => {
            let secondsRemains = Math.max(60 - (Math.round((Date.now() / 1000) - lastEmailSentAt)), 0);
            seconds.textContent = secondsRemains.toString();
            hint.style.display = secondsRemains === 0 ? null : 'none';
            timeHint.style.display = secondsRemains === 0 ? 'none' : null;
            sendButton.disabled = secondsRemains > 0;
        }, 1000);

        document.addEventListener('verify-email', () => {
            disableBodyScrollbar();
            sendForm.style.opacity = null;
            sendForm.style.display = null;
            sentMessage.style.opacity = '0';
            sentMessage.style.display = 'none';
            modal.classList.add('shown');
        });

        sendButton.addEventListener('click', async () => {
            await showSpinner(modalContent);

            try {
                let res = await fetch('{{ route('auth.sendEmailVerification', [], false) }}', {
                    method: 'POST',
                    headers: {'content-type': 'application/json'},
                    body: JSON.stringify({_token: '{{ csrf_token() }}'})
                });
                if (res.ok) {
                    console.log('Verification email was successfully sent.');
                }
            } catch (e) {
                console.error(e);
            } finally {
                lastEmailSentAt = Math.round(Date.now() / 1000);
            }

            await delay(500);
            await fadeOut(sendForm);
            await hideSpinner(modalContent);
            await fadeIn(sentMessage);
        });
    })();

</script>
