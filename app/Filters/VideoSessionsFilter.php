<?php

namespace App\Filters;

use App\Enums\VideoSessionStatus;
use App\Models\VideoSession;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VideoSessionsFilter extends AbstractFilter
{

    public static function createQuery(Request $request): Model|Builder
    {
        $query = VideoSession::query()
            ->with(['members.user', 'talks']);



        if ($request->has('name') && !empty($request->get('name'))) {
            if (is_numeric($request->get('name'))) {
                $query->where('id', $request->get('name'));
            } else {
                $query->whereIn('id', function($q) use ($request) {
                    $q->select('video_session_id')
                        ->from('video_sessions_members')
                        ->leftJoin('users', 'video_sessions_members.user_id', '=', 'users.id')
                        ->where('users.username', 'LIKE', $request->get('name').'%');
                });
            }
        } else {
            $query->where(function($q) {
                $q->has('members', '>', 0);
                $q->orWhere('status', '!=', VideoSessionStatus::DONE->value);
            });
        }

        if ($request->has('sexuality') && !empty($request->get('sexuality'))) {
            $query->where('sexuality', '=', $request->get('sexuality'));
        }

        if ($request->has('purpose') && !empty($request->get('purpose'))) {
            $query->where('purpose', '=', $request->get('purpose'));
        }

        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('status', '=', $request->get('status'));
        }

        if ($request->has('age') && !empty($request->get('age'))) {
            $values = explode('-', $request->get('age'));
            if (count($values) > 0) $query->where('min_age', '>=', intval($values[0]));
            if (count($values) > 1) $query->where('max_age', '<=', intval($values[1]));
        }

        $sort = $request->get('sort', 'id');
        $order = $request->get('order') === 'asc' ? 'asc' : 'desc';

        if ($sort === 'id') {
            $query->orderBy('id', $order);
        } else if ($sort === 'age') {
            $query->orderBy('min_age', $order);
        } else if ($sort === 'sexuality') {
            $query->orderBy('sexuality', $order);
        } else if ($sort === 'purpose') {
            $query->orderBy('purpose', $order);
        } else if ($sort === 'started_at') {
            $query->orderBy('started_at', $order);
        } else if ($sort === 'country') {
            $query->orderBy('country', $order);
        } else if ($sort === 'status') {
            $query->orderBy('status', $order);
        }

        return $query;
    }
}
