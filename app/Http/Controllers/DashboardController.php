<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        // =========================
        // BASIC STATS
        // =========================
        $membersCount = Member::count();

        $totalSavings = Account::whereIn('type', ['savings', 'deposits'])
            ->sum('balance');

        $activeLoans = Loan::where('status', 'active')->count();

        // =========================
        // MONTHLY CHART DATA (LAST 6 MONTHS)
        // =========================
        $months = collect(range(0, 5))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('M');
        })->reverse()->values();

        $monthlySavings = collect(range(0, 5))->map(function ($i) {
            return Transaction::where('type', 'deposit')
                ->whereMonth('transacted_at', Carbon::now()->subMonths($i)->month)
                ->sum('amount');
        })->reverse()->values();

        // =========================
        // RECENT ACTIVITY
        // =========================
        $recentActivities = Transaction::with('member')
            ->latest('transacted_at')
            ->take(5)
            ->get();

        // =========================
        // RETURN VIEW
        // =========================
        return view('dashboard', [
            'membersCount' => $membersCount,
            'totalSavings' => $totalSavings,
            'activeLoans' => $activeLoans,
            'months' => $months,
            'monthlySavings' => $monthlySavings,
            'recentActivities' => $recentActivities,
        ]);
    }

    public function wallet()
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

    // Savings
    $savings = $member->accounts()->sum('balance');

    // Loans
    $loans = $member->loans()->latest()->get();

    // Transactions
    $transactions = $member->transactions()->latest()->take(10)->get();

    // Loan balance (approved only)
    $loanBalance = $loans->where('status', 'approved')->sum('amount');

    // Total balance
    $balance = $savings + $loanBalance;

    // Chart data
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