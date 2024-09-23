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

		<div class="mt-2 s2_advertisement">
			{{--@include('videoSessions.list-html')--}}

			<img src="/images/main_page/earth.png" class="s2_planet" alt="background">
			<img src="/images/main_page/phones.png" class="s2_phones" alt="phones">

			<a href class="s2_brand">
				<img src="/images/logo.jpg" class="s2_brand-image" alt="DateAssured site logo" srcset="/images/logo.svg"> 

				<span class="s2_brand-text">
						Date<br>Assured
				</span>
			</a>
			<h2 class="s2_header">
				The First <br>
				International <br>
				Speed Dating <br>
				Agency
			</h2>

		</div>
	</div>
</div>
