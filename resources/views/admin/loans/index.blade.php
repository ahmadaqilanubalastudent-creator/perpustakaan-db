<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Kelola Peminjaman</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Anggota</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Jatuh Tempo</th>
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
                            {{ $loan->due_at ? $loan->due_at->format('d M Y') : '-' }}
                        </td>
                        <td class="px-4 py-3">
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
                            <span class="px-2 py-1 text-xs rounded {{ $badgeColor }}">
                                {{ str_replace('_', ' ', $loan->status) }}
                            </span>
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
                            @elseif (in_array($loan->status, ['disetujui', 'terlambat']))
                                <form method="POST" action="{{ route('admin.loans.return', $loan) }}" class="inline"
                                      onsubmit="return confirm('Tandai buku &quot;{{ $loan->book->title }}&quot; sebagai dikembalikan?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-blue-600">Tandai Dikembalikan</button>
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