<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'memberCount' => Member::count(),
            'activeMemberCount' => Member::where('status', 'active')->count(),
            'totalSavings' => Account::whereIn('type', ['savings', 'deposits'])->sum('balance'),
            'totalShares' => Account::where('type', 'shares')->sum('balance'),
            'loanPortfolio' => Loan::sum('balance'),
            'activeLoans' => Loan::where('status', 'active')->count(),
            'recentTransactions' => Transaction::with(['member', 'account'])
                ->latest('transacted_at')
                ->latest()
                ->take(8)
                ->get(),
            'recentLoans' => Loan::with(['member', 'product'])
                ->latest('issued_on')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
