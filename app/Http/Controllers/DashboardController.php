<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * USER DASHBOARD (OVERVIEW ONLY)
     */
    public function index(): View
    {
        $user = auth()->user();

        // 🚫 Redirect admins
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $member = $user->member ?? null;

        // 🧱 Empty state
        if (!$member) {
            return view('dashboard.user', [
                'balance' => 0,
                'savings' => 0,
                'loans' => collect(),
                'transactions' => collect(),
                'loanBalance' => 0,
                'activeLoans' => 0,
            ]);
        }

        // 💰 SAVINGS (REAL MONEY)
        $savings = $member->accounts()->sum('balance');

        // 💸 LOANS
        $loans = $member->loans()->latest()->get();

        $approvedLoans = $loans->where('status', 'approved');

        $loanBalance = $approvedLoans->sum('amount');

        $activeLoans = $approvedLoans->count();

        // 🧾 RECENT ACTIVITY (LIMITED)
        $transactions = $member->transactions()
            ->latest()
            ->take(5)
            ->get();

        // 💎 IMPORTANT: Dashboard balance = SAVINGS ONLY
        // (wallet handles full financial view)
        $balance = $savings;

        return view('dashboard.user', compact(
            'balance',
            'savings',
            'loans',
            'transactions',
            'loanBalance',
            'activeLoans'
        ));
    }


    /**
     * WALLET PAGE (FULL FINANCIAL VIEW)
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

        // 💰 SAVINGS
        $savings = $member->accounts()->sum('balance');

        // 💸 LOANS
        $loans = $member->loans()->latest()->get();

        $loanBalance = $loans
            ->where('status', 'approved')
            ->sum('amount');

        // 💎 FULL WALLET BALANCE (this is where combining makes sense)
        $balance = $savings + $loanBalance;

        // 🧾 TRANSACTIONS (MORE THAN DASHBOARD)
        $transactions = $member->transactions()
            ->latest()
            ->take(10)
            ->get();

        // 📈 ANALYTICS
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