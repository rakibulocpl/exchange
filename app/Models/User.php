<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'password',
        'email',
        'branch_id'
    ];

    protected $appends = ['profile_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
public function getProfileUrlAttribute($value)
{
    // Default Photo
    $defaultPhotoUrl = url("uploads/user.png");

    // Photo from User's account
    $userPhotoUrl = null;
    if (!empty($this->image)) {
        $userPhotoUrl = url($this->image);
    }

    $value = !empty($userPhotoUrl) ? $userPhotoUrl : $defaultPhotoUrl;

    return $value;
}
}
