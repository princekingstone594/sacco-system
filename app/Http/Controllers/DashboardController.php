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
}