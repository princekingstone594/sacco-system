<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    public const TYPES = [
        'deposit' => 'Deposit',
        'withdrawal' => 'Withdrawal',
        'share_purchase' => 'Share Purchase',
        'fee' => 'Fee',
        'adjustment' => 'Adjustment',
    ];

    protected $fillable = [
        'member_id',
        'account_id',
        'posted_by',
        'type',
        'amount',
        'reference',
        'transacted_at',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transacted_at' => 'date',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }

    public function isDebit(): bool
    {
        return in_array($this->type, ['withdrawal', 'fee'], true);
    }
}
