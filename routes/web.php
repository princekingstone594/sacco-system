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
    | MEMBER DASHBOARD (ONLY USER DATA)
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
    | USER LOANS (PERSONAL)
    |--------------------------------------------------------------------------
    */
    Route::get('/my-loans', [LoanController::class, 'myLoans'])
        ->name('loans.my');


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
        | MEMBERS MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::resource('members', MemberController::class);


        /*
        |--------------------------------------------------------------------------
        | LOANS MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::resource('loans', LoanController::class)
              ->names('admin.loans');

        Route::post('loans/{loan}/approve', [LoanController::class, 'approve'])
            ->name('loans.approve');

        Route::post('loans/{loan}/reject', [LoanController::class, 'reject'])
            ->name('loans.reject');

        Route::post('loans/{loan}/disburse', [LoanController::class, 'disburse'])
            ->name('loans.disburse');

        Route::post('loans/{loan}/repayments', [LoanController::class, 'repay'])
            ->name('loans.repayments.store');


        /*
        |--------------------------------------------------------------------------
        | LOAN PRODUCTS
        |--------------------------------------------------------------------------
        */
        Route::resource('loan-products', LoanProductController::class)
            ->except(['show']);
    });


require __DIR__.'/auth.php';