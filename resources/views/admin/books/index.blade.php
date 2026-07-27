<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kelola Buku</h1>
        <a href="{{ route('admin.books.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg">
            + Tambah Buku
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Cover</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr class="border-t">
                        <td class="px-4 py-3">
                            <div class="w-12 h-16 bg-gray-100 rounded overflow-hidden">
                                @if ($book->cover_image_path)
                                    <img src="{{ Storage::url($book->cover_image_path) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $book->title }}</td>
                        <td class="px-4 py-3">{{ $book->author->name }}</td>
                        <td class="px-4 py-3">{{ $book->category->name }}</td>
                        <td class="px-4 py-3">{{ $book->stock }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.books.edit', $book) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="inline"
      onsubmit="return confirm('Yakin hapus buku &quot;{{ $book->title }}&quot;?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $books->links() }}</div>
</x-admin-layout>