<?php

use App\Models\Role;
use Illuminate\Pagination\Paginator;

/**
 * @var $roles Role[]|Paginator
 */
?>

@extends('admin.index')

@section('adminContent')

    <div id="roles-list" class="roles-list pad">
        <h2 class="account_title mb-2">
            Roles
            <a href="{{ route('admin.roles.create', [], false) }}" class="btn btn-pink btn-small ml-auto">Create role</a>
        </h2>


        <table class="pl-2 pr-2 w-100">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="width: 3rem"></th>
                </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @include('common.ui.dotsMenu', ['options' => [
                            'edit-role' => ['label' => 'Edit', 'payload' => ['id' => $role->id]],
                            'delete-role' => ['label' => 'Delete', 'payload' => ['id' => $role->id, 'name' => $role->name]],
                        ]])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if($roles->hasPages())
            <div class="p-2">
                {{ $roles->appends($_GET)->links('common.ui.pagination') }}
            </div>
        @endif
    </div>


    <script>
        (() => {
            document.addEventListener('edit-role', e => {
                window.location = '/admin/roles/edit/' + e.detail.id;
            });

            document.addEventListener('edit-role', async e => {

            });
        })();
    </script>
@endsection
