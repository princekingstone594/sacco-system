<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AccountController,
    DashboardController,
    CustomerCareInquiryController,
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
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (IMPORTANT)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('members', MemberController::class);
    Route::resource('accounts', AccountController::class)->only(['index', 'show']);
    Route::resource('loans', LoanController::class);
    Route::post('/loans/{loan}/repayments', [LoanController::class, 'repay'])->name('loans.repayments.store');
    Route::resource('loan-products', LoanProductController::class);
    Route::resource('transactions', TransactionController::class);

    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/customer-care', [CustomerCareInquiryController::class, 'create'])->name('customer-care.create');
    Route::post('/customer-care', [CustomerCareInquiryController::class, 'store'])->name('customer-care.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/reports/pdf', [ReportController::class, 'downloadPdf'])->name('reports.pdf');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/customer-care', [CustomerCareInquiryController::class, 'index'])->name('admin.customer-care.index');
    Route::get('/admin/customer-care/{inquiry}', [CustomerCareInquiryController::class, 'show'])->name('admin.customer-care.show');
    Route::patch('/admin/customer-care/{inquiry}', [CustomerCareInquiryController::class, 'update'])->name('admin.customer-care.update');
});
