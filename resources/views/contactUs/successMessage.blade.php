@extends('layouts.main')

@section('content')
    <style>
        .evs-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 30rem;
            max-width: 100%;
            margin: 5rem auto;
        }
        .evs-title {
            font-weight: 400;
            font-size: 1.75rem;
            color: #333;
            text-align: center;
            margin-bottom: 2rem;
        }
        .evs-hint {
            text-align: center;
            color: #555;
            margin-bottom: 2rem;
        }
    </style>

    <div class="width-limiter">
        <div class="evs-wrap">
            <h2 class="evs-title">Thanks for you message!</h2>
            <div class="evs-hint">
                We will read your message and contact with you if necessary. Now you can back to main page.
            </div>
            <a href="{{ route('home', [], false) }}" class="btn btn-pink">Back to main page</a>
        </div>
    </div>
@endsection
