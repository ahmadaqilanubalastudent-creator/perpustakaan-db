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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('/books/{book}/pinjam', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/pinjaman-saya', [LoanController::class, 'index'])->name('loans.index');
});

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';

Route::get('/debug-create-admin', function () {
    return \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@perpustakaan.test',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);
});