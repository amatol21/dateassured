@extends('account.index')

@section('title')
    Video sessions | DateAssured
@endsection

@section('accountContent')

    <h2 class="account_title">Video sessions</h2>
    <div class="account_video-sessions">
        @include('videoSessions.list-html')
        <script>document.dispatchEvent(new CustomEvent('request-countries-list'));</script>
    </div>
@endsection
