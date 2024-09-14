<?php
    use App\Helpers\Svg;
?>

<div id="vs-modal-wrap" style="display: none">
    <div id="vs-modal">
        <div id="vs-modal__close-button">
            <?= Svg::icon('cross', 14, 14) ?>
        </div>
        <div id="vs-modal__header"></div>

        <div id="vs-video-wrap" style="display: none; opacity: 0">
            <div id="vs-video-timer"></div>
            <div id="vs-video-username"></div>
            <div id="vs-video-leave-button">Leave session</div>
            <div id="vs-video-mute-button">
                <?= Svg::icon('unmute', 28, 28, 14) ?>
            </div>
            <div id="vs-video-unmute-button" style="display: none">
                <?= Svg::icon('mute', 28, 28, 14) ?>
            </div>
            <div id="vs-video-fullscreen-button">
                <?= Svg::icon('fullscreen', 28, 28, 14) ?>
            </div>
            <div id="vs-video-exit-fullscreen-button" style="display: none">
                <?= Svg::icon('exit-fullscreen', 28, 28, 14) ?>
            </div>
            <video id="vs-video-remote" playsinline autoplay></video>
            <video id="vs-video-local" playsinline autoplay muted></video>
        </div>

        <div id="vs-rate-wrap">
            <div id="vs-rate-title">How was <span></span>?</div>
            <div id="vs-rate-buttons">
                <div id="vs-like-button">
                    <?= Svg::icon('like', 50, 50, 14) ?>
                </div>
                <div id="vs-dislike-button">
                    <?= Svg::icon('dislike', 50, 50, 14) ?>
                </div>
            </div>
            <div id="vs-rate-skip-button">Skip</div>
        </div>

        <div id="vs__teams-wrap" style="opacity: 0">
            <div class="vs__team__title">Male</div>
            <div id="vs__team-male" class="vs__team"></div>

            <div id="vs-timer">
                <div id="vs-timer-time"></div>
                <div id="vs-timer-status">Waiting for start</div>
            </div>

            <div class="vs__team__title">Female</div>
            <div id="vs__team-female" class="vs__team"></div>
        </div>

        <div id="vs-modal__buttons">
            <div id="vs-join-button" style="display: none; opacity: 0">Join</div>
            <div id="vs-leave-button" style="display: none; opacity: 0">Leave</div>
        </div>
    </div>
</div>


<div id="vs-gone-modal" class="modal">
    <div class="modal-content">
        <div class="vs-gone-modal_title">Video session is gone</div>
        <div class="vs-gone-modal_hint">
            Probably this video session is gone or deleted.
            Stay in tune for the new upcoming dating sessions.
        </div>
        <div class="vs-gone-modal_buttons">
            <button type="button" class="btn btn-pink" onclick="closeModal(this)">OK, I understand</button>
        </div>
    </div>
</div>

