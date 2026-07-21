<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingPortfolio extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'education' => 'Education',
        'vacation' => 'Vacation',
        'construction' => 'Construction',
        'wedding' => 'Wedding',
        'retirement' => 'Retirement',
        'emergency' => 'Emergency Fund',
        'business' => 'Business',
        'vehicle' => 'Vehicle',
        'health' => 'Health & Medical',
        'other' => 'Other',
    ];

    protected $fillable = [
        'member_id',
        'account_id',
        'name',
        'category',
        'target_amount',
        'target_date',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'target_amount' => 'decimal:2',
            'target_date' => 'date',
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

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }
}
