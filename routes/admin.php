<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('books', AdminBookController::class);
    Route::get('loans', [AdminLoanController::class, 'index'])->name('loans.index');
    Route::patch('loans/{loan}/approve', [AdminLoanController::class, 'approve'])->name('loans.approve');
    Route::patch('loans/{loan}/reject', [AdminLoanController::class, 'reject'])->name('loans.reject');
    Route::patch('loans/{loan}/return', [AdminLoanController::class, 'returnBook'])->name('loans.return');
});