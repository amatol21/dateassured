<div id="video-sessions-list">
    <div id="vs-back-button" style="display: none; opacity: 0;">{{ __('videoSessions.backToCountries') }}</div>

    <div id="vs-list-skeleton" style="display: none; opacity: 0;">
        <div class="vs-list-skeleton-item"></div>
        <div class="vs-list-skeleton-item"></div>
        <div class="vs-list-skeleton-item"></div>
        <div class="vs-list-skeleton-item"></div>
    </div>

    <div id="vs-countries-skeleton">
        <div class="vs-countries-skeleton-item"></div>
        <div class="vs-countries-skeleton-item"></div>
        <div class="vs-countries-skeleton-item"></div>
        <div class="vs-countries-skeleton-item"></div>
        <div class="vs-countries-skeleton-item"></div>
        <div class="vs-countries-skeleton-item"></div>
    </div>

    <div id="vs-list" style="display: none; opacity: 0;"></div>

    <div id="vs-countries" style="display: none; opacity: 0;"></div>

    <div id="no-vs-msg" style="display: none; opacity: 0">
        <div class="no-vs-msg__title">
            There is no sessions available at the moment
        </div>
        <div class="no-vs-msg__description">
            Please wait a little to meet new people around you!
            The new sessions will be displayed here automatically.
        </div>
    </div>
</div>


<script>document.dispatchEvent(new CustomEvent('vs-list-init'));</script>
