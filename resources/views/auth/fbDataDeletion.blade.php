@extends('layouts.main')

@section('content')
    <div class="width-limiter">
        @auth
            Your personal data was successfully deleted.
        @elseauth
            To delete your personal data please <a href="{{ route('login', [], false) }}">login</a>.
        @endauth
    </div>
@endsection
