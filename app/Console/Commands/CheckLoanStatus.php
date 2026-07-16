<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoanRepayment;
use App\Models\Loan;

class CheckLoanStatus extends Command
{
    protected $signature = 'loans:check-status';
    protected $description = 'Check overdue repayments and update loan status';

    public function handle()
    {
        $today = now();

        // 🔍 Find overdue repayments
        $overdues = LoanRepayment::where('paid', false)
            ->where('due_date', '<', $today)
            ->get();

        foreach ($overdues as $repayment) {

            // Mark overdue
            $repayment->update([
                'overdue' => true
            ]);

            $loan = $repayment->loan;

            // If too many overdue → default loan
            $overdueCount = $loan->repayments()
                ->where('overdue', true)
                ->count();

            if ($overdueCount >= 2 && $loan->status !== 'defaulted') {
                $loan->update([
                    'status' => 'defaulted'
                ]);
            }
        }

        $this->info('Loan status checked successfully');
    }
}