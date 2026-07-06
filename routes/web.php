<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('members', MemberController::class);
    Route::resource('accounts', AccountController::class)->only(['index', 'show']);
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store']);
    Route::resource('loan-products', LoanProductController::class)->except(['show']);
    Route::resource('loans', LoanController::class);
    Route::post('loans/{loan}/repayments', [LoanController::class, 'repay'])->name('loans.repayments.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
