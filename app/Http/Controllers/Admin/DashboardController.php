<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_authors' => Author::count(),
            'total_categories' => Category::count(),
            'total_loans' => Loan::count(),
            'pending' => Loan::where('status', 'menunggu_persetujuan')->count(),
            'active' => Loan::whereIn('status', ['disetujui', 'terlambat'])->count(),
            'overdue' => Loan::where('status', 'terlambat')->count(),
            'returned' => Loan::where('status', 'dikembalikan')->count(),
        ];

        $popularBooks = Book::withCount('loans')
            ->orderByDesc('loans_count')
            ->take(5)
            ->get();

        $lowStockBooks = Book::where('stock', '<=', 2)
            ->orderBy('stock')
            ->take(5)
            ->get();

        $recentLoans = Loan::with('user', 'book')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'popularBooks', 'lowStockBooks', 'recentLoans'));
    }
}