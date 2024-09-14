<script>
    (() => {

        async function showActiveVideoSessionIcon() {
            let icon = document.getElementById('active-vs-icon');
            if (icon.style.opacity === '1') return;
            icon.style.opacity = '0';
            icon.style.display = null;
            await animate(k => icon.style.width = (3.5 * k) + 'rem', 250);
            await delay(250);
            await fadeIn(icon, 250);
        }

        async function hideActiveVideoSessionIcon() {
            let icon = document.getElementById('active-vs-icon');
            if (icon.style.display === 'none') return;
            await animate(k => icon.style.opacity = (1 - k).toString(), 250);
            await delay(250);
            await animate(k => icon.style.width = (3.5 - (3.5 * k)) + 'rem', 250);
            icon.style.display = 'null';
        }

        try {
            let userId = {{ auth()->check() ? auth()->id() : 'null' }};
            let app = new VideoSessionsManager();

            // Provide some API for global access.
            window.restartVideoSessionsServer = () => app.restartServer();

            @auth
            app.setUserId(userId);
            app.onAuthRequired(async callback => {
                let res = await fetch('{{ route('videoSessions.auth', [], false) }}');
                if (res.ok) {
                    let authMsg = await res.json();
                    callback(authMsg);
                }
            });
            @endauth

            let lastSeenVideoSessionId = null;
            let activeVideoSession = null;

            app.configureRTCPeer({
                iceServers: [
                    { urls: 'stun:stun.l.google.com:19302' }
                ]
            });

            app.onActiveVideoSession(videoSessionInfo => {
                activeVideoSession = videoSessionInfo;
                setTimeout(showActiveVideoSessionIcon, 500);
            });



            app.onCountriesListUpdate(data => {
                document.dispatchEvent(new CustomEvent('countries-list-update', {
                    detail: data
                }));
            });

            app.onVideoSessionsListUpdate(data => {
                document.dispatchEvent(new CustomEvent('video-sessions-list-update', {
                    detail: data
                }));
            });

            app.onVideoSessionDetails(data => {
                document.dispatchEvent(new CustomEvent('video-session-update', {
                    detail: data
                }));
            });

            app.onConnect(() => {
                app.requestCountriesListUpdate();
            });

            app.onAuthorized(isAdmin => {
                window.userId = userId;
                if (lastSeenVideoSessionId !== null) {
                    app.requestVideoSessionDetails(lastSeenVideoSessionId);
                }
                document.dispatchEvent(new CustomEvent('authorized', {detail: isAdmin}));
                // if (isAdmin) app.requestCountriesListUpdate();
            });

            app.onHighlightMembers(data => {
                document.dispatchEvent(new CustomEvent('highlight-members', {
                    detail: data
                }));
            });

            app.onErrorMessage(message => {
                document.dispatchEvent(new CustomEvent('error-message', {
                    detail: message
                }));
            });

            app.onStartTalk(isInitiator => {
                document.dispatchEvent(new CustomEvent('start-talk', {
                    detail: isInitiator
                }));
            });

            app.onEndTalk(() => {
                document.dispatchEvent(new CustomEvent('end-talk'));
                activeVideoSession = null;
                setTimeout(hideActiveVideoSessionIcon, 6000);
            });

            app.onTalkResult(result => {
                console.log(result);
                document.dispatchEvent(new CustomEvent('talk-result', {detail: result}));
            });

            app.onLocalVideoStreamReady(stream => {
                document.dispatchEvent(new CustomEvent('local-video-stream-ready', {
                    detail: stream
                }));
            });

            app.onRemoteVideoStreamReady(stream => {
                document.dispatchEvent(new CustomEvent('remote-video-stream-ready', {detail: stream}));
            });

            app.onNotificationsUpdate(notifications => {
                document.dispatchEvent(new CustomEvent('notifications-update', {detail: notifications}));
            });

            app.onNewNotification(notification => {
                document.dispatchEvent(new CustomEvent('new-notification', {detail: notification}));
            });

            app.onConversationsListUpdate(conversations => {
                document.dispatchEvent(new CustomEvent('conversations-update', {detail: conversations}));
            });

            app.onIncomingMessage(data => {
                document.dispatchEvent(new CustomEvent('incoming-message', {detail: {message: data.message, conversationId: data.conversationId}}));
            });

            app.onMessagesUpdate(data => {
                document.dispatchEvent(new CustomEvent('messages-list-update', {detail: data}));
            });

            app.onConversationUpdate(conversation => {
                document.dispatchEvent(new CustomEvent('conversation-update', {detail: conversation}));
            });

            app.onComplaintMessage(data => {
                document.dispatchEvent(new CustomEvent('complaint-message', {detail: data}));
            });

            document.addEventListener('rate-talk', e => app.rateLastTalk(e.detail));
            document.addEventListener('vs-mute', () => app.muteMicrophone());
            document.addEventListener('vs-unmute', () => app.unmuteMicrophone());
            document.addEventListener('video-session-created', e => app.createVideoSession(e.detail));
            document.addEventListener('delete-video-session', e => app.deleteVideoSession(e.detail));
            document.addEventListener('request-countries-list', () => app.requestCountriesListUpdate());
            document.addEventListener('request-video-sessions-list', e => app.requestVideoSessionsListUpdate(e.detail));
            document.addEventListener('join-video-session', e => app.joinVideoSession(e.detail));
            document.addEventListener('leave-video-session', e => {
                hideActiveVideoSessionIcon();
                app.leaveVideoSession(e.detail);
            });
            document.addEventListener('leave-talk', e => {
                hideActiveVideoSessionIcon();
                app.leaveTalk(e.detail);
            });
            document.addEventListener('request-talk-result', () => app.requestTalkResult());
            document.addEventListener('see-notification', e => app.seeNotification(e.detail));
            document.addEventListener('update-user', () => app.requestUserUpdate());
            document.addEventListener('show-active-video-session', () => {
                if (activeVideoSession === null) return;
                document.dispatchEvent(new CustomEvent('show-video-session-details', {
                    detail: activeVideoSession
                }));
            });

            document.addEventListener('request-video-session-details', e => {
                lastSeenVideoSessionId = e.detail.id;
                app.requestVideoSessionDetails(e.detail.id);
            });

            document.addEventListener('show-video-session-details', e => {
                lastSeenVideoSessionId = e.detail.id;
                app.requestVideoSessionDetails(e.detail.id);
            });

            document.addEventListener('send-notification', e => {
                app.sendNotification(e.detail.id, e.detail.message);
            });

            document.addEventListener('send-notification-to-all', e => {
                app.sendNotificationToAll(e.detail.users, e.detail.message);
            });

            document.addEventListener('send-complaint-message', e => {
                app.sendComplaintMessage(e.detail.complaintId, e.detail.message);
            });

            document.addEventListener('request-conversations-update', () => app.requestConversationsList());
            document.addEventListener('send-message', e => app.sendMessage(e.detail.text, e.detail.conversationId));
            document.addEventListener('request-messages-list', e => app.requestMessagesList(e.detail.conversationId, e.detail.fromId));
            document.addEventListener('see-message', e => app.seeMessage(e.detail.conversationId, e.detail.messageId));

            app.connectToSignalingServer('{{ config('app.ws_server_address') }}');
        } catch (e) {
            console.warn(e);
        }
    })();
</script>
