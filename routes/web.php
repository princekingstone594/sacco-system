<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    DashboardController,
    LoanController,
    LoanProductController,
    MemberController,
    ProfileController,
    TransactionController
};

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('dashboard'));


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (MEMBER)
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
    | WALLET
    |--------------------------------------------------------------------------
    */
    Route::get('/wallet', [DashboardController::class, 'wallet'])
        ->name('wallet');

    Route::post('/wallet/deposit', [TransactionController::class, 'deposit'])
        ->name('wallet.deposit');

    Route::post('/wallet/withdraw', [TransactionController::class, 'withdraw'])
        ->name('wallet.withdraw');


    /*
    |--------------------------------------------------------------------------
    | TRANSACTIONS
    |--------------------------------------------------------------------------
    */
    Route::resource('transactions', TransactionController::class)
        ->only(['index', 'create', 'store']);


    /*
    |--------------------------------------------------------------------------
    | SAVINGS
    |--------------------------------------------------------------------------
    */
    Route::get('/savings/create', [TransactionController::class, 'createSavings'])
        ->name('savings.create');

    Route::post('/savings', [TransactionController::class, 'storeSavings'])
        ->name('savings.store');


    /*
    |--------------------------------------------------------------------------
    | USER LOANS (CLEAN + CONSISTENT)
    |--------------------------------------------------------------------------
    */
    Route::get('/loans', [LoanController::class, 'index'])
        ->name('loans.index');

    Route::post('/loans', [LoanController::class, 'store'])
        ->name('loans.store');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
        | MEMBERS
        |--------------------------------------------------------------------------
        */
        Route::resource('members', MemberController::class);


        /*
        |--------------------------------------------------------------------------
        | LOANS (ADMIN CONTROL)
        |--------------------------------------------------------------------------
        */
        Route::resource('loans', AdminLoanController::class)
            ->names('admin.loans');

        Route::post('loans/{loan}/approve', [AdminLoanController::class, 'approve'])
            ->name('admin.loans.approve');

        Route::post('loans/{loan}/reject', [AdminLoanController::class, 'reject'])
            ->name('admin.loans.reject');

        Route::post('loans/{loan}/disburse', [AdminLoanController::class, 'disburse'])
            ->name('admin.loans.disburse');

        Route::post('loans/{loan}/repayments', [AdminLoanController::class, 'repay'])
            ->name('admin.loans.repayments.store');


        /*
        |--------------------------------------------------------------------------
        | LOAN PRODUCTS
        |--------------------------------------------------------------------------
        */
        Route::resource('loan-products', LoanProductController::class)
            ->except(['show']);
            
        Route::post('/notifications/read', function () {
            auth()->user()->unreadNotifications->markAsRead();
            return back();
        })->name('notifications.read');
    });


require __DIR__.'/auth.php';