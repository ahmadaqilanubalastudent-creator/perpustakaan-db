<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Kelola Peminjaman</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Anggota</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $loan->user->name }}</td>
                        <td class="px-4 py-3">{{ $loan->book->title }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs bg-gray-100 rounded">{{ str_replace('_', ' ', $loan->status) }}</span>
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            @if ($loan->status === 'menunggu_persetujuan')
                                <form method="POST" action="{{ route('admin.loans.approve', $loan) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-green-600">Setujui</button>
                                </form>
                                <form method="POST" action="{{ route('admin.loans.reject', $loan) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-red-600">Tolak</button>
                                </form>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $loans->links() }}</div>
</x-admin-layout>