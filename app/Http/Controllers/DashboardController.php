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
                'loans' => collect(),
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

        // ✅ Active loans (match your Blade)
        $activeLoans = (clone $loansQuery)
            ->whereIn('status', ['approved', 'active'])
            ->count();

        // ✅ FIXED: use principal
        $totalBorrowed = (clone $loansQuery)->sum('principal');

        // Full loans list (for Blade)
        $loans = (clone $loansQuery)
            ->latest()
            ->get();

        // ✅ Total repaid from repayments table
        $totalRepaid = $member->loans()
            ->with('repayments')
            ->get()
            ->sum(function ($loan) {
                return $loan->repayments
                    ->where('paid', true)
                    ->sum('amount');
            });

        // ✅ Loan balance (remaining)
        $loanBalance = $totalBorrowed - $totalRepaid;

        /*
        |-------------------------------
        | 🧾 TRANSACTIONS
        |-------------------------------
        */
        $transactions = Transaction::whereHas('account', function ($q) use ($member) {
                $q->where('member_id', $member->id);
            })
            ->latest() // safer than transacted_at unless column exists
            ->limit(5)
            ->get();

        /*
        |-------------------------------
        | 📊 MONTHLY CHART
        |-------------------------------
        */
        $monthlyTransactions = Transaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->whereHas('account', function ($q) use ($member) {
                $q->where('member_id', $member->id);
            })
            ->groupBy(DB::raw('MONTH(created_at)'))
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
            'loans' => $loans,
            'monthlyTransactions' => $monthlyTransactions,
        ]);
    }
}