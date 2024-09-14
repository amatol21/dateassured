<?php
    use App\Helpers\Svg;
?>

<div id="ntf">
    <div class="ntf_icon" title="Notifications">
        <?= Svg::icon('bell', 26, 28) ?>
    </div>

    <div class="ntf_dropdown">
        <div class="ntf_no-items-msg">
            {{ __('notifications.noMessages') }}
        </div>
        <div class="ntf_dropdown_items-wrap" style="display: none">
            <div class="ntf_dropdown_items"></div>
        </div>
    </div>
</div>

<script>
    (() => {
        let wrap = document.getElementById('ntf');
        let icon = wrap.querySelector('.ntf_icon');
        let dropdown = wrap.querySelector('.ntf_dropdown');
        let items = dropdown.querySelector('.ntf_dropdown_items');
        let noItemsMessage = dropdown.querySelector('.ntf_no-items-msg');
        let itemsWrap = dropdown.querySelector('.ntf_dropdown_items-wrap');
        let unseen = 0;

        wrap.addEventListener('click', e => e.stopPropagation());
        document.addEventListener('click', () => dropdown.classList.remove('shown'));

        icon.addEventListener('click', () => {
            dropdown.classList.toggle('shown');
        });

        function notificationClickHandler() {
            if (!this._data.isSeen) {
                unseen--;
                this._data.isSeen = true;
                this.classList.remove('ntf_item-unseen');
                document.dispatchEvent(new CustomEvent('see-notification', {detail: this._data.id}));
                if (unseen <= 0) {
                    unseen = 0;
                    icon.classList.remove('ntf_has-unseen');
                }
            }

            switch (this._data.type)
            {
                case 3:
                    document.dispatchEvent(new CustomEvent('request-video-session-details', {detail: {id: this._data.payload.id}}));
                    break;
                case 5:
                    window.location = '/account/complaint/' + this._data.payload.complaintId;
            }
            dropdown.classList.toggle('shown');
        }

        function createNotification(data) {
            let wrap = document.createElement('div');
            wrap._data = data;
            wrap.addEventListener('click', notificationClickHandler);
            wrap.className = 'ntf_item';
            if (!data.isSeen) wrap.classList.add('ntf_item-unseen');
            let text = document.createElement('div');
            text.className = 'ntf_item_text';

            let msg = localization.notifications.messages[data.type];
            if (data.type === 4) {
                msg = data.payload.message;
            }
            if (data.type === 5) {
                msg = 'You received message in one of your complaint. Click to see details.';
            }

            for (let p in data.payload) {
                if (p === 'startedAt') {
                    msg = msg.replace('{date}', formatTime(data.payload[p]));
                } else if (p === 'country') {
                    msg = msg.replace('{country}', localization.enums.country[data.payload[p]]);
                }
            }
            text.textContent = msg;
            wrap.appendChild(text);
            return wrap;
        }


        document.addEventListener('notifications-update', e => {
            items.innerHTML = '';
            unseen = 0;
            for (let i = 0; i < e.detail.length; i++) {
                if (!e.detail[i]['isSeen']) unseen++;
                items.appendChild(createNotification(e.detail[i]));
            }
            if (e.detail.length > 0) {
                noItemsMessage.style.display = 'none';
                itemsWrap.style.display = null;
            } else {
                noItemsMessage.style.display = null;
                itemsWrap.style.display = 'null';
            }

            if (unseen > 0) {
                icon.classList.add('ntf_has-unseen');
            } else {
                icon.classList.remove('ntf_has-unseen');
            }
        });

        document.addEventListener('new-notification', e => {
            if (items.childNodes.length === 0) {
                items.appendChild(createNotification(e.detail));
            } else {
                items.insertBefore(createNotification(e.detail), items.childNodes[0]);
            }
            unseen++;
            noItemsMessage.style.display = 'none';
            itemsWrap.style.display = null;
            icon.classList.add('ntf_has-unseen');
        });
    })();
</script>
