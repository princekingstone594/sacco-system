<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'location',
        'national_id',
        'date_of_birth',
        'occupation',
        'next_of_kin_name',
        'next_of_kin_phone',
        'profile_photo_path',
        'bio',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
        ];
    }

    /**
     * One user = one member profile
     */
    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function customerCareInquiries(): HasMany
    {
        return $this->hasMany(CustomerCareInquiry::class);
    }
}
