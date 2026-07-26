<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $loans = $request->user()->loans()->with('book')->latest()->get();

        return view('loans.index', compact('loans'));
    }

    public function store(Request $request, Book $book)
    {
        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        Loan::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'status' => 'menunggu_persetujuan',
        ]);

        return back()->with('success', 'Peminjaman diajukan, menunggu persetujuan admin.');
    }
}