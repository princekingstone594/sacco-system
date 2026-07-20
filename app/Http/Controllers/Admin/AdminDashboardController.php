<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Transaction;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'membersCount' => Member::count(),
            'totalSavings' => Account::sum('balance'),
            'activeLoans' => Loan::whereIn('status', ['approved', 'active'])->count(),
            'pendingLoans' => Loan::where('status', 'pending')->count(),
            'recentTransactions' => Transaction::with(['account.member', 'postedBy'])
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
