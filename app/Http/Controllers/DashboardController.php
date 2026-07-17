<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Loan;

class DashboardController extends Controller
{
    /**
     * USER DASHBOARD
     */
    public function index(): View
    {
        $user = auth()->user();

        // 🚫 Redirect admins
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $member = $user->member ?? null;

        // 🧊 EMPTY STATE
        if (!$member) {
            return view('dashboard.user', [
                'balance' => 0,
                'savings' => 0,
                'loansCount' => 0,
                'activeLoans' => 0,
                'totalBorrowed' => 0,
                'totalRepaid' => 0,
                'loanBalance' => 0,
                'transactions' => collect(),
                'loans' => collect(), // ✅ FIX
                'monthlyTransactions' => [],
            ]);
        }

        /*
        |-------------------------------
        | 💰 SAVINGS
        |-------------------------------
        */
        $savings = $member->accounts()->sum('balance');

        /*
        |-------------------------------
        | 💳 LOANS
        |-------------------------------
        */
        $loansQuery = $member->loans();

        $loansCount = $loansQuery->count();

        $activeLoans = (clone $loansQuery)
            ->whereIn('status', ['approved', 'active'])
            ->count();

        $totalBorrowed = (clone $loansQuery)->sum('amount');

        // Full loans list (for Blade)
        $loans = (clone $loansQuery)
            ->latest()
            ->get();

        $totalRepaid = $member->loans()
            ->with('repayments')
            ->get()
            ->sum(function ($loan) {
                return $loan->repayments
                    ->where('paid', true)
                    ->sum('amount');
            });

        // ✅ Loan balance
        $loanBalance = $totalBorrowed - $totalRepaid;

        /*
        |-------------------------------
        | 🧾 TRANSACTIONS
        |-------------------------------
        */
        $transactions = Transaction::whereHas('account', function ($q) use ($member) {
                $q->where('member_id', $member->id);
            })
            ->latest('transacted_at')
            ->limit(5)
            ->get();

        /*
        |-------------------------------
        | 📊 MONTHLY CHART
        |-------------------------------
        */
        $monthlyTransactions = Transaction::select(
                DB::raw('MONTH(transacted_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->whereHas('account', function ($q) use ($member) {
                $q->where('member_id', $member->id);
            })
            ->groupBy(DB::raw('MONTH(transacted_at)'))
            ->pluck('total', 'month');

        /*
        |-------------------------------
        | 🚀 RETURN VIEW
        |-------------------------------
        */
        return view('dashboard.user', [
            'balance' => $savings,
            'savings' => $savings,
            'loansCount' => $loansCount,
            'activeLoans' => $activeLoans,
            'totalBorrowed' => $totalBorrowed,
            'totalRepaid' => $totalRepaid,
            'loanBalance' => $loanBalance,
            'transactions' => $transactions,
            'loans' => $loans, // ✅ FIX
            'monthlyTransactions' => $monthlyTransactions,
        ]);
    }
}