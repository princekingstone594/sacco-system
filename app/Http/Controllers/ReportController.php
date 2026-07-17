<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Loan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MAIN REPORT PAGE (THIS FIXES /reports ROUTE)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $totalSavings = Account::sum('balance');
        $totalLoans = Loan::sum('loanm_amount');
        $totalRepaid = Transaction::where('type', 'loan_repayment')->sum('amount');
        $totalDeposits = Transaction::where('type', 'deposit')->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');

        return view('reports.index', compact(
            'totalSavings',
            'totalLoans',
            'totalRepaid',
            'totalDeposits',
            'totalWithdrawals'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD SUMMARY (OPTIONAL PAGE)
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

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */
    public function exportPdf()
    {
        $data = [
            'totalSavings' => Account::sum('balance'),
            'transactions' => Transaction::latest()->get()
        ];

        $pdf = Pdf::loadView('reports.pdf', $data);

        return $pdf->download('report.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL (NEW)
    |--------------------------------------------------------------------------
    */
    public function exportExcel()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }
}