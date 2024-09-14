<?php

use App\Enums\Size;
use App\Models\Complaint;

/**
 * @var $complaint Complaint
 */
?>

@extends('admin.index')

@section('adminContent')
    <style>
        .complaint_author {
            display: flex;
            align-items: center;
            padding-bottom: 2rem;
            border-bottom: 2px solid #ccc;
            margin-bottom: 1rem;
        }
        .complaint_author-photo {
            width: 4rem;
            height: 4rem;
            border-radius: 2rem;
            margin-right: 1rem;
        }
        .complaint_author-name {
            font-weight: 500;
        }
        .complaint_author-date {
            font-size: 0.75rem;
            color: #999;
            margin-top: 0.25rem;
        }

    </style>

    <div class="pad p-2">
        <div class="complaint_author">
            <img src="{{ $complaint->creator->getImageUrl(Size::MEDIUM) }}"
                 alt="{{ $complaint->creator->getFullName() }}" class="complaint_author-photo">
            <div class="complaint_author-texts">
                <div class="complaint_author-name">{{ $complaint->creator->getFullName() }}</div>
                <div class="complaint_author-date">{{ $complaint->created_at }}</div>
            </div>
        </div>
        @include('common.complaint', ['complaint' => $complaint])
    </div>

@endsection
