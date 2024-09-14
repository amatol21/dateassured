<?php

use App\Enums\Gender;
use App\Enums\Sexuality;
use App\Enums\Size;
use App\Enums\UserStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Pagination\Paginator;

/**
 * @var $users User[]|Paginator
 */
?>

@extends('admin.index')

@section('adminContent')
    <div id="users-list" class="users-list pad">
        <h2 class="account_title mb-2">
            Users
            <a href="{{ route('admin.users.create', [], false) }}" class="btn btn-pink btn-small ml-auto">Create user</a>
        </h2>
        <form action="{{ route('admin.users', [], false) }}" id="users-filter" class="users-filter mb-2 pl-2 pr-2">
            <select name="gender" class="input input-small">
                <option value="" @if(request()->get('gender') === '') selected @endif>Any gender</option>
                <option value="{{ Gender::MALE->value }}" @if(request()->get('gender') === ''.Gender::MALE->value) selected @endif>Male</option>
                <option value="{{ Gender::FEMALE->value }}" @if(request()->get('gender') === ''.Gender::FEMALE->value) selected @endif>Female</option>
            </select>
            <select name="sexuality" class="input input-small">
                <option value="" @if(request()->get('sexuality') === '') selected @endif>Any sexuality</option>
                <option value="{{ Sexuality::STRAIGHT->value }}" @if(request()->get('sexuality') === ''.Sexuality::STRAIGHT->value) selected @endif>Straight</option>
                <option value="{{ Sexuality::GAY->value }}" @if(request()->get('sexuality') === ''.Sexuality::GAY->value) selected @endif>Gay</option>
                <option value="{{ Sexuality::LESBIAN->value }}" @if(request()->get('sexuality') === ''.Sexuality::LESBIAN->value) selected @endif>Lesbian</option>
                <option value="{{ Sexuality::BI->value }}" @if(request()->get('sexuality') === ''.Sexuality::BI->value) selected @endif>Bi</option>
            </select>
            <select name="age" class="input input-small">
                <option value="0-100" @if(request()->get('age') === '') selected @endif>All Ages</option>
                <option value="18-26" @if(request()->get('age') === '18-26') selected @endif>18-26</option>
                <option value="27-35" @if(request()->get('age') === '27-35') selected @endif>27-35</option>
                <option value="36-44" @if(request()->get('age') === '36-44') selected @endif>36-44</option>
                <option value="45-54" @if(request()->get('age') === '45-54') selected @endif>45-54</option>
                <option value="55-65" @if(request()->get('age') === '55-65') selected @endif>55-65</option>
                <option value="66-100" @if(request()->get('age') === '66-100') selected @endif>66-70+</option>
            </select>
            <select name="role" class="input input-small">
                <option value="">Any roles</option>
                @foreach(Role::allRoles() as $role)
                    <option value="{{ $role->id }}" @if(request()->get('role') == $role->id) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
            <input type="hidden" name="sorting" value="reg-date">
            <input type="text" name="name" placeholder="Name or email..." value="{{ request()->get('name', '') }}" class="input input-small">
            <button type="submit" class="btn btn-small btn-pink">Search</button>
            <button type="button" class="btn btn-small btn-pink" onclick="document.dispatchEvent(new CustomEvent('send-messages-to-users'))">Send message</button>
        </form>


        @if($users->count() > 0)
        <table id="users-table" class="pl-2 pr-2">
            <thead>
            <tr>
                <th style="width: 4rem"></th>
                <th data-sort="name">Name</th>
                <th data-sort="age" class="center">Age</th>
                <th data-sort="role" class="center">Role</th>
                <th data-sort="gender" class="center">Gender</th>
                <th data-sort="money" class="center">Balance</th>
                <th data-sort="activity" class="center">Activity</th>
                <th data-sort="created_at" class="center">Registered</th>
                <th data-sort="status" class="center">Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr data-id="{{ $user->id }}">
                    <td>
                        <img class="users_item_photo"
                             src="{{ $user->getPhotoUrl(Size::SMALL) }}" alt="{{ $user->getFullName() }}">
                    </td>

                    <td>
                        <div class="users_item_texts">
                            <div class="users_item_name">{{ $user->getFullName() }}</div>
                            <div class="users_item_email">{{ $user->email }}</div>
                        </div>
                    </td>
                    <td class="center">{{ $user->age }}</td>

                    <td>
                        <div
                            class="users_item_role">{{ $user->role === null ? 'Regular user' : $user->role->name }}</div>
                    </td>
                    <td class="center">
                        {{ $user->gender === Gender::MALE ? 'Male' : 'Female' }}
                    </td>
                    <td class="center">
                        {{ round($user->money/1000, 2) }}
                    </td>
                    <td class="center">
                        {{ $user->activity }}
                    </td>
                    <td class="center">
                        {{ $user->created_at }}
                    </td>

                    <td class="center">
                        <div class="users_item_status status-{{ $user->status }}"
                             title="{{ $user->status === UserStatus::BANNED ? 'Ban to ' . substr($user->banned_to, 0, 10) : 'Active' }}">
                        </div>
                    </td>

                    <td>
                        <div class="flex ai-center ml-auto">
                            @php
                            $payload = ['id' => $user->id, 'name' => $user->getFullName()];
                            $options = [
                                'delete-user' => ['label' => 'Delete', 'payload' => $payload],
                            ];
                            if ($user->status === UserStatus::BANNED && strtotime($user->banned_to) > time()) {
                                $options['unban-user'] = ['label' => 'Unban', 'payload' => $payload];
                            } else {
                                $options['ban-user'] = ['label' => 'Ban', 'payload' => $payload];
                            }
                            $options['fill-up-user-balance'] = ['label' => 'Fill-up balance', 'payload' => $payload];
                            $options['send-message-to-user'] = ['label' => 'Send message', 'payload' => $payload];
                            $options['edit-user'] = ['label' => 'Edit', 'payload' => $payload];
                            if (!$user->hasVerifiedEmail()) {
                                $options['verify-user-email'] = ['label' => 'Verify email', 'payload' => $payload];
                            }
                            @endphp
                            @include('common.ui.dotsMenu', ['options' => $options])
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        @if($users->hasPages())
        <div class="p-2">
            {{ $users->appends($_GET)->links('common.ui.pagination') }}
        </div>
        @endif

        @else

            <div class="no-data-msg">
                <div class="no-data-msg_title">Nothing found by your request</div>
                <div class="no-data-msg_hint">Try to change your request and try again.</div>
            </div>

        @endif
    </div>


    <script>
        (() => {
            initTableSorting('#users-table', '#users-filter');
            let usersFilter = document.getElementById('users-filter');

            async function setUserStatus(userId, action, params) {
                try {
                    let data = {
                        _token: '{{ csrf_token() }}',
                        id: userId,
                    };

                    if (params !== undefined) {
                        for (let p in params) {
                            data[p] = params[p];
                        }
                    }
                    let res = await fetch('/admin/users/' + action, {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: {'Content-Type': 'application/json'}
                    });
                    if (res.ok) {
                        return true;
                    }
                } catch (e) {
                    console.error(e);
                }
                return false;
            }

            // Delete
            document.addEventListener('delete-user', async e => {
                if (confirm('Are you really want to delete user ' + e.detail.name + '?')) {
                    let res = await setUserStatus(e.detail.id, 'delete')
                    if (res) window.location.reload();
                }
            });

            // Verify email
            document.addEventListener('verify-user-email', async e => {
                if (confirm('Verify email for user ' + e.detail.name + '?')) {
                    let res = await setUserStatus(e.detail.id, 'verify-email')
                    if (res) window.location.reload();
                }
            });

            // Ban
            document.addEventListener('ban-user', async e => {
                let days = prompt('Input count of days for ban user ' + e.detail.name, '0');
                if (days !== null) {
                    try {
                        days = parseInt(days);
                        if (isNaN(days) || days <= 0) {
                            alert('Input number greater than zero.');
                            return;
                        }
                        let res = setUserStatus(e.detail.id, 'ban', {days: days});
                        if (res) window.location.reload();
                    } catch (e) {
                        console.error(e);
                    }
                }
            });

            // Unban
            document.addEventListener('unban-user', async e => {
                if (confirm('Do you really want to unban user ' + e.detail.name + '?')) {
                    let res = await setUserStatus(e.detail.id, 'unban')
                    if (res) {
                        window.location.reload();
                    }
                }
            });

            // Edit
            document.addEventListener('edit-user', async e => {
                window.location = '/admin/users/edit/' + e.detail.id;
            });

            document.addEventListener('send-message-to-user', async e => {
                let msg = prompt('Input message for user ' + e.detail.name, '');
                if (msg !== null) {
                    document.dispatchEvent(new CustomEvent('send-notification', {detail: {
                        id: e.detail.id,
                        message: msg
                    }}));
                }
            });

            document.addEventListener('send-messages-to-users', async () => {
                let data = new FormData(usersFilter);
                let users = {};
                if (data.has('gender') && data.get('gender') !== '') users.gender = parseInt(data.get('gender'));
                if (data.has('sexuality') && data.get('sexuality') !== '') users.sexuality = parseInt(data.get('sexuality'));
                let age = data.has('age') ? data.get('age').split('-') : ('0-100').split('-');
                users.minAge = age[0]; users.maxAge = age[1];
                if (data.has('role_id') && data.get('role_id') !== '') users.roleId = parseInt(data.get('role_id'));
                let message = prompt("Input message to be sent:");
                if (message === null) return;
                document.dispatchEvent(new CustomEvent('send-notification-to-all', {detail: {
                    users: users,
                    message: message
                }}));
                alert("Message successfully sent.");
            });

            document.addEventListener('fill-up-user-balance', async e => {
                let count = prompt('Input count of money for fill up to user ' + e.detail.name, '0');
                if (count !== null) {
                    try {
                        count = parseFloat(count);
                        if (isNaN(count) || count <= 0) {
                            alert('Input number greater than zero.');
                            return;
                        }
                        let res = setUserStatus(e.detail.id, 'fill-up-balance', {count: count});
                        if (res) window.location.reload();
                    } catch (e) {
                        console.error(e);
                    }
                }
            });
        })();
    </script>
@endsection
