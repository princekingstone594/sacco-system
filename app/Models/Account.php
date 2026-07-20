<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account extends Model
{
    use HasFactory;

    public const TYPES = [
        'savings' => 'Savings',
        'shares' => 'Shares',
        'deposits' => 'Member Deposits',
        'portfolio' => 'Saving Portfolio',
    ];

    public const STANDARD_TYPES = [
        'savings' => 'Savings',
        'shares' => 'Shares',
        'deposits' => 'Member Deposits',
    ];

    protected $fillable = [
        'member_id',
        'account_no',
        'type',
        'balance',
        'opened_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'opened_at' => 'date',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function savingPortfolio(): HasOne
    {
        return $this->hasOne(SavingPortfolio::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }
}
