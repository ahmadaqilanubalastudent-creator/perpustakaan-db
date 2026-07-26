<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('user', 'book')->latest()->paginate(15);
        return view('admin.loans.index', compact('loans'));
    }

    public function approve(Loan $loan)
    {
        $loan->update([
            'status' => 'disetujui',
            'borrowed_at' => now(),
            'due_at' => now()->addDays(7),
        ]);

        $loan->book->decrement('stock');

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject(Loan $loan)
    {
        $loan->update(['status' => 'ditolak']);

        return back()->with('success', 'Peminjaman ditolak.');
    }
}