<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'loan_product_id',
        'loan_no',
        'principal',
        'interest_rate',
        'term_months',
        'total_payable',
        'balance',
        'issued_on',
        'due_on',
        'status',
        'purpose',
        'amount',
        'duration_months',
        'approved_at',
        'disbursed_at',
    ];

    protected function casts(): array
    {
        return [
            'principal' => 'decimal:2',
            'interest_rate' => 'decimal:2',
            'total_payable' => 'decimal:2',
            'balance' => 'decimal:2',
            'issued_on' => 'date',
            'due_on' => 'date',
        ];
    }

    // =========================
    // STATUS CONSTANTS
    // =========================
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_DISBURSED = 'disbursed';
    public const STATUS_COMPLETED = 'completed';

    // =========================
    // RELATIONSHIPS
    // =========================
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(LoanProduct::class, 'loan_product_id');
    }

    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    // =========================
    // HELPER METHODS (CLEAN LOGIC)
    // =========================
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isDisbursed(): bool
    {
        return $this->status === self::STATUS_DISBURSED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    // =========================
    // BUSINESS LOGIC
    // =========================

    // Check if fully paid
    public function isFullyPaid(): bool
    {
        return $this->balance <= 0;
    }
}