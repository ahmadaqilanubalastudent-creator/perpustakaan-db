<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Tambah Buku</h1>

    <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data"
          class="bg-white rounded-lg shadow p-6 max-w-xl space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-lg">
            @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">ISBN</label>
            <input type="text" name="isbn" value="{{ old('isbn') }}" class="w-full border-gray-300 rounded-lg">
        </div>

        <div x-data="{ newAuthor: false }">
    <label class="block text-sm font-medium mb-1">Penulis</label>
    <select name="author_id" x-show="!newAuthor" @change="newAuthor = ($event.target.value === 'new')" class="w-full border-gray-300 rounded-lg">
        @foreach ($authors as $author)
            <option value="{{ $author->id }}">{{ $author->name }}</option>
        @endforeach
        <option value="new">+ Tambah penulis baru</option>
    </select>
    <template x-if="newAuthor">
        <div class="flex gap-2 mt-1">
            <input type="text" name="new_author_name" placeholder="Nama penulis baru" class="w-full border-gray-300 rounded-lg">
            <button type="button" @click="newAuthor = false" class="text-sm text-gray-500 whitespace-nowrap">Batal</button>
        </div>
    </template>
    @error('author_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

       <div x-data="{ newCategory: false }">
    <label class="block text-sm font-medium mb-1">Kategori</label>
    <select name="category_id" x-show="!newCategory" @change="newCategory = ($event.target.value === 'new')" class="w-full border-gray-300 rounded-lg">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
        @endforeach
        <option value="new">+ Tambah kategori baru</option>
    </select>
    <template x-if="newCategory">
        <div class="flex gap-2 mt-1">
            <input type="text" name="new_category_name" placeholder="Nama kategori baru" class="w-full border-gray-300 rounded-lg">
            <button type="button" @click="newCategory = false" class="text-sm text-gray-500 whitespace-nowrap">Batal</button>
        </div>
    </template>
    @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

        <div>
            <label class="block text-sm font-medium mb-1">Stok</label>
            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" class="w-full border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Sinopsis</label>
            <textarea name="synopsis" rows="4" class="w-full border-gray-300 rounded-lg">{{ old('synopsis') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Cover Buku</label>
            <input type="file" name="cover_image" accept="image/*" class="w-full">
            @error('cover_image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg">Simpan</button>
    </form>
</x-admin-layout>