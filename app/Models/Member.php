<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_no',
        'first_name',
        'last_name',
        'national_id',
        'phone',
        'email',
        'date_of_birth',
        'address',
        'employer',
        'next_of_kin_name',
        'next_of_kin_phone',
        'joined_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'joined_at' => 'date',
        ];
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
