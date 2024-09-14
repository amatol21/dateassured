<script>
    (() => {
        const MODE_COUNTRIES = 0;
        const MODE_SESSIONS = 1;

        let isAuthorized = false;
        let isAdmin = false;

        let backButton = document.getElementById('vs-back-button');
        let sessionsSkeleton = document.getElementById('vs-list-skeleton');
        let sessionsList = document.getElementById('vs-list');
        let countriesSkeleton = document.getElementById('vs-countries-skeleton');
        let countriesList = document.getElementById('vs-countries');
        let noVideoSessionsMessage = document.getElementById('no-vs-msg');
        let mode = MODE_COUNTRIES;
        let country = null;


        document.addEventListener('vs-list-init', () => {
            backButton = document.getElementById('vs-back-button');
            sessionsSkeleton = document.getElementById('vs-list-skeleton');
            sessionsList = document.getElementById('vs-list');
            countriesSkeleton = document.getElementById('vs-countries-skeleton');
            countriesList = document.getElementById('vs-countries');
            noVideoSessionsMessage = document.getElementById('no-vs-msg');
            mode = MODE_COUNTRIES;
            country = null;

            if (backButton !== null) {
                backButton.addEventListener('click', async () => {
                    fadeOut(backButton);
                    await fadeOut(sessionsSkeleton);
                    await fadeOut(sessionsList);
                    fadeIn(countriesList);
                    country = null;
                    mode = MODE_COUNTRIES;
                    document.dispatchEvent(new CustomEvent('request-countries-list'));
                });
            }
        });

        function deleteSessionInfoHandler(e) {
            e.stopPropagation();
            if (confirm("Are you really want to delete this video session?")) {
                let id = parseInt(this.parentNode.dataset.id);
                document.dispatchEvent(new CustomEvent('delete-video-session', {detail: id}));
            }
        }

        document.addEventListener('authorized', e => {
            isAuthorized = true;
            isAdmin = e.detail
        })

        function itemClickHandler() {
            if (!isAuthorized) {
                document.dispatchEvent(new CustomEvent('show-login-modal'));
                return;
            }
            document.dispatchEvent(new CustomEvent('show-video-session-details', {
                detail: this.parentNode.__vs
            }));
        }

        // Update video sessions list.
        document.addEventListener('video-sessions-list-update', async e => {
            if (sessionsList === null) return;
            sessionsList.innerHTML = '';
            if (e.detail.length === 0) {
                await fadeOut(sessionsSkeleton);
                await fadeIn(noVideoSessionsMessage);
                return;
            } else {
                await fadeOut(noVideoSessionsMessage)
            }
            for (let i = 0; i < e.detail.length; i++) {
                let vs = e.detail[i];
                if (vs.country !== country) continue;

                let item = document.createElement('div');
                item.className = 'vs-list-item';
                item.dataset.id = vs.id;
                item.__vs = vs;

                let info = createSessionInfo(vs, isAdmin, deleteSessionInfoHandler);
                info.addEventListener('click', itemClickHandler);
                item.appendChild(info);

                sessionsList.appendChild(item);
            }

            if (mode === MODE_SESSIONS) {
                await fadeOut(sessionsSkeleton);
                await fadeIn(sessionsList);
            }
        });

        let countryClickHandler = async function() {
            await fadeOut(noVideoSessionsMessage);
            await fadeOut(countriesList);
            sessionsList.innerHTML = '';
            fadeIn(backButton);
            fadeIn(sessionsList);
            mode = MODE_SESSIONS;
            country = this.dataset.code;
            document.dispatchEvent(new CustomEvent('request-video-sessions-list', {detail: country}));
        }

        document.addEventListener('countries-list-update', async e => {
            if (countriesList === null) return;
            countriesList.innerHTML = '';
            for (let i = 0; i < e.detail.length; i++) {
                let country = e.detail[i];

                let wrap = document.createElement('div');
                wrap.setAttribute('data-code', country.code);
                wrap.className = 'vs-country';
                wrap.addEventListener('click', countryClickHandler);
                wrap.innerHTML = `
                <div class="vs-country-flag-wrap">
                    <svg viewBox="0 0 13 13" width="32" height="32" class="vs-country-flag">
                        <use href="/images/icons.svg#${country.code.toUpperCase()}"></use>
                    </svg>
                </div>
                <div class="vs-country-name">${country.name}</div>
                <div class="vs-country-count">
                    <div class="vs-country-number">${country.count}</div>
                    <div class="vs-country-label">events</div>
                </div>`;
                countriesList.appendChild(wrap);
            }

            if (mode === MODE_COUNTRIES) {
                await fadeOut(countriesSkeleton);
                if (e.detail.length > 0) {
                    await fadeOut(noVideoSessionsMessage);
                    await fadeIn(countriesList);
                } else {
                    await fadeIn(noVideoSessionsMessage);
                }
            }
        });
    })();
</script>
