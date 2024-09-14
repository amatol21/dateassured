<div class="s2">
    <div class="width-limiter">
        <div class="s2_location-and-ip">
            <div class="s2_location">
                <svg class="s2_location_icon" viewBox="0 0 12 14" width="12" height="14">
                    <use href="/images/icons.svg#location"></use>
                </svg>
                Your location: {{ \App\Models\Country::getCurrent()->name }}
            </div>
            <div class="s2_ip">
                <svg class="s2_location_icon" viewBox="0 0 12 14" width="12" height="14">
                    <use href="/images/icons.svg#ip"></use>
                </svg>
                Your IP: {{ request()->ip() }}
            </div>
        </div>

        <div class="mt-2">
            @include('videoSessions.list-html')
        </div>
    </div>
</div>
