<?php

use App\Enums\Size;
use App\Helpers\Svg;
use App\Models\User;
use App\Models\VideoSessionTalk;

/**
 * @var User $user
 * @var VideoSessionTalk[] $talks
 */
?>

<style>
    .talks_header {
        padding: 1.25rem 2rem;
        border-bottom: 1px solid #ccc;
        font-size: 1.25rem;
        font-weight: 500;
        color: #333;
    }

    .talk {
        display: flex;
        align-items: center;
        padding: 1rem;
        position: relative;
    }

    .talk.interrupted::before {
        content: 'Interrupted';
        display: flex;
        width: 10rem;
        height: 3rem;
        position: absolute;
        top: 2rem;
        left: calc(50% - 5rem);
        justify-content: center;
        align-items: center;
        text-align: center;
        background-color: #fff;
        color: #555;
    }

    .talk + .talk {
        border-top: 1px solid #ccc;
    }

    .talk_member {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        margin-bottom: auto;
        height: 100%;
    }

    .talk_member.talk_member_male {
        width: 50%;
        border-right: 1px solid #ccc;
        padding-right: 1rem;
    }

    .talk_member.talk_member_female {
        margin-left: auto;
        width: calc(50% - 1rem);
    }

    .talk_member_photo {
        width: 5rem;
        height: 5rem;
        border-radius: 3rem;
    }

    .talk_member_male .talk_member_photo {
        border: 2px solid var(--color-blue);
    }

    .talk_member_female .talk_member_photo {
        border: 2px solid var(--color-pink);
    }

    .talk_member_name {
        font-weight: 500;
        margin-top: 0.5rem;
        font-size: 0.8rem;
    }

    .talk_rate {
        margin-top: 0.5rem;
    }

    .talk_rate_like,
    .talk_rate_dislike,
    .talk_rate_empty {
        font-size: 0.75rem;
        color: #fff;
        height: 1.25rem;
        display: flex;
        align-items: center;
        padding: 0 0.5rem;
        border-radius: 2rem;
    }

    .talk_rate_like {
        background-color: var(--color-green);
    }

    .talk_rate_dislike {
        background-color: var(--color-red);
    }

    .talk_rate_empty {
        background-color: #777;
    }

    .talk_comment {
        margin-top: 1rem;
        padding: 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
    }

    .talk_member_male .talk_comment {
        background-color: #dcecfa;
    }

    .talk_member_female .talk_comment {
        background-color: #eedce3;
    }

    .talk_buttons {
        display: flex;
        padding: 1rem;
        border-top: 1px solid #ccc;
    }

    .talk_video {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        background-color: #000;
        visibility: hidden;
        opacity: 0;
        transition: 250ms;
    }

    .talk_video.shown {
        visibility: visible;
        opacity: 1;
    }

    .talk_video video {
        width: 100%;
        height: 100%;
    }

    .talk_show-video-button {
        width: 4rem;
        height: 4rem;
        border-radius: 100%;
        border: 1px solid #ccc;
        outline: 8px solid #fff;
        position: absolute;
        left: calc(50% - 2rem);
        top: calc(50% - 2rem);
        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .talk_show-video-button::before {
        content: '';
        display: block;
        width: 0;
        height: 0;
        border-left: 16px solid #ccc;
        border-top: 12px solid transparent;
        border-bottom: 12px solid transparent;
        position: absolute;
        left: 1.6rem;
        top: 1.2rem;
    }

    .talk_show-video-button:hover {
        border-color: #999;
    }

    .talk_show-video-button:hover::before {
        border-left-color: #999;
    }
    .talk_video_close-button {
        position: absolute;
        right: 1rem;
        top: 1rem;
        width: 2rem;
        height: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 2;
    }
    .talk_video_close-button svg {
        fill: #ffffff99;
    }
    .talk_video_close-button:hover svg {
        fill: #fff;
    }
</style>



@if(count($talks) === 0)
    <div id="chat_no-conversations" class="pad p-2" style="width: 40rem; max-width: 100%">
        <div class="chat_no-conversations-title">There is no talks for {{ $user->getFullName() }}</div>
        <div class="chat_no-conversations-hint">
            Probably too few members was joined video session for creating some talks.
        </div>
        <div class="chat_no-conversations-buttons">
            <button type="button" class="btn btn-pink ml-2" onclick="closeModal(this)">Close</button>
        </div>
    </div>
@else
    <div>
        <div class="talks_header">
            Talks of {{ $user->getFullName() }}
        </div>
        @foreach($talks as $talk)
            <div class="talk @if($talk->status !== 0) interrupted @endif">
                <div class="talk_member talk_member_male">
                    <img src="{{ $talk->user1->getPhotoUrl(Size::MEDIUM) }}" alt="{{ $talk->user1->getFullName() }}"
                         class="talk_member_photo">
                    <div class="talk_member_name">{{ $talk->user1->getFullName() }}</div>
                    <div class="talk_rate">
                        @if($talk->rate_from_user_1 > 0)
                            <div class="talk_rate_like">Like</div>
                        @elseif($talk->rate_from_user_1 < 0)
                            <div class="talk_rate_dislike">Dislike</div>
                        @else
                            <div class="talk_rate_empty">No rate</div>
                        @endif
                    </div>
                    <div class="talk_comment">
                        {{ empty($talk->comment_from_user_1) ? '(No comment)' : $talk->comment_from_user_1 }}
                    </div>
                </div>
                <div class="talk_member talk_member_female">
                    <img src="{{ $talk->user2->getPhotoUrl(Size::MEDIUM) }}" alt="{{ $talk->user2->getFullName() }}"
                         class="talk_member_photo">
                    <div class="talk_member_name">{{ $talk->user2->getFullName() }}</div>
                    <div class="talk_rate">
                        @if($talk->rate_from_user_2 > 0)
                            <div class="talk_rate_like">Like</div>
                        @elseif($talk->rate_from_user_2 < 0)
                            <div class="talk_rate_dislike">Dislike</div>
                        @else
                            <div class="talk_rate_empty">No rate</div>
                        @endif
                    </div>
                    <div class="talk_comment">
                        {{ empty($talk->comment_from_user_2) ? '(No comment)' : $talk->comment_from_user_2 }}
                    </div>
                </div>

                @if(!empty($talk->video_url))
                    <div class="talk_show-video-button"
                         onclick=""></div>
                    <div class="talk_video">
                        <div class="talk_video_close-button">
                                <?= Svg::icon('cross', 20, 20, 14) ?>
                        </div>
                        <video src="{{ env('CLOUDFRONT_DOMAIN') . '/' . $talk->video_url }}" controls></video>
                    </div>
                @endif
            </div>
        @endforeach
        <div class="talk_buttons">
            <button type="button" class="btn btn-pink ml-auto" onclick="closeModal(this)">Close</button>
        </div>
    </div>

    <script>
        (() => {
            let showVideoButtons = document.querySelectorAll('.talk_show-video-button');
            let closeVideoButtons = document.querySelectorAll('.talk_video_close-button');
            let closeModalButton = document.querySelector('.talk_buttons button');
            let activeVideo = null;

            console.log(showVideoButtons);

            function showVideo() {
                this.parentNode.querySelector('.talk_video').classList.add('shown');
                activeVideo = this.parentNode.querySelector('video');
                activeVideo.play();
            }

            function hideVideo() {
                this.parentNode.classList.remove('shown');
                this.parentNode.querySelector('video').pause();
            }

            for (let i = 0; i < showVideoButtons.length; i++) {
                showVideoButtons[i].addEventListener('click', showVideo);
            }

            for (let i = 0; i < closeVideoButtons.length; i++) {
                closeVideoButtons[i].addEventListener('click', hideVideo);
            }

            closeModalButton.addEventListener('click', () => activeVideo.pause());
        })();
    </script>
@endif



