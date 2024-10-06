<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">

		@fragment('meta')
		<title>@yield('title', env('APP_NAME'))</title>
		@endfragment

		<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, initial-scale=1">
		<meta name="description" content="@yield('description', 'Online dating service')">
		<link rel="preload" as="image" href="{{ asset('images/icons.svg') }}"/>
		<link rel="preload" as="style" href="{{ asset('css/index.css') }}"/> 
		<link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
		<link rel="icon" type="image/x-icon" href="{{ asset('images/logo.svg') }}">

		{{--<link rel="preload" as="image" href="/images/icons.svg"/>
		<link rel="preload" as="style" href="/css/index.css"/>
		<link rel="icon" type="image/x-icon" href="/images/logo.svg">--}}
		


{{--        <script src="https://accounts.google.com/gsi/client" defer></script>--}}
		<script src="/js/google-sdk.js" defer></script>
		<script defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
		<script src="/lib/ckeditor/ckeditor.js"></script>

		<script>
			window.localization = <?= json_encode([
						'enums' => include(lang_path(app()->getLocale().'/enums.php')),
						'notifications' => include(lang_path(app()->getLocale().'/notifications.php')),
					],
					JSON_PRETTY_PRINT | JSON_FORCE_OBJECT
			) ?>;
		</script>

		<script src="{{ asset('js/script.js')}}"></script>
		<!--<link rel="stylesheet" href="{{ asset('public/css/index.css') }}"/>
		<script src="{{ asset('public/js/script.js') }}"></script>--> 
	</head>
	<body>

		<script>
			// We need to reload page when user clicks back button.
			addEventListener("popstate", () => window.location.reload());
		</script>

		@include('common.ui.toast')
		@include('videoSessions.connection')
		@include('videoSessions.list-script')
		@include('chat.script')
		@include('videoSessions/sessionModal')
		@include('common.header')
		<div id="content">
			@fragment('content')
			@yield('content')
			@endfragment
		</div>

		@include('common.footer')

		@guest
		<!-- Facebook SDK init -->
		<script>
			window.fbAsyncInit = function() {
					FB.init({
						appId            : '{{ config('auth.fb_app_id') }}',
						autoLogAppEvents : true,
						xfbml            : false,
						version          : 'v17.0'
					});
					document.dispatchEvent(new CustomEvent('fb-ready'));
			};
		</script>

		<!-- Google SDK init -->
		<script>
			async function handleCredentialResponse(response) {
					try {
						let res = await fetch('{{ route('loginByGoogle', [], false) }}', {
							method: 'POST',
							body: JSON.stringify({
									token: response.credential,
									_token: '{{ csrf_token() }}'
							}),
							headers: {
									'content-type': 'application/json',
									'X-Requested-With': 'XMLHttpRequest'
							}
						});
						if (res.ok && res.redirected) {
							window.location = res.url;
						}
					} catch (e) {
						console.error(e);
					}
			}

			addEventListener('load', () => {
					google.accounts.id.initialize({
						client_id: "{{ config('auth.google_client_id') }}",
						callback: handleCredentialResponse
					});
					document.dispatchEvent(new CustomEvent('google-ready'));
					google.accounts.id.prompt();
			});
		</script>
		@endguest
	</body>
</html>
