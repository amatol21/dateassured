@php
    use App\Enums\Size;
    use App\Enums\Gender;
    use App\Helpers\Svg;
    use App\Models\Country;
@endphp

@extends('layouts.main')

@section('content')
	@include('common.systemMessage')

	<div id="account">
		<div class="width-limiter">
			<div class="account_wrap">
				<div class="account_left">
					<div class="account_info account_pad">
						<div class="account_photo_wrap">
							<img src="{{ auth()->user()->getPhotoUrl(Size::LARGE) }}"
								onerror="this.src = '/images/avatar-{{ auth()->user()->gender === Gender::MALE ? 'male' : 'female' }}.jpg'"
								alt="{{ auth()->user()->username }}"/>
						</div>
						<div class="account_name">
							{{ auth()->user()->username }}
						</div>
						<div class="account_location">
							<?= Svg::icon('location', 16, 16) ?> Location: {{ Country::getCurrent()->name }}
						</div>

						<nav class="account_nav">
							<a href="{{ route('account.videoSessions', [], false) }}"
								class="account_nav_item @if(request()->route()->named('account', 'account.videoSessions')) active @endif">
								<?= Svg::icon('message', 20, 20) ?>
								{{ __('menu.account.videoSessions') }}
							</a>
							<a href="{{ route('account.profile', [], false) }}"
								class="account_nav_item @if(request()->route()->named('account.profile', 'account.saveProfile')) active @endif">
								<?= Svg::icon('profile', 20, 20) ?>
								{{ __('menu.account.profile') }}
							</a>
							<a href="{{ route('account.matches', [], false) }}"
								class="account_nav_item @if(request()->route()->named('account.matches')) active @endif">
								<?= Svg::icon('heart', 20, 21) ?>
								{{ __('menu.account.matches') }}
							</a>
							<a href="{{ route('account.wallet', [], false) }}" class="account_nav_item @if(request()->route()->named('account.wallet')) active @endif">
								<?= Svg::icon('wallet', 20, 20) ?>
								{{ __('menu.account.wallet') }}
							</a>
							<a href="{{ route('account.search', [], false) }}"
								class="account_nav_item @if(request()->route()->named('account.search')) active @endif">
								<?= Svg::icon('message', 20, 20) ?>
								{{ __('menu.account.search') }}
							</a>
						</nav>
						<script>makeSmartLinks('.account_nav_item', '#account-content', true);</script>
					</div>
				</div>

				<div class="account_right">
					<div id="account-content" class="account_pad">
						@fragment('accountContent')
						@yield('accountContent')
						@endfragment
					</div>

				</div>
			</div>


		</div>
	</div>
@endsection
