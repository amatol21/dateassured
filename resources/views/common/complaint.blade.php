<?php

use App\Enums\Size;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @var $complaint Complaint
 */
?>

<style>
    .complaint {
        border-radius: 0.5rem;
    }

    .complaint_subject-label {
        font-size: 0.7rem;
        color: #777;
        margin-bottom: 0.25rem;
    }

    .complaint_subject {
        font-weight: 500;
    }

    .complaint_text-label, .complaint_param-label {
        font-size: 0.7rem;
        color: #777;
        margin-bottom: 0.25rem;
        margin-top: 1rem;
    }

    .complaint_text {
        font-size: 0.9rem;
        color: #333;
        padding-bottom: 2rem;
        margin-bottom: 2rem;
        border-bottom: 1px solid #ccc;
    }

    .complaint_param {
        font-size: 0.9rem;
        color: #333;
    }

    #complaint-msg-form {
        display: flex;
        flex-direction: column;
    }

    #complaint-msg-form textarea {
        min-height: 64px;
    }

    .complaint-message {
        background-color: #eee;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .complaint-message_author_photo {
        width: 3rem;
        height: 3rem;
        border-radius: 3rem;
        margin-right: 1rem;
    }

    .complaint-message_author {
        display: flex;
        align-items: center;
    }

    .complaint-message_author_name {
        font-weight: 500;
    }

    .complaint-message_msg_time {
        font-size: 0.7rem;
        color: #777;
        margin-top: 0.15rem;
    }

    .complaint-message_msg_text {
        padding: 0.5rem;
        background-color: #fff;
        border-radius: 0.35em;
        margin-top: 1rem;
        font-size: 0.85rem;
        color: #333;
        white-space: pre;
    }
</style>


<div class="complaint">
    <div class="complaint_subject-label">Title:</div>
    <div class="complaint_subject">{{ $complaint->subject }}</div>
    <div class="complaint_param-label">Video session:</div>
    @if(empty($complaint->video_session_id))
        <div class="complaint_param">(Not set)</div>
    @elseif(User::current()->hasPermission(\App\Enums\Permission::COMPLAINTS))
        <a href="{{ route('admin.videoSessions', [], false) }}?name={{ $complaint->video_session_id }}"
           class="complaint_param">ID: {{ $complaint->video_session_id }}</a>
    @else
        <div class="complaint_param">ID: {{ $complaint->video_session_id }}</div>
    @endif

    <div class="complaint_text-label">Message:</div>
    <div class="complaint_text">{{ $complaint->message }}</div>

    <div id="complaint-messages">
        @foreach($complaint->messages as $message)
            <div class="complaint-message outgoing" data-id="{{ $message->id }}">
                <div class="complaint-message_author">
                    <img class="complaint-message_author_photo"
                         src="{{ $message->user->getPhotoUrl(Size::SMALL) }}" alt="{{ $message->user->username }}">
                    <div class="complaint-message_author_texts">
                        <div class="complaint-message_author_name">{{ $message->user->username }}</div>
                        <div class="complaint-message_msg_time">Sent at {{ $message->created_at }}</div>
                    </div>
                </div>

                <div class="complaint-message_msg">
                    <div class="complaint-message_msg_text">{{ $message->message }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <form id="complaint-msg-form" data-id="{{ $complaint->id }}">
        <textarea name="message" class="input" placeholder="Input your message..."></textarea>
        <button type="submit" class="btn btn-pink mt-1 ml-auto">Send</button>
    </form>
</div>


<script>
    (() => {
        let sendForm = document.getElementById('complaint-msg-form');
        let textarea = sendForm.querySelector('textarea');
        let messages = document.getElementById('complaint-messages');

        function sendMessage(message) {
            textarea.value = '';
            textarea.style.height = null;
            document.dispatchEvent(new CustomEvent('send-complaint-message', {
                detail: {
                    complaintId: sendForm.dataset.id,
                    message: message
                }
            }));
        }

        makeTextareaAsMessageInput(textarea);

        textarea.addEventListener('send', e => sendMessage(e.detail));
        sendForm.addEventListener('submit', e => {
            e.preventDefault();
            sendMessage(textarea.value);
        });


        function createMessage(data) {
            let wrap = makeElement('div', 'complaint-message');
            wrap.dataset.id = data.id;
            let author = makeElement('div', 'complaint-message_author', wrap);
            let photo = makeElement('img', 'complaint-message_author_photo', author);
            photo.src = data.sender.photoUrl;
            photo.setAttribute('alt', data.sender.username);
            let texts = makeElement('div', 'complaint-message_author_texts', author);
            let name = makeElement('div', 'complaint-message_author_name', texts);
            name.textContent = data.sender.username;
            let d = new Date(data.time);
            let time = makeElement('div', 'complaint-message_msg_time', texts)
            time.textContent = d.getDate().toString().padStart(2, '0') + '.'
                + (d.getMonth() + 1).toString().padStart(2, '0') + '.'
                + d.getFullYear().toString() + ' '
                + (d.getHours().toString().padStart(2, '0')) + ':' + (d.getMinutes().toString().padStart(2, '0'));
            let msgWrap = makeElement('div', 'complaint-message_msg', wrap);
            let msg = makeElement('div', 'complaint-message_msg_text', msgWrap);
            msg.textContent = data.text;
            if (data.sender.id === {{ Auth::id() }}) {
                wrap.classList.add('outgoing');
            } else {
                wrap.classList.add('incoming');
            }
            return wrap;
        }

        document.addEventListener('complaint-message', e => {
            if (e.detail.complaintId !== {{ $complaint->id }}) return;
            let msg = createMessage(e.detail.message);
            messages.appendChild(msg);
        });
    })();
</script>
