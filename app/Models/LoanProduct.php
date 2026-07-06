<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'interest_rate',
        'term_months',
        'minimum_amount',
        'maximum_amount',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'interest_rate' => 'decimal:2',
            'minimum_amount' => 'decimal:2',
            'maximum_amount' => 'decimal:2',
        ];
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
