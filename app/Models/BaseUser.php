<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\Purpose;
use App\Enums\Sexuality;
use App\Enums\UserStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $social_id
 * @property int $role_id
 * @property string $first_name
 * @property string $second_name
 * @property string $username
 * @property UserStatus $status
 * @property Gender $gender
 * @property Sexuality $sexuality
 * @property Purpose $purpose
 * @property int $age
 * @property string $email
 * @property string $email_verification_token
 * @property string $email_verification_sent_at
 * @property string $email_verified_at
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 * @property string $banned_to
 * @property int $activity
 * @property int $money
 * @property Role $role
 */
class BaseUser extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sexuality' => Sexuality::class,
        'purpose' => Purpose::class,
        'gender' => Gender::class,
        'status' => UserStatus::class,
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
