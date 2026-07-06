<?php

use App\Models\Account;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Member;
use App\Models\User;

it('registers a member with standard sacco accounts', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('members.store'), [
            'member_no' => 'MBR-100',
            'first_name' => 'Grace',
            'last_name' => 'Wanjiku',
            'national_id' => 'ID100',
            'phone' => '+254700000100',
            'email' => 'grace@example.com',
            'joined_at' => now()->format('Y-m-d'),
            'status' => 'active',
        ])
        ->assertRedirect(route('members.index'));

    $member = Member::where('member_no', 'MBR-100')->first();

    expect($member)->not->toBeNull()
        ->and($member->accounts()->count())->toBe(3);
});

it('posts deposits and repayments to the correct balances', function () {
    $user = User::factory()->create();
    $member = Member::create([
        'member_no' => 'MBR-101',
        'first_name' => 'Peter',
        'last_name' => 'Mwangi',
        'joined_at' => now(),
        'status' => 'active',
    ]);
    $account = Account::create([
        'member_id' => $member->id,
        'account_no' => 'SAV-MBR-101',
        'type' => 'savings',
        'opened_at' => now(),
    ]);
    $product = LoanProduct::create([
        'name' => 'Test Loan',
        'interest_rate' => 10,
        'term_months' => 10,
        'minimum_amount' => 1000,
        'maximum_amount' => 100000,
        'status' => 'active',
    ]);

    $this->actingAs($user)
        ->post(route('transactions.store'), [
            'account_id' => $account->id,
            'type' => 'deposit',
            'amount' => 2500,
            'transacted_at' => now()->format('Y-m-d'),
        ])
        ->assertRedirect(route('transactions.index'));

    expect($account->fresh()->balance)->toBe('2500.00');

    $this->actingAs($user)
        ->post(route('loans.store'), [
            'member_id' => $member->id,
            'loan_product_id' => $product->id,
            'loan_no' => 'LN-101',
            'principal' => 10000,
            'issued_on' => now()->format('Y-m-d'),
            'status' => 'active',
        ])
        ->assertRedirect(route('loans.index'));

    $loan = Loan::where('loan_no', 'LN-101')->first();

    expect($loan->balance)->toBe('11000.00');

    $this->actingAs($user)
        ->post(route('loans.repayments.store', $loan), [
            'amount' => 1000,
            'paid_on' => now()->format('Y-m-d'),
        ])
        ->assertRedirect(route('loans.show', $loan));

    expect($loan->fresh()->balance)->toBe('10000.00');
});
