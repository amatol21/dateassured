@extends('layouts.main')


@section('content')
    <div class="static-page width-limiter" style="display: flex; flex-direction: column; align-items: center">
        <h1>Contact Us</h1>

        <h2>We are here to help!</h2>
        <p>Please fill in information below and we will attend to your query asap.</p>

        <form action="{{ route('contactUs', [], false) }}" method="POST"
              class="mt-2"
              style="display: flex; flex-direction: column; width: 30rem; max-width: 100%">
            @csrf

            <label class="">
                <span class="label">Your name</span>
                <input type="text" name="name" class="input" value="{{ old('name') }}">
                @error('name')
                <span class="error" style="visibility: visible">{{ $message }}</span>
                @enderror
            </label>

            <label class="mt-2">
                <span class="label">Email address</span>
                <input type="email" name="email" class="input" value="{{ old('email') }}">
                @error('email')
                <span class="error" style="visibility: visible">{{ $message }}</span>
                @enderror
            </label>

            <label class="mt-2">
                <span class="label">Subject</span>
                <input type="text" name="subject" class="input" value="{{ old('subject') }}">
                @error('subject')
                <span class="error" style="visibility: visible">{{ $message }}</span>
                @enderror
            </label>

            <label class="mt-2">
                <span class="label">Message</span>
                <textarea class="input" name="message" rows="10">{{ old('message') }}</textarea>
                @error('message')
                <span class="error" style="visibility: visible">{{ $message }}</span>
                @enderror
            </label>

            <div class="mt-2 flex">
                <button type="submit" class="btn btn-pink ml-auto">Submit</button>
            </div>
        </form>
    </div>
@endsection
