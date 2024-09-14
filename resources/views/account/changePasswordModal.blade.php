<?php

use App\Models\User;

?>

<div id="change-pass-modal" class="modal" onclick="closeModal(this)">
    <form action="{{ route('changePassword', [], false) }}" id="change-pass-form" class="modal-content p-2"
          onclick="event.stopPropagation()">
        @csrf

        @if(User::current()->password !== User::DUMMY_PASSWORD)
            <label>
                <span class="label">Old password</span>
                <input type="password" name="current_password" class="input" required>
                <span class="error" data-for="current_password"></span>
            </label>
        @endif

        <label class="mt-1">
            <span class="label">New password</span>
            <input type="password" name="new_password" class="input" required>
            <span class="error" data-for="new_password"></span>
        </label>

        <label class="mt-1">
            <span class="label">Confirm new password</span>
            <input type="password" name="new_password_confirmation" class="input" required>
            <span class="error" data-for="new_password_confirmation"></span>
        </label>

        <div class="flex mt-2">
            <button type="button" class="btn mr-1 ml-auto" onclick="closeModal(this)">Cancel</button>
            <button type="submit" class="btn btn-pink">Change password</button>
        </div>
    </form>
</div>

<script>
    (() => {
        let modal = document.getElementById('change-pass-modal');
        let form = document.getElementById('change-pass-form');

        document.addEventListener('change-password', () => {
            form.reset();
            clearFormErrors(form);
            modal.classList.add('shown');
            disableBodyScrollbar();
        });

        form.addEventListener('submit', async e => {
            e.preventDefault();
            clearFormErrors(form);
            await showSpinner(form);
            try {
                let res = await fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {'X-Requested-With': 'XMLHttpRequest'}
                });

                if (res.ok) {
                    await hideSpinner(form, 'Password changed');
                    modal.classList.remove('shown');
                } else {
                    let data = await res.json();
                    showFormErrors(form, data);
                    await hideSpinner(form);
                }
            } catch (e) {
                console.error(e);
            }
        });
    })();
</script>
