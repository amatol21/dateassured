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
            <h2 class="evs-title">Your email successfully verified!</h2>
            <div class="evs-hint">
                Congratulations! You're successfully verified your email address.
                Now you can use all the functionality of our service.
            </div>
            <a href="{{ route('login', [], false) }}" class="btn btn-pink">Let's find new friends</a>
        </div>
    </div>
@endsection
