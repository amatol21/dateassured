<?php

use App\Enums\Permission;
use App\Enums\Sexuality;
use App\Models\Role;
use App\Models\User;
use App\Enums\Gender;
use App\Enums\Size;

/**
 * @var User $user
 */
?>

@extends('admin.index')

@section('adminContent')
    <form action="{{ route('admin.users.save', [], false) }}" class="pad" method="POST" enctype="multipart/form-data">
        @csrf

        <h2 class="account_title mb-2">
            <a href="{{ route('admin.users', [], false) }}" class="admin_back-button">Users</a>
            <span>{{ $user->exists ? $user->getFullName() : 'User creation' }}</span>
        </h2>

        @if($user->exists)
            <input type="hidden" name="id" value="{{ $user->id }}">
        @endif

        @include('common.ui.photoInput', ['value' => $user->getPhotoUrl(Size::LARGE)])

        <div class="profile_fields pl-2 pr-2">

            <label>
                <span class="label">Username</span>
                <input type="text" name="username" class="input" value="{{ old('username', $user->username) }}">
                @error('username')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="label">Email</span>
                <input type="email" name="email" class="input" value="{{ old('email', $user->email) }}">
                @error('email')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="label">Gender</span>
                <select name="gender" class="select">
                    <option value="{{ Gender::MALE->value }}"
                            @if(old('gender', $user->gender) === Gender::MALE) selected @endif>
                        Male
                    </option>
                    <option value="{{ Gender::FEMALE->value }}"
                            @if(old('gender', $user->gender) === Gender::FEMALE) selected @endif>Female
                    </option>
                </select>
                @error('gender')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="label">Sexuality</span>
                <select name="sexuality" class="select">
                    @foreach(Sexuality::cases() as $sexuality)
                        <option value="{{ $sexuality->value }}"
                                @if(old('sexuality', $user->sexuality) === $sexuality) selected @endif>
                            {{ __('enums.sexuality.'.$sexuality->value) }}
                        </option>
                    @endforeach
                </select>
                @error('sexuality')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="label">Age</span>
                <input type="number" name="age" min="18" max="80" class="input" value="{{ old('age', $user->age) }}">
                @error('age')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="label">First name</span>
                <input type="text" name="first_name" class="input" value="{{ old('first_name', $user->first_name) }}">
                @error('first_name')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="label">Second name</span>
                <input type="text" name="second_name" class="input"
                       value="{{ old('second_name', $user->second_name) }}">
                @error('second_name')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>

            @if(User::current()->hasPermission(Permission::MANAGE_ROLES))
                <label>
                    <span class="label">Role</span>
                    <select name="role_id" class="select">
                        <option value="">(No role)</option>
                        @foreach(Role::allRoles() as $role)
                            <option value="{{ $role->id }}"
                                    @if(old('role_id', $user->role_id) === $role->id) selected @endif>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </label>
            @endif

                <label>
                    <span class="label">Password</span>
                    <input type="password" name="password" class="input" autocomplete="new-password">
                    @error('password')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </label>
        </div>

        <div class="p-2 flex jc-end">
            <button type="submit" class="btn btn-pink">{{ $user->exists ? 'Save' : 'Create' }}</button>
        </div>
    </form>
@endsection
