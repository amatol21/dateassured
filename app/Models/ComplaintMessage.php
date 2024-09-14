<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $complaint_id
 * @property int $user_id
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class ComplaintMessage extends Model
{
    protected $table = 'complaints_messages';
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i');
    }
}
