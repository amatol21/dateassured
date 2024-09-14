<?php

namespace App\Http\Controllers\Admin;

use App\Filters\VideoSessionsFilter;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VideoSession;
use App\Models\VideoSessionTalk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoSessionsController extends Controller
{
    public function list(Request $request): View
    {
        return view('admin.videoSessions.list', [
            'videoSessions' => VideoSessionsFilter::createQuery($request)->paginate(20),
        ]);
    }


    public function talks(Request $request, int $videoSessionId, int $userId): View
    {
        $talks = VideoSessionTalk::where('video_session_id', $videoSessionId)
            ->with('user1', 'user2')
            ->where(function($builder) use ($userId) {
                $builder->where('first_user_id', $userId)->orWhere('second_user_id', $userId);
            })
            ->orderBy('created_at')
            ->get();
        return view('admin.videoSessions.talks', [
            'user' => User::where('id', $userId)->first(),
            'talks' => $talks
        ]);
    }
}
