<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanRepayment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * LIST ALL LOANS (ADMIN)
     */
    public function index()
    {
        $loans = Loan::with('member.user')
            ->latest()
            ->get();

        return view('admin.loans.index', compact('loans'));
    }


    /**
     * APPROVE LOAN
     */
    public function approve(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Loan already processed');
        }

        // 💰 Calculate total payable
        $interest = ($loan->amount * $loan->interest_rate) / 100;
        $totalPayable = $loan->amount + $interest;

        $loan->update([
            'status' => 'approved',
            'approved_at' => now(),
            'total_payable' => $totalPayable,
        ]);

        return back()->with('success', 'Loan approved');
    }


    /**
     * REJECT LOAN
     */
    public function reject(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Loan already processed');
        }

        $loan->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Loan rejected');
    }


    /**
     * DISBURSE LOAN (CRITICAL STEP)
     */
    public function disburse(Loan $loan)
    {
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Loan must be approved first');
        }

        $member = $loan->member;

        // 💰 Add money to account (wallet)
        $account = $member->accounts()->first();

        $account->increment('balance', $loan->amount);

        // 🧾 Create transaction
        Transaction::create([
            'member_id' => $member->id,
            'type' => 'deposit',
            'amount' => $loan->amount,
            'description' => 'Loan disbursement',
        ]);

        // 🧱 Create repayment schedule
        $monthly = $loan->total_payable / $loan->duration_months;

        for ($i = 1; $i <= $loan->duration_months; $i++) {
            LoanRepayment::create([
                'loan_id' => $loan->id,
                'amount' => $monthly,
                'due_date' => now()->addMonths($i),
            ]);
        }

        // 🔄 Update status
        $loan->update([
            'status' => 'active',
            'disbursed_at' => now(),
        ]);

        return back()->with('success', 'Loan disbursed & schedule created');
    }


    /**
     * RECORD REPAYMENT
     */
    public function repay(Request $request, Loan $loan)
    {
        $repayment = $loan->repayments()
            ->where('paid', false)
            ->orderBy('due_date')
            ->first();

        if (!$repayment) {
            return back()->with('error', 'Loan already cleared');
        }

        // Mark as paid
        $repayment->update([
            'paid' => true,
            'paid_at' => now(),
        ]);

        // 🧾 Create transaction
        Transaction::create([
            'member_id' => $loan->member_id,
            'type' => 'withdrawal',
            'amount' => $repayment->amount,
            'description' => 'Loan repayment',
        ]);

        // 💡 Check if fully paid
        if ($loan->repayments()->where('paid', false)->count() === 0) {
            $loan->update([
                'status' => 'completed',
            ]);
        }

        return back()->with('success', 'Repayment recorded');
    }
}