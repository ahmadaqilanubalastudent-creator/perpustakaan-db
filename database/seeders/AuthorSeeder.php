<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            'Pramoedya Ananta Toer',
            'Andrea Hirata',
            'Tere Liye',
            'Eka Kurniawan',
            'Dee Lestari',
        ];

        foreach ($authors as $name) {
            Author::create(['name' => $name]);
        }
    }
}