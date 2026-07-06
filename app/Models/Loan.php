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

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(LoanProduct::class, 'loan_product_id');
    }

    public function repayments(): HasMany
    {
        return $this->hasMany(LoanRepayment::class);
    }
}
