<?php

use App\Helpers\IdGenerator;

$id = 'google-login-button-' . IdGenerator::generate();
?>

<div id="{{ $id }}" class="flex jc-center"></div>

<script>
    (() => {
        let googleLoginButton = document.getElementById('{{ $id }}');

        document.addEventListener('google-ready', () => {
            google.accounts.id.renderButton(
                googleLoginButton,
                {
                    type: 'standard',
                    theme: "outline",
                    text: 'signin_with',
                    size: "large",
                    width: "250"
                }
            );
        });
    })();
</script>
