<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Katalog Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Slider Informasi -->
            <div
                x-data="{
                    slides: [
                        { title: 'Selamat Datang di HobbyBaca', text: 'Temukan ribuan judul buku favoritmu di sini.' },
                        { title: 'Jam Operasional', text: 'Senin - Sabtu, pukul 08:00 - 20:00 WIB.' },
                        { title: 'Aturan Peminjaman', text: 'Maksimal peminjaman 7 hari, perpanjangan bisa dilakukan lewat halaman Buku Dipinjam.' },
                    ],
                    current: 0,
                    interval: null,
                    next() { this.current = (this.current + 1) % this.slides.length },
                    prev() { this.current = (this.current - 1 + this.slides.length) % this.slides.length },
                }"
                x-init="interval = setInterval(() => next(), 5000)"
                class="relative mb-8 bg-gray-800 rounded-lg overflow-hidden text-white"
            >
                <div class="px-6 py-8 sm:px-10 sm:py-10 min-h-[140px] flex flex-col justify-center">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="current === index" x-transition.opacity.duration.500ms>
                            <h3 class="text-xl sm:text-2xl font-semibold mb-2" x-text="slide.title"></h3>
                            <p class="text-gray-300 text-sm sm:text-base" x-text="slide.text"></p>
                        </div>
                    </template>
                </div>

                <!-- Nav buttons -->
                <button @click="prev()" class="absolute left-2 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white/10 hover:bg-white/20 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white/10 hover:bg-white/20 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>

                <!-- Dots -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="current = index"
                                class="w-2 h-2 rounded-full transition"
                                :class="current === index ? 'bg-white' : 'bg-white/40'">
                        </button>
                    </template>
                </div>
            </div>

            <form method="GET" class="mb-6 flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari judul buku..."
                       class="border-gray-300 rounded-lg w-full max-w-sm">

                <select name="category_id" class="border-gray-300 rounded-lg">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg">Cari</button>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($books as $book)
                    <a href="{{ route('books.show', $book) }}"
                       class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition">
                        <div class="aspect-[3/4] bg-gray-100">
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
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-1">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $book->author->name }} &middot; {{ $book->category->name }}</p>

                            @if ($book->stock > 0)
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                    Tersedia ({{ $book->stock }})
                                </span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                    Tidak tersedia
                                </span>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 col-span-3">Belum ada buku.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $books->links() }}
            </div>

        </div>
    </div>
</x-app-layout>