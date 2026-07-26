<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
    <div class="flex gap-6 mb-6">
        <div class="w-40 aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden shrink-0">
            @if ($book->cover_image_path)
                <img src="{{ Storage::url($book->cover_image_path) }}"
                     alt="{{ $book->title }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                    Tanpa cover
                </div>
            @endif
        </div>
        <div>
            <h1 class="text-2xl font-bold mb-2">{{ $book->title }}</h1>
            <p class="text-gray-500 mb-4">{{ $book->author->name }} &middot; {{ $book->category->name }}</p>
        </div>
    </div>
                <p class="mb-6">{{ $book->synopsis ?? 'Belum ada sinopsis.' }}</p>

                <p class="mb-4">Stok: <strong>{{ $book->stock }}</strong></p>

                @auth
                    @if ($book->stock > 0)
                        <form method="POST" action="{{ route('loans.store', $book) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg">
                                Ajukan Peminjaman
                            </button>
                        </form>
                    @else
                        <span class="text-red-600">Stok habis, tidak bisa dipinjam.</span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 underline">Login dulu untuk meminjam</a>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>