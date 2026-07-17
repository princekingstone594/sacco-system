<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\{
    DashboardController,
    LoanController,
    LoanProductController,
    MemberController,
    ProfileController,
    TransactionController,
    ReportController,
    WalletController
};

use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('dashboard'));


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (MEMBERS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | WALLET (✅ FIXED: ONLY ONE ROUTE)
    |--------------------------------------------------------------------------
    */
    Route::get('/wallet', [WalletController::class, 'index'])
        ->name('wallet.index');


    /*
    |--------------------------------------------------------------------------
    | LOANS
    |--------------------------------------------------------------------------
    */
    Route::get('/loans', [LoanController::class, 'index'])
        ->name('loans.index');

    Route::post('/loans', [LoanController::class, 'store'])
        ->name('loans.store');


    /*
    |--------------------------------------------------------------------------
    | TRANSACTIONS
    |--------------------------------------------------------------------------
    */
    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');

    Route::post('/transactions/deposit', [TransactionController::class, 'deposit'])
        ->name('transactions.deposit');

    Route::post('/transactions/withdraw', [TransactionController::class, 'withdraw'])
        ->name('transactions.withdraw');


    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    
    Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])
    ->name('reports.pdf');

    Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    /*
    |--------------------------------------------------------------------------
    | LOGOUT (✅ FIXED NAME)
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    })->name('logout'); // ✅ FIXED HERE

});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        /*
        |--------------------------------------------------------------------------
        | LOANS
        |--------------------------------------------------------------------------
        */
        Route::resource('loans', LoanController::class)
            ->names('admin.loans');

        /*
        |--------------------------------------------------------------------------
        | LOAN PRODUCTS
        |--------------------------------------------------------------------------
        */
        Route::resource('loan-products', LoanProductController::class);

        /*
        |--------------------------------------------------------------------------
        | MEMBERS
        |--------------------------------------------------------------------------
        */
        Route::resource('members', MemberController::class);
    });