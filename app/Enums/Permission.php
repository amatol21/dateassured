<?php

namespace App\Enums;

use Illuminate\Support\Facades\Auth;

enum Permission: string
{
    case ACCESS_ADMIN_PANEL = 'accessAdminPanel';
    case MANAGE_VIDEO_SESSIONS = 'manageVideoSessions';
    case MANAGE_USERS = 'manageUsers';
    case MANAGE_NEWS = 'manageNews';
    case MANAGE_BLOG = 'manageBlog';
    case MANAGE_PAYMENTS = 'managePayments';
    case MANAGE_ROLES = 'manageRoles';
    case ALL = 'all';
    case COMPLAINTS = 'complaints';

    public function allowed(): bool
    {
        return Auth::user() !== null && Auth::user()->hasPermission($this);
    }


    public function name(): bool
    {
        return __('enums.permission.'.$this->value);
    }
}
