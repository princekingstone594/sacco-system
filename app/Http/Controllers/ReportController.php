<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Loan;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD SUMMARY (FINANCIAL OVERVIEW)
    |--------------------------------------------------------------------------
    */
    public function summary()
    {
        $totalSavings = Account::sum('balance');

        $totalLoans = Loan::where('status', 'approved')->sum('amount');

        $totalRepaid = Transaction::where('type', 'loan_repayment')->sum('amount');

        $totalDeposits = Transaction::where('type', 'deposit')->sum('amount');

        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');

        return view('reports.summary', compact(
            'totalSavings',
            'totalLoans',
            'totalRepaid',
            'totalDeposits',
            'totalWithdrawals'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | LOAN REPORT
    |--------------------------------------------------------------------------
    */
    public function loans()
    {
        $loans = Loan::with('member')->latest()->get();

        return view('reports.loans', compact('loans'));
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSACTION REPORT
    |--------------------------------------------------------------------------
    */
    public function transactions()
    {
        $transactions = Transaction::with('member')->latest()->get();

        return view('reports.transactions', compact('transactions'));
    }
}