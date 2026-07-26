<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $authors = Author::all();
        $categories = Category::all();

        $books = [
            ['title' => 'Bumi Manusia', 'stock' => 3],
            ['title' => 'Laskar Pelangi', 'stock' => 5],
            ['title' => 'Pulang', 'stock' => 2],
            ['title' => 'Cantik Itu Luka', 'stock' => 4],
            ['title' => 'Supernova', 'stock' => 1],
        ];

        foreach ($books as $index => $book) {
            Book::create([
                'title' => $book['title'],
                'author_id' => $authors->random()->id,
                'category_id' => $categories->random()->id,
                'stock' => $book['stock'],
            ]);
        }
    }
}