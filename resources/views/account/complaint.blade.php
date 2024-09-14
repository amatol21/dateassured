@php

    use App\Models\Complaint;

    /** @var Complaint $complaint */
@endphp

@extends('account.index')

@section('title')
    Complaint: {{ $complaint->subject}} | DateAssured
@endsection

@section('accountContent')

    @include('account.changePasswordModal')
    @include('account.verifyEmailModal')

    <h2 class="account_title">Complaint</h2>

    <div class="p-2">
        @include('common.complaint', ['complaint' => $complaint])
    </div>
@endsection
