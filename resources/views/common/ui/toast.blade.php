@php

use App\Helpers\Toast;

@endphp

@if(Toast::isAvailable())
    <style>
        .toast {
            display: flex;
            width: 25rem;
            max-width: 100%;
            border-radius: 0.25rem;
            padding: 1rem;
            color: #fff;
            font-weight: 500;
            font-size: 0.85rem;
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            z-index: 1000;
            opacity: 0;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.04), 0 10px 7px rgba(0, 0, 0, 0.09), 0 15px 32px rgba(0, 0, 0, 0.2);
        }
        .toast.info {
            background-color: var(--color-blue);
        }
        .toast.success {
            background-color: var(--color-green);
        }
        .toast.warning {
            background-color: var(--color-orange);
        }
        .toast.error {
            background-color: var(--color-red);
        }
    </style>

    <div id="toast" class="toast {{ Toast::getStatus() }}">
        {{ Toast::getMessage() }}
    </div>

    <script>
        (() => {
            let toast = document.getElementById('toast');
            setTimeout(async () => {
                toast.style.opacity = '0';
                await animate(k => toast.style.opacity = k.toString(), 250);
                await delay(3000);
                await animate(k => toast.style.opacity = (1 - k).toString(), 250);
                toast.parentNode.removeChild(toast);
            }, 500);
        })();
    </script>
@endif
