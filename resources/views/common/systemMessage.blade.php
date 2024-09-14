@php use App\Models\Config; @endphp
@if(Config::getMaintenance() !== null)
    <style>
        .sys-msg_modal_wrap {
            display: flex;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            background-color: #00000022;
            visibility: hidden;
            opacity: 0;
            transition: 500ms;
        }
        .sys-msg_modal_wrap.shown {
            visibility: visible;
            opacity: 1;
        }
        .sys-msg_modal {
            width: 30rem;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto;
            padding: 2rem;
        }
        .sys-msg_text {
            text-align: center;
            line-height: 1.5;
        }
    </style>
    <div class="sys-msg_modal_wrap" id="sys-msg-modal">
        <div class="sys-msg_modal pad">
            <div class="sys-msg_text">{!! nl2br(e(Config::getMaintenance()->maintenance_message)) !!}</div>
            <button type="button" class="btn btn-pink mt-1"
                    onclick="document.getElementById('sys-msg-modal').classList.remove('shown')">OK</button>
        </div>
    </div>
    <script>
        (() => {
            setTimeout(() => {
                document.getElementById('sys-msg-modal').classList.add('shown');
            }, 1500);
        })();
    </script>
@endif

