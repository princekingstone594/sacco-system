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
    | MAIN REPORT PAGE (/reports)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $totalSavings = Account::sum('balance');

        // Total loans issued
        $totalLoans = Loan::sum('principal');

        // Active loans count
        $activeLoans = Loan::where('status', 'active')->count();

        // ✅ IMPORTANT: match Blade variable name
        $repaidLoans = Transaction::where('type', 'loan_repayment')->sum('amount');

        $totalDeposits = Transaction::where('type', 'deposit')->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');

        $transactionCount = Transaction::count();

        return view('reports.index', compact(
            'totalSavings',
            'totalLoans',
            'activeLoans',
            'repaidLoans', 
            'totalDeposits',
            'totalWithdrawals',
            'transactionCount'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD SUMMARY
    |--------------------------------------------------------------------------
    */
    public function summary()
    {
        $totalSavings = Account::sum('balance');

        // Only active loans total
        $totalLoans = Loan::where('status', 'active')->sum('principal');

        $activeLoans = Loan::where('status', 'active')->count();

        // ✅ keep naming consistent everywhere
        $repaidLoans = Transaction::where('type', 'loan_repayment')->sum('amount');

        $totalDeposits = Transaction::where('type', 'deposit')->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');

        return view('reports.summary', compact(
            'totalSavings',
            'totalLoans',
            'activeLoans',
            'repaidLoans',
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
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function exportExcel()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }

    public function downloadPdf()
    {
        return "PDF download coming soon...";
    }
}