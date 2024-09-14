@php

use App\Enums\Gender;
use App\Enums\Size;
use App\Models\User;

@endphp

@extends('account.index')

@section('title')
    Profile | DateAssured
@endsection

@section('accountContent')

    @include('account.changePasswordModal')
    @include('account.verifyEmailModal')

    <h2 class="account_title">Profile</h2>

    <div>
        <form action="{{ route('account.saveProfile', [], false) }}" method="POST" enctype="multipart/form-data"
              id="profile-form">
            @csrf

            @include('common.ui.photoInput', ['value' => User::current()->getPhotoUrl(Size::LARGE)])

            <div class="profile_fields">
                <label>
                    <span class="label">Username</span>
                    <input type="text" name="username" class="input" value="{{ auth()->user()->username }}">
                    <span class="error" data-for="username"></span>
                </label>

                <label>
                    <span class="label">Email</span>
                    <input type="email" class="input" value="{{ auth()->user()->email }}" disabled>
                </label>

                <label>
                    <span class="label">Gender</span>
                    <select name="gender" class="select">
                        <option value="{{ Gender::MALE->value }}"
                                @if(auth()->user()->gender === Gender::MALE) selected @endif>
                            Male
                        </option>
                        <option value="{{ Gender::FEMALE->value }}"
                                @if(auth()->user()->gender === Gender::FEMALE) selected @endif>Female
                        </option>
                    </select>
                    <span class="error" data-for="gender"></span>
                </label>

                <label>
                    <span class="label">Age</span>
                    <input type="number" name="age" min="18" max="80" class="input" value="{{ auth()->user()->age }}">
                    <span class="error" data-for="age"></span>
                </label>

                <label>
                    <span class="label">First name</span>
                    <input type="text" name="first_name" class="input" value="{{ auth()->user()->first_name }}">
                    <span class="error" data-for="first_name"></span>
                </label>

                <label>
                    <span class="label">Second name</span>
                    <input type="text" name="second_name" class="input" value="{{ auth()->user()->second_name }}">
                    <span class="error" data-for="second_name"></span>
                </label>
            </div>

            <div class="profile_buttons">
                @if(!auth()->user()->hasVerifiedEmail())
                    <button type="button" class="btn mr-1"
                            onclick="document.dispatchEvent(new CustomEvent('verify-email'))">Verify email
                    </button>
                @endif
                <button type="button" class="btn mr-1"
                        onclick="document.dispatchEvent(new CustomEvent('change-password'))">Change password
                </button>
                <button type="submit" class="btn btn-pink">Save</button>
            </div>
        </form>
    </div>


    <script>
        (() => {
            let form = document.getElementById('profile-form');

            form.addEventListener('submit', async e => {
                e.preventDefault();
                clearFormErrors(form);
                await showSpinner(form);
                try {
                    let res = await fetch(form.getAttribute('action'), {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {'X-Requested-With': 'XMLHttpRequest'}
                    });
                    if (res.ok) {
                        document.dispatchEvent(new CustomEvent('update-user'));
                        await hideSpinner(form, 'Saved');
                        let html = await res.text();
                        setInnerHtml('#content', html);
                    } else {
                        let data = await res.json();
                        showFormErrors(form, data);
                        await hideSpinner(form);
                    }
                } catch (e) {
                    console.log(e);
                    await hideSpinner(form);
                }
            });
        })();
    </script>
@endsection
