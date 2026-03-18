<x-dashboard-layout title="Pengembalian">
    <div class="bg-white rounded-2xl shadow-sm border p-5">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 border text-left">No.</th>
                        <th class="px-4 py-3 border text-left">No Peminjaman</th>
                        <th class="px-4 py-3 border text-left">Peminjam</th>
                        <th class="px-4 py-3 border text-left">Rencana Kembali</th>
                        <th class="px-4 py-3 border text-left">Status Telat</th>
                        <th class="px-4 py-3 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $index => $item)
                        <tr>
                            <td class="px-4 py-3 border">{{ $peminjamans->firstItem() + $index }}</td>
                            <td class="px-4 py-3 border">{{ $item->no_peminjaman }}</td>
                            <td class="px-4 py-3 border">{{ $item->user->name }}</td>
                            <td class="px-4 py-3 border">{{ $item->tanggal_rencana_kembali }}</td>
                            <td class="px-4 py-3 border">
                                {{ now()->toDateString() > $item->tanggal_rencana_kembali ? 'Terlambat' : 'Belum Telat' }}
                            </td>
                            <td class="px-4 py-3 border">
                                <form action="{{ route('pengembalian.kembalikan', $item) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                                    @csrf
                                    <input type="file" name="foto_pengembalian" required class="text-sm">
                                    <button class="px-3 py-1 bg-blue-600 text-white rounded">Kembalikan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 border text-center text-slate-500">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $peminjamans->links() }}
        </div>
    </div>
</x-dashboard-layout>