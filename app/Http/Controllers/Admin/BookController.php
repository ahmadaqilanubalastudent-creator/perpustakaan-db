<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author', 'category')->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('admin.books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        // Handle "tambah baru" SEBELUM validasi, supaya author_id/category_id
        // sudah berupa UUID valid saat divalidasi.
        if ($request->author_id === 'new' && $request->filled('new_author_name')) {
            $author = Author::create(['name' => $request->new_author_name]);
            $request->merge(['author_id' => $author->id]);
        }

        if ($request->category_id === 'new' && $request->filled('new_category_name')) {
            $category = Category::create([
                'name' => $request->new_category_name,
                'slug' => Str::slug($request->new_category_name),
            ]);
            $request->merge(['category_id' => $category->id]);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:50'],
            'author_id' => ['required', 'exists:authors,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'stock' => ['required', 'integer', 'min:0'],
            'synopsis' => ['required', 'string'],
            'cover_image' => ['required', 'image', 'max:2048'],
        ], [
            'isbn.required' => 'ISBN wajib diisi.',
            'synopsis.required' => 'Sinopsis wajib diisi.',
            'cover_image.required' => 'Cover buku wajib diupload.',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        if ($request->author_id === 'new' && $request->filled('new_author_name')) {
            $author = Author::create(['name' => $request->new_author_name]);
            $request->merge(['author_id' => $author->id]);
        }

        if ($request->category_id === 'new' && $request->filled('new_category_name')) {
            $category = Category::create([
                'name' => $request->new_category_name,
                'slug' => Str::slug($request->new_category_name),
            ]);
            $request->merge(['category_id' => $category->id]);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:50'],
            'author_id' => ['required', 'exists:authors,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'stock' => ['required', 'integer', 'min:0'],
            'synopsis' => ['required', 'string'],
            // Cover boleh tidak diubah saat edit (kalau tidak upload baru, cover lama dipertahankan)
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ], [
            'isbn.required' => 'ISBN wajib diisi.',
            'synopsis.required' => 'Sinopsis wajib diisi.',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image_path) {
                Storage::disk('public')->delete($book->cover_image_path);
            }
            $data['cover_image_path'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image_path) {
            Storage::disk('public')->delete($book->cover_image_path);
        }
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}