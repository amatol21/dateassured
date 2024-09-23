@php

use App\Enums\Permission;

@endphp

@extends('layouts.main')

@section('content')

	<div id="admin-wrap">
		<div class="width-limiter">
			<div id="admin">
				<div class="admin_menu pad">
					<a href="{{ route('admin', [], false) }}"
						class="btn admin_menu_link @if(request()->route()->named('admin', 'admin.home')) active @endif">
						Dashboard
					</a>

					@if(Permission::MANAGE_VIDEO_SESSIONS->allowed())
					<a href="{{ route('admin.videoSessions', [], false) }}"
						class="btn admin_menu_link @if(request()->route()->named('admin.videoSessions')) active @endif">
						Video sessions
					</a>
					@endif

					@if(Permission::MANAGE_USERS->allowed())
					<a href="{{ route('admin.users', [], false) }}"
						class="btn admin_menu_link
						@if(request()->route()->named('admin.users', 'admin.users.create', 'admin.users.edit')) active @endif
					">Users</a>
					@endif

					@if(Permission::MANAGE_ROLES->allowed())
					<a href="{{ route('admin.roles', [], false) }}"
						class="btn admin_menu_link
						@if(request()->route()->named('admin.roles', 'admin.roles.create', 'admin.roles.edit')) active @endif
					">Roles</a>
					@endif

					@if(Permission::MANAGE_NEWS->allowed())
					<a href="{{ route('admin.news', [], false) }}"
						class="btn admin_menu_link
						@if(request()->route()->named('admin.news', 'admin.news.create', 'admin.news.edit')) active @endif
					">News</a>
					@endif

					@if(Permission::MANAGE_BLOG->allowed())
					<a href="{{ route('admin.blog', [], false) }}"
						class="btn admin_menu_link
						@if(request()->route()->named('admin.blog', 'admin.blog.create', 'admin.blog.edit')) active @endif
					">Blog</a>
					@endif

					@if(Permission::MANAGE_PAYMENTS->allowed())
					<a href="{{ route('admin.payments', [], false) }}"
						class="btn admin_menu_link
						@if(request()->route()->named('admin.payments')) active @endif">
						Payments
					</a>
					@endif

					@if(Permission::COMPLAINTS->allowed())
					<a href="{{ route('admin.complaints', [], false) }}"
						class="btn admin_menu_link
						@if(request()->route()->named('admin.complaints', 'admin.complaints.view')) active @endif">
						Complaints
					</a>
					@endif
				</div>

				<div class="admin_content">
					@yield('adminContent')
				</div>
			</div>
		</div>
	</div>
@endsection
