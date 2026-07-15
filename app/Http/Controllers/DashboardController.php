<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * USER DASHBOARD
     */
    public function index(): View
    {
        $user = auth()->user();

        // 👉 Redirect admins away
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $member = $user->member ?? null;

        if (!$member) {
            return view('dashboard.user', [
                'balance' => 0,
                'savings' => 0,
                'loans' => collect(),
                'transactions' => collect(),
            ]);
        }

        // 💰 Savings
        $savings = $member->accounts()->sum('balance');

        // 💸 Loans
        $loans = $member->loans()->latest()->get();

        // 🧾 Transactions
        $transactions = $member->transactions()->latest()->take(5)->get();

        // 🧮 Loan Balance
        $loanBalance = $loans
            ->where('status', 'approved')
            ->sum('amount');

        // 💎 Total Balance
        $balance = $savings + $loanBalance;

        return view('dashboard.user', compact(
            'balance',
            'savings',
            'loans',
            'transactions'
        ));
    }


    /**
     * WALLET PAGE (FULL VERSION)
     */
    public function wallet(): View
    {
        $user = auth()->user();
        $member = $user->member ?? null;

        if (!$member) {
            return view('dashboard.wallet', [
                'balance' => 0,
                'savings' => 0,
                'loans' => collect(),
                'transactions' => collect(),
                'income' => 0,
                'expense' => 0,
            ]);
        }

        $savings = $member->accounts()->sum('balance');
        $loans = $member->loans()->latest()->get();
        $transactions = $member->transactions()->latest()->take(10)->get();

        $loanBalance = $loans
            ->where('status', 'approved')
            ->sum('amount');

        $balance = $savings + $loanBalance;

        $income = $member->transactions()
            ->where('type', 'deposit')
            ->sum('amount');

        $expense = $member->transactions()
            ->where('type', 'withdrawal')
            ->sum('amount');

        return view('dashboard.wallet', compact(
            'balance',
            'savings',
            'loans',
            'transactions',
            'income',
            'expense'
        ));
    }
}