<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1">Total Buku</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_books'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1">Total Peminjaman</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_loans'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1">Menunggu Persetujuan</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1">Sedang Dipinjam</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['active'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1">Terlambat</div>
            <div class="text-2xl font-bold text-orange-600">{{ $stats['overdue'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1">Sudah Dikembalikan</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['returned'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1">Total Penulis</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_authors'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1">Total Kategori</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_categories'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Buku Terpopuler -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 font-semibold text-gray-700">
                Buku Terpopuler
            </div>
            <table class="w-full text-sm text-left">
                <tbody>
                    @forelse ($popularBooks as $book)
                        <tr class="border-t">
                            <td class="px-5 py-3">{{ $book->title }}</td>
                            <td class="px-5 py-3 text-right text-gray-500">{{ $book->loans_count }}x dipinjam</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-5 py-3 text-gray-400">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Stok Menipis -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 font-semibold text-gray-700">
                Stok Menipis
            </div>
            <table class="w-full text-sm text-left">
                <tbody>
                    @forelse ($lowStockBooks as $book)
                        <tr class="border-t">
                            <td class="px-5 py-3">{{ $book->title }}</td>
                            <td class="px-5 py-3 text-right">
                                <span class="px-2 py-1 text-xs rounded {{ $book->stock == 0 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }}">
                                    Stok: {{ $book->stock }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-5 py-3 text-gray-400">Semua stok aman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 font-semibold text-gray-700">
            Aktivitas Peminjaman Terbaru
        </div>
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-5 py-3">Anggota</th>
                    <th class="px-5 py-3">Buku</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentLoans as $loan)
                    @php
                        $badgeColor = match ($loan->status) {
                            'menunggu_persetujuan' => 'bg-yellow-100 text-yellow-700',
                            'disetujui' => 'bg-blue-100 text-blue-700',
                            'ditolak' => 'bg-red-100 text-red-700',
                            'dikembalikan' => 'bg-green-100 text-green-700',
                            'terlambat' => 'bg-orange-100 text-orange-700',
                            default => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <tr class="border-t">
                        <td class="px-5 py-3">{{ $loan->user->name }}</td>
                        <td class="px-5 py-3">{{ $loan->book->title }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 text-xs rounded {{ $badgeColor }}">
                                {{ str_replace('_', ' ', $loan->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-5 py-3 text-gray-400" colspan="3">Belum ada aktivitas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>