<script>
    (() => {
        let wrap = document.getElementById('vs-modal-wrap');
        let modal = document.getElementById('vs-modal');
        let header = document.getElementById('vs-modal__header');
        let closeButton = document.getElementById('vs-modal__close-button');
        let teamsWrap = document.getElementById('vs__teams-wrap');
        let teamMale = document.getElementById('vs__team-male');
        let teamFemale = document.getElementById('vs__team-female');
        let buttonsWrap = document.getElementById('vs-modal__buttons');
        let joinButton = document.getElementById('vs-join-button');
        let leaveButton = document.getElementById('vs-leave-button');
        let timer = document.getElementById('vs-timer');
        let timerTime = document.getElementById('vs-timer-time');
        let timerStatus = document.getElementById('vs-timer-status');
        let videoWrap = document.getElementById('vs-video-wrap');
        let remoteVideo = document.getElementById('vs-video-remote');
        let localVideo = document.getElementById('vs-video-local');
        let videoTimer = document.getElementById('vs-video-timer');
        let muteButton = document.getElementById('vs-video-mute-button');
        let unmuteButton = document.getElementById('vs-video-unmute-button');
        let fullscreenButton = document.getElementById('vs-video-fullscreen-button');
        let exitFullscreenButton = document.getElementById('vs-video-exit-fullscreen-button');
        let username = document.getElementById('vs-video-username');
        let leaveTalkButton = document.getElementById('vs-video-leave-button');
        let rateWrap = document.getElementById('vs-rate-wrap');
        let rateTitle = document.getElementById('vs-rate-title');
        let likeButton = document.getElementById('vs-like-button');
        let dislikeButton = document.getElementById('vs-dislike-button');
        let skipRateButton = document.getElementById('vs-rate-skip-button');
        let vsGoneModal = document.getElementById('vs-gone-modal');

        let rateButtonsHiding = false;
        let isFullscreen = false;

        likeButton.addEventListener('click', () => {
            likeButton.classList.add('active');
            dislikeButton.classList.add('inactive');
            skipRateButton.classList.add('inactive');
            setTimeout(() => {
                likeButton.classList.remove('active');
                dislikeButton.classList.remove('inactive');
                skipRateButton.classList.remove('inactive');
            }, 5000);
            setTimeout(hideRateButtons, 1000);
            document.dispatchEvent(new CustomEvent('rate-talk', {detail: 1}));
        });

        dislikeButton.addEventListener('click', () => {
            dislikeButton.classList.add('active');
            likeButton.classList.add('inactive');
            skipRateButton.classList.add('inactive');
            setTimeout(() => {
                dislikeButton.classList.remove('active');
                likeButton.classList.remove('inactive');
                skipRateButton.classList.remove('inactive');
            }, 5000);
            setTimeout(hideRateButtons, 1000);
            document.dispatchEvent(new CustomEvent('rate-talk', {detail: -1}));
        });

        function hideRateButtons() {
            if (rateWrap.style.display === 'none') return;
            if (rateButtonsHiding) return;
            rateButtonsHiding = true;
            fadeOut(rateWrap, 500).then(() => {
                Promise.all([fadeIn(teamsWrap, 500), fadeIn(buttonsWrap, 500)]).then(() => {
                    rateButtonsHiding = false;
                    if (vs !== null && vs.status === 3) {
                        setTimeout(closeModal, 2000);
                    }
                })
            });
        }

        skipRateButton.addEventListener('click', () => {
            hideRateButtons();
        })

        localVideo.addEventListener('load', () => {
            localVideo.play();
        });
        remoteVideo.addEventListener('load', () => {
            remoteVideo.play();
        });

        remoteVideo.addEventListener('loadedmetadata', () => {
            remoteVideo.style.width = remoteVideo.videoWidth > remoteVideo.videoHeight ? '100%' : 'auto';
            remoteVideo.style.height = remoteVideo.videoWidth > remoteVideo.videoHeight ? 'auto' : '100%';
        });

        let countdown = new Countdown();
        countdown.onUpdate(timerString => {
            timerTime.textContent = timerString;
            videoTimer.textContent = timerString;
        });

        let modalShown = false;
        let vs = null;
        let isTalkingNow = false;

        async function closeModal() {
            modal.classList.remove('shown');
            fadeOut(teamsWrap, 250, false);
            await fadeOut(wrap)
            enableBodyScrollbar();
            modalShown = false;
        }

        wrap.addEventListener('click', () => {
            if (vs.status !== 1) closeModal()
        });
        closeButton.addEventListener('click', closeModal);
        modal.addEventListener('click', e => e.stopPropagation());

        document.addEventListener('show-video-session-details', async e => {
            await showModal(e.detail);
        });

        async function showModal(data) {
            if (modalShown) return;
            modalShown = true;
            vs = data;
            clearHighlights();
            updateDetails();
            requestAnimationFrame(() => modal.classList.add('shown'));
            disableBodyScrollbar();
            videoWrap.style.display = 'none';
            videoWrap.style.opacity = '0';
            joinButton.style.display = 'none';
            joinButton.style.opacity = '0';
            leaveButton.style.display = 'none';
            leaveButton.style.opacity = '0';
            rateWrap.style.display = 'none';
            rateWrap.style.opacity = '0';
            await fadeIn(wrap);
            if (!isTalkingNow) await fadeIn(teamsWrap, 500);
        }

        document.addEventListener('video-session-update', async e => {
            console.log(e.detail);
            let data = e.detail.info;
            data.contacts = e.detail.contacts;
            if (!modalShown && data.members !== undefined) showModal(data);
            if (data.members !== undefined && vs !== null && data.id !== vs.id) return;
            vs = data;

            if (data.members === undefined) {
                vsGoneModal.classList.add('shown');
                await fadeOut(wrap);
                return;
            }
            updateDetails();
        });

        document.addEventListener('highlight-members', e => {
            if (vs === null || vs.id !== e.detail.videoSessionId) return;
            highlightMembers(e.detail.members);
        });

        document.addEventListener('error-message', e => {
            alert(e.detail);
        });

        document.addEventListener('start-talk', () => {
            hideRateButtons();
            setTimeout(() => {
                isTalkingNow = true;
                requestAnimationFrame(() => {
                    Promise.all([
                        fadeOut(teamsWrap, 250, false),
                        fadeOut(buttonsWrap, 250, false)
                    ]).then(() => {
                        fadeIn(videoWrap, 250).then(() => {
                            if (window.innerWidth < 700) {
                                fullscreen();
                            }
                        });
                    });
                });
            }, 1000)
        });

        muteButton.addEventListener('click', async () => {
            muteButton.style.display = 'none';
            unmuteButton.style.display = null;
            document.dispatchEvent(new CustomEvent('vs-mute'));
        });

        unmuteButton.addEventListener('click', async () => {
            unmuteButton.style.display = 'none';
            muteButton.style.display = null;
            document.dispatchEvent(new CustomEvent('vs-unmute'));
        });

        fullscreenButton.addEventListener('click', async () => {
            fullscreenButton.style.display = 'none';
            exitFullscreenButton.style.display = null;
            fullscreen();
        });

        exitFullscreenButton.addEventListener('click', async () => {
            exitFullscreenButton.style.display = 'none';
            fullscreenButton.style.display = null;
            exitFullscreen();
        });

        async function fullscreen() {
            if (isFullscreen) return;
            isFullscreen = true;
            let rect = modal.getBoundingClientRect();
            videoWrap.style.left = rect.left + 'px';
            videoWrap.style.top = rect.top + 'px';
            videoWrap.style.width = rect.width + 'px';
            videoWrap.style.height = rect.height + 'px';
            videoWrap.style.position = 'fixed';
            await animate(k => {
                videoWrap.style.left = rect.left - (rect.left * k) + 'px';
                videoWrap.style.top = rect.top - (rect.top * k) + 'px';
                videoWrap.style.width = rect.width + ((window.innerWidth - rect.width) * k) + 'px';
                videoWrap.style.height = rect.height + ((window.innerHeight - rect.height) * k) + 'px';
            }, 150);
            videoWrap.style.borderRadius = '0';
        }

        async function exitFullscreen() {
            if (!isFullscreen) return;
            isFullscreen = false;
            let rect = modal.getBoundingClientRect()
            await animate(k => {
                videoWrap.style.left = (rect.left * k) + 'px';
                videoWrap.style.top = (rect.top * k) + 'px';
                videoWrap.style.width = window.innerWidth - ((window.innerWidth - rect.width) * k) + 'px';
                videoWrap.style.height = window.innerHeight - ((window.innerHeight - rect.height) * k) + 'px';
            }, 150);
            videoWrap.style.borderRadius = null;
            videoWrap.style.left = '0';
            videoWrap.style.top = '0';
            videoWrap.style.width = null;
            videoWrap.style.height = null;
            videoWrap.style.position = 'absolute';
        }

        document.addEventListener('end-talk', () => {
            isTalkingNow = false;
            rateTitle.querySelector('span').textContent = username.textContent;
            exitFullscreen();
            fadeOut(videoWrap, 500, true).then(() => {
                fadeIn(rateWrap, 500);
                setTimeout(() => {
                    hideRateButtons();
                    document.dispatchEvent(new CustomEvent('request-talk-result'));
                }, 5000);
            });
        });

        document.addEventListener('talk-result', e => {
            let result = e.detail;
            if (result.rateFromMe === 0 && result.rateFromAnother > 0) {
                if (confirm(result.user.username +
                    " just liked you. Do you want to make private chat with "
                    + (result.user.gender === 0 ? 'he' : 'she') + "?")
                ) {
                    document.dispatchEvent(new CustomEvent('rate-talk', {detail: 1}));
                }
            }
        });

        document.addEventListener('local-video-stream-ready', e => {
            localVideo.srcObject = null;
            localVideo.srcObject = e.detail
        });

        document.addEventListener('remote-video-stream-ready', e => {
            remoteVideo.srcObject = null;
            remoteVideo.srcObject = e.detail
        });

        joinButton.addEventListener('click', () => {
            document.dispatchEvent(new CustomEvent('join-video-session', {detail: vs.id}));
        });

        leaveButton.addEventListener('click', () => {
            document.dispatchEvent(new CustomEvent('leave-video-session', {detail: vs.id}));
        });

        leaveTalkButton.addEventListener('click', () => {
            if (confirm('Are you really want to leave talk?')) {
                document.dispatchEvent(new CustomEvent('leave-talk', {
                    detail: prompt('Tell us why you left talk:', '')
                }));
            }
        });

        function clearHighlights() {
            for (let i = 0; i < teamMale.childNodes.length; i++) {
                teamMale.childNodes[i].classList.remove('vs-team-member_highlighted');
            }
            for (let i = 0; i < teamFemale.childNodes.length; i++) {
                teamFemale.childNodes[i].classList.remove('vs-team-member_highlighted');
            }
        }

        function highlightMembers(members) {
            if (members.length === 0) {
                clearHighlights();
                return;
            }
            members.map(position => {
                let cont = teamMale;
                let arr = vs.members.male
                if (position >= vs.teamSize) {
                    position -= vs.teamSize;
                    cont = teamFemale;
                    arr = vs.members.female
                }
                if (arr[position].id !== window.userId) {
                    username.textContent = arr[position].username;
                }
                if (position >= cont.childNodes.length) return;
                cont.childNodes[position].classList.add('vs-team-member_highlighted');
            });
        }

        function fillSkeletons(container) {
            container.innerHTML = '';
            let html = '';
            for (let i = 0; i < vs.teamSize; i++) {
                html += '<div class="vs__team__member-skeleton"></div>';
            }
            container.innerHTML = html;
        }

        function updateMembers(container, members) {
            for (let i = 0; i < members.length; i++) {
                skeletonToMember(container.childNodes[i], members[i]);
            }
        }

        function memberToSkeleton(el) {

        }

        function avatarErrorHandler() {
            this.src = '/images/' + (this.__gender === 0 ? 'male.svg' : 'female.svg');
        }

        async function skeletonToMember(oldElement, member) {
            if (oldElement.classList.contains('vs__team__member')) {
                let isHighlighted = oldElement.classList.contains('vs-team-member_highlighted');
                oldElement.className = 'vs__team__member';
                if (isHighlighted) oldElement.classList.add('vs-team-member_highlighted');
                oldElement.classList.add(member === false ? 'vs__team__no-member' : 'vs__team__real-member');
                if (member !== false) {
                    oldElement.classList.add('gender-' + (member.gender === 0 ? 'male' : 'female'));
                }
                oldElement.__photo.src = member === false
                    ? '/images/no-member.png'
                    : (member.photoUrl === '' ? '/images/' + (member.gender === 0 ? 'male.svg' : 'female.svg') : member.photoUrl);

                oldElement.__photo.__gender = member === false ? null : member.gender;
                oldElement.__photo.alt = member === false ? 'Free place' : member.username;
                oldElement.__age.textContent = member.age;
                if (Array.isArray(vs.contacts) && vs.contacts.indexOf(member.id) >= 0) {
                    oldElement.classList.add('is-contact');
                } else {
                    oldElement.classList.remove('is-contact');
                }
                return;
            }

            let wrap = document.createElement('div');
            wrap.className = 'vs__team__member';
            wrap.classList.add(member === false ? 'vs__team__no-member' : 'vs__team__real-member');
            if (member !== false) {
                wrap.classList.add('gender-' + (member.gender === 0 ? 'male' : 'female'));
            }

            let photo = document.createElement('img');
            photo.className = 'vs__team__member-photo';
            photo.alt = member === false ? 'Free place' : member.username;
            photo.onerror = photo.src = '/images/' + (member.gender === 0 ? 'male.svg' : 'female.svg');
            photo.src = member === false ? '/images/no-member.png' : (member.photoUrl === '' ? '/images/' + (member.gender === 0 ? 'male.svg' : 'female.svg') : member.photoUrl);
            photo.__gender = member === false ? null : member.gender;
            photo.onerror = avatarErrorHandler;
            wrap.appendChild(photo);
            wrap.__photo = photo;

            let age = document.createElement('div');
            age.className = 'vs__team__member__age';
            age.textContent = member === false ? '' : member.age;
            wrap.appendChild(age);
            wrap.__age = age;

            if (oldElement.classList.contains('vs__team__member-skeleton')) {
                await fadeOut(oldElement, 250, false);
                wrap.style.opacity = '0';
                if (oldElement.parentNode !== null)
                    oldElement.parentNode.replaceChild(wrap, oldElement);
                await fadeIn(wrap);
            } else {
                if (oldElement.parentNode !== null)
                    oldElement.parentNode.replaceChild(wrap, oldElement);
            }
            if (Array.isArray(vs.contacts) && vs.contacts.indexOf(member.id) >= 0) {
                wrap.classList.add('is-contact');
            }
        }

        function isMember() {
            if (!vs.hasOwnProperty('members')) return false;
            for (let i = 0; i < vs.members.male.length; i++) {
                if (vs.members.male[i] !== false && vs.members.male[i].id === window.userId) return true;
            }
            for (let i = 0; i < vs.members.female.length; i++) {
                if (vs.members.female[i] !== false && vs.members.female[i].id === window.userId) return true;
            }
            return false;
        }

        function updateDetails() {
            if (vs === null) return;

            // Create header
            let info = createSessionInfo(vs);
            header.innerHTML = '';
            header.appendChild(info);

            countdown.setTargetTime(vs.startedAt);

            let msg = 'Waiting for start';
            if (vs.status === 1) {
                msg = 'Talking with member';
            } else if (vs.status === 2) {
                msg = 'Waiting for next conversation';
            } else if (vs.status === 3) {
                msg = 'Video session is completed';
            }
            timerStatus.textContent = msg;

            // Show members skeletons
            if (teamMale.childNodes.length !== vs.teamSize
                || teamMale.firstChild.classList.contains('vs__team__member-skeleton')) {
                fillSkeletons(teamMale);
                fillSkeletons(teamFemale);
            }

            // Replace skeletons with real members
            if (vs.hasOwnProperty('members')) {
                updateMembers(teamMale, vs.members.male);
                updateMembers(teamFemale, vs.members.female);

                if (vs.status === 0 && window.userId !== null) {
                    (async () => {
                        if (isMember()) {
                            await fadeOut(joinButton, 100);
                            await fadeIn(leaveButton, 1000);
                        } else {
                            await fadeOut(leaveButton, 100);
                            await fadeIn(joinButton, 1000);
                        }
                    })();
                } else {
                    joinButton.style.display = 'none';
                    joinButton.style.opacity = '0';
                    leaveButton.style.display = 'none';
                    leaveButton.style.opacity = '0';
                }
            }
        }
    })();
</script>
