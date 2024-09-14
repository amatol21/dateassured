<?php

use App\Enums\Permission;
use App\Models\Role;

/**
 * @var Role $role
 */
?>

@extends('admin.index')

@section('adminContent')
    <form action="{{ route('admin.roles.save', [], false) }}" class="pad" method="POST">
        @csrf

        <h2 class="account_title mb-2">
            <a href="{{ route('admin.roles', [], false) }}" class="admin_back-button">Users</a>
            <span>{{ $role->exists ? $role->name : 'Role creation' }}</span>
        </h2>

        @if($role->exists)
            <input type="hidden" name="id" value="{{ $role->id }}">
        @endif

        <div class="pb-2 pl-2 pr-2">
            <label>
                <span class="label">Name</span>
                <input type="text" name="name" class="input" value="{{ old('name', $role->name) }}">
                @error('name')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>
        </div>

        <div class="profile_fields pl-2 pr-2">
            @foreach(Permission::cases() as $permission)
            <label class="checkbox">
                <input type="checkbox" name="permissions[]" value="{{ $permission->value }}" @if($role->hasPermission($permission)) checked @endif >
                <span></span>
                <span>{{ __('enums.permission.'.$permission->value) }}</span>
            </label>
            @endforeach
        </div>

        <div class="p-2 flex jc-end">
            <button type="submit" class="btn btn-pink">{{ $role->exists ? 'Save' : 'Create' }}</button>
        </div>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
