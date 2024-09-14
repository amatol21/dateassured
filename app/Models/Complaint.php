<?php

namespace App\Models;

use App\Enums\ComplaintCategory;
use App\Enums\ComplaintStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property ComplaintCategory $category
 * @property string $subject
 * @property string $message
 * @property int $video_session_id
 * @property int $creator_id
 * @property int $resolver_id
 * @property ComplaintStatus $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $resolved_at
 *
 * @property User $creator
 * @property User $resolver
 * @property ComplaintMessage[] $messages
 */
class Complaint extends Model
{
    protected $casts = [
        'category' => ComplaintCategory::class,
        'status' => ComplaintStatus::class,
    ];

    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

    public function resolver(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'resolver_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ComplaintMessage::class, 'complaint_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i');
    }
}
