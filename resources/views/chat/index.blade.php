<?php
    use App\Helpers\Svg;
?>
<div id="chat-wrap">
    <div id="chat-skeleton">
        <div class="chat-skeleton_conversations-panel">
            @for($i = 0; $i < 5; $i++)
            <div class="chat-skeleton_conv skeleton">
                <div class="chat-skeleton_conv_photo"></div>
                <div class="chat-skeleton_conv_texts">
                    <div class="chat-skeleton_conv_name"></div>
                    <div class="chat-skeleton_conv_last-msg"></div>
                </div>
            </div>
            @endfor
        </div>

        <div class="chat-skeleton_messages-panel">
            <div class="chat-skeleton_messages-list">

                @for($i = 0; $i < 2; $i++)
                <div class="chat-skeleton_msg skeleton has-followed-msg">
                    <div class="chat-skeleton_msg_photo"></div>
                    <div class="chat-skeleton_msg_text" style="height: <?= rand(3, 6) ?>rem"></div>
                </div>

                <div class="chat-skeleton_msg skeleton">
                    <div class="chat-skeleton_msg_photo"></div>
                    <div class="chat-skeleton_msg_text" style="height: <?= rand(3, 6) ?>rem"></div>
                </div>


                <div class="chat-skeleton_msg skeleton">
                    <div class="chat-skeleton_msg_photo"></div>
                    <div class="chat-skeleton_msg_text" style="height: <?= rand(3, 6) ?>rem"></div>
                </div>
                @endfor
            </div>

            <div class="chat-skeleton_send-form skeleton"></div>
        </div>
    </div>

    <div id="chat" style="display: none; opacity: 0;">
        <div class="chat-conversations-panel"></div>
        <div class="chat_messages-panel">
            <div class="chat_messages_header">
                <div class="chat_messages_back-button"></div>
                <img src="/images/avatar-male.jpg" class="chat_messages_header_avatar">
                <div class="chat_messages_header_name"></div>
            </div>
            <div class="chat_messages-list"></div>
            <form action="#" class="chat_send-form">
                <textarea class="chat_msg-input" name="message"></textarea>
                <button type="submit" class="chat_send-button">
                    <?= Svg::icon('send', 25, 25, 14) ?>
                </button>
            </form>
        </div>
    </div>

    <div id="chat_no-conversations" style="display: none; opacity: 0;">
        <div class="chat_no-conversations-icon">
            <?= Svg::icon('video-chat', 100, 100, 14) ?>
        </div>
        <div class="chat_no-conversations-title">You have no contacts yet</div>
        <div class="chat_no-conversations-hint">
            To find new friends and establish new contacts take participation in upcoming video chat sessions.
        </div>
        <div class="chat_no-conversations-buttons">
            <a href="{{ route('account.videoSessions', [], false) }}" class="btn">Browse video sessions</a>
        </div>
    </div>
</div>


<script>
    document.dispatchEvent(new CustomEvent('chat-init'));
</script>
