<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $anggota = User::where('role', 'anggota')->first();
        $books = Book::all();

        // 1. Peminjaman yang masih menunggu persetujuan admin
        Loan::create([
            'user_id' => $anggota->id,
            'book_id' => $books->random()->id,
            'status' => 'menunggu_persetujuan',
        ]);

        // 2. Peminjaman yang sudah disetujui & sedang berjalan
        Loan::create([
            'user_id' => $anggota->id,
            'book_id' => $books->random()->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(7),
            'status' => 'disetujui',
        ]);

        // 3. Peminjaman yang sudah selesai dikembalikan
        Loan::create([
            'user_id' => $anggota->id,
            'book_id' => $books->random()->id,
            'borrowed_at' => now()->subDays(10),
            'due_at' => now()->subDays(3),
            'returned_at' => now()->subDays(2),
            'status' => 'dikembalikan',
        ]);
    }
}