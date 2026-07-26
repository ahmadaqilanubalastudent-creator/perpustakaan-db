<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('/books/{book}/pinjam', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/pinjaman-saya', [LoanController::class, 'index'])->name('loans.index');

    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');
});

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';

Route::get('/debug-set-admin', function () {
    $user = \App\Models\User::where('email', 'admin@perpustakaan.test')->first();
    $user->role = 'admin';
    $user->save();
    return $user;
});