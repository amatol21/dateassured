<?php

namespace App\Filters;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class UsersFilter extends AbstractFilter
{
    public static function createQuery(Request $request): Model|Builder
    {
        $query = User::where('status', '!=', UserStatus::DELETED);

        if ($request->has('name') && !empty($request->get('name'))) {
            $query->where('username', 'LIKE', $request->get('name').'%');
        }

        if ($request->has('gender') && !empty($request->get('gender'))) {
            $query->where('gender', '=', $request->get('gender'));
        }

        if ($request->has('sexuality') && !empty($request->get('sexuality'))) {
            $query->where('sexuality', '=', $request->get('sexuality'));
        }

        if ($request->has('role') && !empty($request->get('role'))) {
            $query->where('role_id', '=', $request->get('role'));
        }

        if ($request->has('age') && !empty($request->get('age'))) {
            $values = explode('-', $request->get('age'));
            if (count($values) > 0) $query->where('age', '>=', intval($values[0]));
            if (count($values) > 1) $query->where('age', '<=', intval($values[1]));
        }

        $sort = $request->get('sort', '');
        $order = $request->get('order') === 'asc' ? 'asc' : 'desc';
        if ($sort === 'name') {
            $query->orderBy('username', $order);
        } else if ($sort === 'age') {
            $query->orderBy('age', $order);
        } else if ($sort === 'gender') {
            $query->orderBy('gender', $order);
        } else if ($sort === 'money') {
            $query->orderBy('money', $order);
        } else if ($sort === 'sexuality') {
            $query->orderBy('sexuality', $order);
        } else if ($sort === 'status') {
            $query->orderBy('status', $order);
        } else if ($sort === 'role') {
            $query->orderBy('role_id', $order);
        } else if ($sort === 'activity') {
            $query->orderBy('activity', $order);
        } else if ($sort === 'created_at') {
            $query->orderBy('created_at', $order);
        }
        return $query;
    }
}
