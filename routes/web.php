<?php

use Illuminate\Support\Facades\Route;
use App\Models\Member;
use Illuminate\Http\Request;

use App\Http\Controllers\{
    AccountController,
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
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {

        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return app(DashboardController::class)->index();

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | USER FEATURES
    |--------------------------------------------------------------------------
    */

    // WALLET (NEW 🔥)
    Route::get('/wallet', [DashboardController::class, 'wallet'])
        ->name('wallet');


    // TRANSACTIONS
    Route::resource('transactions', TransactionController::class)
        ->only(['index', 'create', 'store']);


    // SAVINGS
    Route::get('/savings/create', function () {
        return view('savings.create', [
            'members' => Member::all()
        ]);
    })->name('savings.create');

    Route::post('/savings', function (Request $request) {

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:1',
        ]);

        \App\Models\Account::create([
            'member_id' => $request->member_id,
            'type' => 'savings',
            'balance' => $request->amount,
        ]);

        return redirect()->route('wallet')
            ->with('success', 'Savings added successfully');

    })->name('savings.store');


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

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        // MEMBERS (ADMIN ONLY)
        Route::resource('members', MemberController::class);

        // LOANS (FULL CONTROL)
        Route::resource('loans', LoanController::class);

        Route::post('loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
        Route::post('loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
        Route::post('loans/{loan}/disburse', [LoanController::class, 'disburse'])->name('loans.disburse');
        Route::post('loans/{loan}/repayments', [LoanController::class, 'repay'])->name('loans.repayments.store');

        // LOAN PRODUCTS
        Route::resource('loan-products', LoanProductController::class)->except(['show']);
    });


require __DIR__.'/auth.php';