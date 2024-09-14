<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $first_user_id
 * @property int $second_user_id
 * @property int $video_session_id
 * @property string $video_url
 * @property int $comment_from_user_1
 * @property int $comment_from_user_2
 * @property int $status
 * @property int $rate_from_user_1
 * @property int $rate_from_user_2
 * @property string $created_at
 *
 * @property User $user1
 * @property User $user2
 */
class VideoSessionTalk extends Model
{
    protected $table = 'video_sessions_results';


    public function user1(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'first_user_id');
    }

    public function user2(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'second_user_id');
    }
}
