@extends('layouts.main')

@section('content')
    <div class="width-limiter pt-2">
        <form action="{{ route('resetPassword', ['token' => $token], false) }}" method="POST"
              style="width: 25rem; max-width: 100%; margin: 0 auto">
            @csrf

            <div class="chat_no-conversations-title flex jc-center">You have no contacts yet</div>
            <div class="chat_no-conversations-hint">
                To find new friends and establish new contacts take participation in upcoming video chat sessions.
            </div>

            <label class="flex column mt-2">
                <span class="label">New password</span>
                <input type="password" name="password" class="input" required>
                @error('password')
                <span class="error" data-for="password" style="visibility: visible">{{ $message }}</span>
                @enderror
            </label>

            <label class="flex column mt-1">
                <span class="label">Confirm new password</span>
                <input type="password" name="password_confirmation" class="input" required>
                @error('password_confirmation')
                <span class="error" data-for="password_confirmation" style="visibility: visible">{{ $message }}</span>
                @enderror
            </label>

            <div class="flex mt-2">
                <button type="button" class="btn mr-1 ml-auto" onclick="closeModal(this)">Cancel</button>
                <button type="submit" class="btn btn-pink">Set new password</button>
            </div>
        </form>
    </div>
@endsection
