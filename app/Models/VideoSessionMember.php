<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $video_session_id
 * @property int $user_id
 * @property int $position
 *
 * @property User $user
 */
class VideoSessionMember extends Model
{
    protected $table = 'video_sessions_members';

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
