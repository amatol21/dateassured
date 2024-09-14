<?php

use App\Helpers\Svg;
use App\Helpers\IdGenerator;

$id = 'fb-login-button-' . IdGenerator::generate();
?>

<style>
    #{{ $id }} {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dadce0;
        height: 40px;
        border-radius: 4px;
        padding: 5px 16px 5px 5px;
        width: 250px;
        flex-shrink: 0;
        cursor: pointer;
        font-size: 0.75rem;
        line-height: 1;
        cursor: pointer;
        margin: 0 auto;
    }
</style>


<div id="{{ $id }}">
  <?= Svg::icon('facebook', 30, 30, 13.25) ?> <div style="display: inline-block; margin: 0 auto">Sign In with Facebook</div>
</div>

<script>
    (() => {
        document.addEventListener('fb-ready', () => {
            let button = document.getElementById('{{ $id }}');
            button.addEventListener('click', () => {
                FB.login(function(response) {
                    if (response.authResponse) {
                        console.log('Fetching user\'s information from facebook...');
                        FB.api('/me', async response => {
                            console.log(response);
                            try {
                                let res = await fetch('{{ route('loginByFacebook', [], false) }}', {
                                    method: 'POST',
                                    body: JSON.stringify(response),
                                    headers: {
                                        '_token': '{{ csrf_token() }}',
                                        'content-type': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                });
                                if (res.ok && res.redirected) {
                                    window.location = res.url;
                                }
                            } catch (e) {
                                console.error(e);
                            }
                        });
                    } else {
                        console.log('User cancelled login or did not fully authorize.');
                    }
                });
            });
        });
    })();
</script>
