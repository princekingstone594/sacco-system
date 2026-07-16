<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoanRepayment;
use App\Models\Loan;
use App\Notifications\LoanOverdueNotification;

class CheckLoanStatus extends Command
{
    protected $signature = 'loans:check-status';
    protected $description = 'Check overdue repayments and update loan status';

    public function handle()
    {
        $today = now();

        // 🔍 Get overdue unpaid repayments
        $overdues = LoanRepayment::with('loan.member.user')
            ->where('paid', false)
            ->whereDate('due_date', '<', $today)
            ->get();

        foreach ($overdues as $repayment) {

            // ✅ 1. Mark as overdue (only once)
            if (!$repayment->overdue) {
                $repayment->update([
                    'overdue' => true,
                    'penalty' => $repayment->penalty + 50, // 🔥 flat penalty (adjust later)
                ]);
            }

            $loan = $repayment->loan;

            // ✅ 2. Update loan status
            if ($loan && $loan->status !== 'defaulted') {
                $loan->update([
                    'status' => 'overdue',
                ]);
            }

            // ✅ 3. Notify user (avoid spam)
            $user = $loan?->member?->user;

            if ($user && !$repayment->notified) {
                $user->notify(new LoanOverdueNotification($repayment));

                $repayment->update([
                    'notified' => true,
                ]);
            }
        }

        $this->info('Loan status check completed.');
    }
}