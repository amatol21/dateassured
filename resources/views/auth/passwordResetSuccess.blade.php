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
        <div class="width-limiter">
            <div class="evs-wrap">
                <h2 class="evs-title">Your password was successfully changed</h2>
                <div class="evs-hint">
                    Now you can sign in with new password.<br/>
                    Click button below to back to home page.
                </div>
                <a href="{{ route('home', [], false) }}" class="btn btn-pink">Back to main page</a>
            </div>
        </div>
    </div>
@endsection
