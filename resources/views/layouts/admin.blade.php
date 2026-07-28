<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-56 bg-gray-800 text-white shrink-0">
            <div class="p-4 border-b border-gray-700">
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo-icon.svg') }}" alt="HobbyBaca" class="h-8 w-8">
                    <span class="font-bold text-lg">{{ config('app.name') }}</span>
                </a>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.books.index') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.books.*') ? 'bg-gray-700' : '' }}">
                    Kelola Buku
                </a>
                <a href="{{ route('admin.loans.index') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.loans.*') ? 'bg-gray-700' : '' }}">
                    Peminjaman
                </a>
                <a href="{{ route('home') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-700 mt-4 border-t border-gray-700 pt-4">
                    Lihat Katalog
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-gray-700">
                        Log Out
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>