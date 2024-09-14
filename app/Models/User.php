<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\Permission;
use App\Enums\Size;
use App\Enums\UserStatus;
use App\Events\UserRetrievedEvent;
use App\Mail\EmailVerification;
use App\Traits\ImageContainer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class User extends BaseUser
{
    use ImageContainer;

    public const DUMMY_PASSWORD = 'dummyPassword';

    protected $dispatchesEvents = [
        'retrieved' => UserRetrievedEvent::class,
    ];

    public function getFullName(): string
    {
        return empty($this->first_name)
            ? (empty($this->username) ? explode('@', $this->email)[0] : $this->username)
            : $this->first_name .' '. $this->second_name;
    }

    /**
     * Configuration of the user's photo variants.
     * @return array<int, int>
     */
    protected function getImageSizes(): array
    {
        return [
            Size::SMALLEST->value => 60,
            Size::SMALL->value    => 120,
            Size::MEDIUM->value   => 240,
            Size::LARGE->value    => 480,
            Size::LARGEST->value  => 600,
        ];
    }

    protected function getImagePathPrefix(): string
    {
        return 'photos';
    }

    protected function getImageFieldName(): string
    {
        return 'photo_json';
    }

    public function getDefaultImageUrl() : string
    {
        return '/images/avatar-'.($this->gender === Gender::MALE ? 'male' : 'female').'.jpg';
    }

    protected function getImageAspectRatio(): float
    {
        return 1;
    }

    /**
     * Checks if user has permission or not.
     * @see Permission, Role
     */
    public function hasPermission(Permission $permission): bool
    {
        return $this->role !== null && $this->role->hasPermission($permission);
    }

    /**
     * Returns URL to user's photo with given size.
     * @param Size $size
     * @return string
     * @see getImageSizes
     */
    public function getPhotoUrl(Size $size = Size::MEDIUM): string
    {
        return $this->getImageUrl($size);
    }

    public function sendEmailVerificationNotification()
    {
        if (is_null($this->email_verification_token)) {
            $this->email_verification_token = Str::random(32);
        }
        $this->email_verification_sent_at = DB::raw('NOW()');
        $this->save();
        Mail::send(new EmailVerification($this));
        Log::info("Verification email sent");
    }

    public function sendPasswordResetNotification($token)
    {

    }

    public static function current(): User|null
    {
        return Auth::user();
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i');
    }

    public function getBannedToAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i');
    }
}
