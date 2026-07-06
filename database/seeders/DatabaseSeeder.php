<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\LoanProduct;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        LoanProduct::firstOrCreate(['name' => 'Development Loan'], [
            'interest_rate' => 12,
            'term_months' => 12,
            'minimum_amount' => 5000,
            'maximum_amount' => 500000,
            'description' => 'General member development financing.',
        ]);

        LoanProduct::firstOrCreate(['name' => 'Emergency Loan'], [
            'interest_rate' => 8,
            'term_months' => 6,
            'minimum_amount' => 1000,
            'maximum_amount' => 100000,
            'description' => 'Short-term urgent member support.',
        ]);

        DB::transaction(function () use ($user) {
            $members = [
                [
                    'member_no' => 'MBR-001',
                    'first_name' => 'Amina',
                    'last_name' => 'Otieno',
                    'national_id' => 'ID001',
                    'phone' => '+254700111222',
                    'email' => 'amina@example.com',
                    'joined_at' => now()->subMonths(8),
                    'employer' => 'County Hospital',
                ],
                [
                    'member_no' => 'MBR-002',
                    'first_name' => 'Brian',
                    'last_name' => 'Kiptoo',
                    'national_id' => 'ID002',
                    'phone' => '+254700333444',
                    'email' => 'brian@example.com',
                    'joined_at' => now()->subMonths(4),
                    'employer' => 'Greenline Traders',
                ],
            ];

            foreach ($members as $memberData) {
                $member = Member::firstOrCreate(
                    ['member_no' => $memberData['member_no']],
                    [...$memberData, 'status' => 'active']
                );

                foreach (Account::TYPES as $type => $label) {
                    $account = Account::firstOrCreate(
                        ['account_no' => strtoupper(substr($type, 0, 3)).'-'.$member->member_no],
                        [
                            'member_id' => $member->id,
                            'type' => $type,
                            'opened_at' => $member->joined_at,
                        ]
                    );

                    $amount = match ($type) {
                        'savings' => 15000,
                        'shares' => 10000,
                        default => 25000,
                    };

                    if ($account->wasRecentlyCreated) {
                        $account->update(['balance' => $amount]);
                    }
                    Transaction::firstOrCreate(
                        ['reference' => 'OPENING-'.$account->account_no],
                        [
                            'member_id' => $member->id,
                            'account_id' => $account->id,
                            'posted_by' => $user->id,
                            'type' => $type === 'shares' ? 'share_purchase' : 'deposit',
                            'amount' => $amount,
                            'transacted_at' => $member->joined_at,
                            'description' => 'Opening balance',
                        ]
                    );
                }
            }
        });
    }
}
