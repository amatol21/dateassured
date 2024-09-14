<script>
    (() => {
        let wrap = null,
            chat = null,
            skeleton = null,
            noConversationsMessage = null,
            contacts = null,
            messagesPanel = null,
            messages = null,
            inputField = null,
            sendForm = null,
            backButton = null,
            headerPhoto = null,
            headerName = null;

        let currentConversationId = null;
        let activeConversation = null;
        let lastMessage = null;
        let conversationsById = {}

        document.addEventListener('chat-init', () => {
            wrap = document.getElementById('chat-wrap');
            chat = document.getElementById('chat');
            skeleton = document.getElementById('chat-skeleton');
            noConversationsMessage = document.getElementById('chat_no-conversations');
            contacts = chat.querySelector('.chat-conversations-panel');
            messagesPanel = chat.querySelector('.chat_messages-panel');
            messages = chat.querySelector('.chat_messages-list');
            inputField = chat.querySelector('.chat_msg-input');
            sendForm = chat.querySelector('.chat_send-form');
            backButton = chat.querySelector('.chat_messages_back-button');
            headerPhoto = chat.querySelector('.chat_messages_header_avatar');
            headerName = chat.querySelector('.chat_messages_header_name');

            backButton.addEventListener('click', () => {
                messagesPanel.classList.remove('shown');
                activeConversation = null;
            })

            sendForm.addEventListener('submit', e => {
                e.preventDefault();
                if (inputField.value.trim() === '') return;
                sendMessage();
            })

            inputField.addEventListener('keydown', e => {
                if (!e.shiftKey && !e.ctrlKey && e.key === 'Enter' && inputField.value.trim() !== '') {
                    sendMessage();
                    e.preventDefault();
                }
            })

            inputField.addEventListener('input', e => {
                inputField.style.height = 0;
                inputField.style.height = inputField.scrollHeight + 'px';
                inputField.style.overflowY = inputField.scrollHeight > 180 ? 'auto' : 'hidden';
            });

            document.dispatchEvent(new CustomEvent('request-conversations-update'));
        });


        document.addEventListener('messages-list-update', async e =>
        {
            if (activeConversation === null) return;

            let firstMessage = getNewestMessage();

            if (activeConversation.id !== e.detail.conversationId
                || firstMessage === null
                || (e.detail.messages.length > 0 && e.detail.messages[0].id >= firstMessage._data.id))
            {
                messages.innerHTML = '';
            }

            let lastMessage = getOldestMessage();
            for (let i = 0; i < e.detail.messages.length; i++) {
                let data = e.detail.messages[i];
                let msg = createMessage(data);
                if (lastMessage !== null && lastMessage.classList.contains('chat_msg')) {
                    if (lastMessage._data.sender.id === data.sender.id && lastMessage._data.time - data.time < 10000) {
                        msg.classList.add('has-followed-msg');
                    }
                }

                if (msg.classList.contains('outgoing')) {
                    let member = getConversationInterlocutor();
                    msg.classList.add(data.id > member.lastSeenMessageId ? 'unseen' : 'seen');
                    msg.classList.add(data.id > member.lastDeliveredMessageId ? 'undelivered' : 'delivered');
                }

                if (lastMessage !== null) {
                    let ld = new Date(lastMessage._data.time);
                    let nd = new Date(data.time);

                    if (ld.getDate() !== nd.getDate()
                        || ld.getMonth() !== nd.getMonth()
                        || ld.getFullYear() !== nd.getFullYear()
                        || i >= e.detail.messages.length
                    ) {
                        let dateLabel = makeElement('div', 'chat_date-label');
                        dateLabel.textContent = ld.getDate().toString().padStart(2, '0') + '.'
                            + (ld.getMonth() + 1).toString().padStart(2, '0') + '.'
                            + ld.getFullYear().toString();
                        messages.insertBefore(dateLabel, messages.firstChild);
                    }
                }

                messages.childNodes.length === 0
                    ? messages.appendChild(msg)
                    : messages.insertBefore(msg, messages.firstChild);

                lastMessage = msg;
            }
            messages.scrollTop = messages.scrollHeight;
            document.dispatchEvent(new CustomEvent('see-message', {detail: {
                conversationId: e.detail.conversationId,
                messageId:  getNewestMessage()._data.id
            }}));
        });

        function getNewestMessage() {
            let items = messages.getElementsByClassName('chat_msg');
            return items.length > 0 ? items[items.length - 1] : null;
        }

        function getOldestMessage() {
            let items = messages.getElementsByClassName('chat_msg');
            return items.length > 0 ? items[0] : null;
        }

        function getConversationInterlocutor(conversation)
        {
            if (conversation === undefined) conversation = activeConversation;
            if (conversation === null) return;
            for (let i = 0; i < conversation.members.length; i++) {
                if (conversation.members[i].id !== window.userId) {
                    return conversation.members[i];
                }
            }
            return conversation.members[0];
        }

        function sendMessage() {
            if (activeConversation === null) return;
            document.dispatchEvent(new CustomEvent('send-message', {
                detail: {
                    conversationId: activeConversation.id,
                    text: inputField.value.trim()
                }
            }));
            inputField.value = '';
            inputField.innerHTML = '';
            inputField.style.height = null;
            sendForm.reset();
            inputField.value = '';
        }

        function contactClickHandler() {
            lastMessage = null;
            let active = this.parentNode.querySelector('.chat_conv.active');
            if (active !== null) active.classList.remove('active');
            this.classList.add('active');
            if (activeConversation === null || activeConversation.id !== this._data.id) {
                messages.innerHTML = '';
            }
            currentConversationId = this._data.id;
            activeConversation = this._data;
            let user = getConversationInterlocutor(this._data);
            headerPhoto.src = user.photoUrl;
            headerName.textContent = user.username;
            document.dispatchEvent(new CustomEvent('request-messages-list', {
                detail: {
                    conversationId: this._data.id,
                    from: 0
                }
            }));
            messagesPanel.classList.add('shown');
        }

        function getPhotoUrlForMember(member) {
            return member.photoUrl === undefined || member.photoUrl === ''
                ? (member.gender === 0 ? '/images/avatar-male.jpg' : '/images/avatar-female.jpg')
                : member.photoUrl;
        }

        function createMessage(data) {
            let wrap = makeElement('div', 'chat_msg ' + (data.sender.id === userId ? 'outgoing' : 'incoming'));
            wrap.dataset.id = data.id;

            let photo = makeElement('img', 'chat_msg_photo');
            photo.src = getPhotoUrlForMember(data.sender);
            wrap.appendChild(photo);

            let text = makeElement('div', 'chat_msg_text');
            text.textContent = data.text;
            wrap.appendChild(text);

            let time = makeElement('div', 'chat_msg_time');
            let d = new Date(data.time);
            time.textContent = d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
            text.appendChild(time);
            wrap._data = data;

            return wrap;
        }

        document.addEventListener('conversation-update', async e =>
        {
            if (activeConversation === null || activeConversation.id !== e.detail.id) return;
            let items = messages.getElementsByClassName('chat_msg');
            let member = getConversationInterlocutor(e.detail);
            if (member === null) return;
            for (let i = 0; i < items.length; i++) {
                if (items[i]._data.id <= member.lastSeenMessageId) {
                    items[i].classList.remove('unseen');
                    items[i].classList.add('seen');
                }
                if (items[i]._data.id <= member.lastDeliveredMessageId) {
                    items[i].classList.remove('undelivered');
                    items[i].classList.add('delivered');
                }
            }
        });

        document.addEventListener('incoming-message', async e =>
        {
            let convWrap = conversationsById[e.detail.conversationId];
            let msgData = e.detail.message;
            if (convWrap !== undefined) {
                if (msgData.sender.id === window.userId) {
                    convWrap._lastMsg.textContent = 'You: ' + msgData.text;
                    convWrap._lastMsg.classList.add('from-me');
                } else {
                    convWrap._lastMsg.textContent = msgData.text;
                    convWrap._lastMsg.classList.remove('from-me');
                }
            }

            if (activeConversation === null || e.detail.conversationId !== activeConversation.id) return;

            let msg = createMessage(msgData);
            let lastMessage = getNewestMessage()
            if (lastMessage !== null) {
                if (lastMessage._data.sender.id === msgData.sender.id && msgData.time - lastMessage._data.time < 10000) {
                    lastMessage.classList.add('has-followed-msg');
                }
            }

            messages.appendChild(msg);
            messages.scrollTop = messages.scrollHeight;

            if (msgData.sender.id !== window.userId) {
                document.dispatchEvent(new CustomEvent('see-message', {
                    detail: {
                        conversationId: e.detail.conversationId,
                        messageId: msg._data.id
                    }
                }));
            }
        });


        document.addEventListener('conversations-update', async e =>
        {
            if (noConversationsMessage === null) return;
            await fadeOut(noConversationsMessage);
            await fadeOut(skeleton);

            if (e.detail.length === 0) {
                await fadeIn(noConversationsMessage);
                return;
            }

            contacts.innerHTML = '';
            conversationsById = {};
            let firstConvWrap = null;
            for (let i = 0; i < e.detail.length; i++) {
                let conv = e.detail[i];

                // Detect interlocutor
                let user = getConversationInterlocutor(conv);

                let convWrap = makeElement('div', 'chat_conv');
                convWrap._id = conv.id;
                convWrap._data = conv;
                convWrap.addEventListener('click', contactClickHandler);
                conversationsById[conv.id] = convWrap;
                if (i === 0) firstConvWrap = convWrap;

                let photo = makeElement('img', 'chat_conv_photo');
                photo.src = getPhotoUrlForMember(user);
                convWrap.appendChild(photo);

                let texts = makeElement('div', 'chat_conv_texts');
                let name = makeElement('div', 'chat_conv_name');
                name.textContent = user.username;
                texts.appendChild(name);
                let lastMsg = makeElement('div', 'chat_conv_last-msg');
                convWrap._lastMsg = lastMsg;
                if (conv.lastMessage !== undefined && conv.lastMessage !== null) {
                    if (conv.lastMessage.sender.id === window.userId) {
                        lastMsg.textContent = 'You: ' + conv.lastMessage.text;
                        lastMsg.classList.add('from-me');
                    } else {
                        lastMsg.textContent = conv.lastMessage.text;
                        lastMsg.classList.remove('from-me');
                    }
                } else {
                    lastMsg.textContent = "(No messages)"
                }
                texts.appendChild(lastMsg);
                convWrap.appendChild(texts);

                contacts.appendChild(convWrap);
            }

            await fadeIn(chat);

            if (window.innerWidth > 700 && activeConversation === null && firstConvWrap !== null) {
                firstConvWrap.click();
            }
        });

        document.addEventListener('authorized', () => {
            document.dispatchEvent(new CustomEvent('request-conversations-update'));
        });

    })();
</script>
