<x-dashboard-layout title="Peminjaman">
    <div class="bg-white rounded-2xl shadow-sm border p-5">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" placeholder="Filter pencarian..." class="border rounded-lg px-3 py-2">
                <button class="px-4 py-2 bg-slate-800 text-white rounded-lg">Cari</button>
            </form>

            @if(auth()->user()->role === 'peminjam')
                <a href="{{ route('peminjaman.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Ajukan
                    Peminjaman</a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 border text-left">No.</th>
                        <th class="px-4 py-3 border text-left">No Peminjaman</th>
                        <th class="px-4 py-3 border text-left">Peminjam</th>
                        <th class="px-4 py-3 border text-left">Jurusan Tujuan</th>
                        <th class="px-4 py-3 border text-left">Tanggal Pinjam</th>
                        <th class="px-4 py-3 border text-left">Rencana Kembali</th>
                        <th class="px-4 py-3 border text-left">Status</th>
                        <th class="px-4 py-3 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $index => $item)
                        <tr>
                            <td class="px-4 py-3 border">{{ $peminjamans->firstItem() + $index }}</td>
                            <td class="px-4 py-3 border">{{ $item->no_peminjaman }}</td>
                            <td class="px-4 py-3 border">{{ $item->user->name ?? auth()->user()->name }}</td>
                            <td class="px-4 py-3 border">{{ $item->jurusanTujuan->nama ?? '-' }}</td>
                            <td class="px-4 py-3 border">{{ $item->tanggal_pinjam }}</td>
                            <td class="px-4 py-3 border">{{ $item->tanggal_rencana_kembali }}</td>
                            <td class="px-4 py-3 border">{{ ucfirst($item->status) }}</td>
                            <td class="px-4 py-3 border">
                                <div class="flex gap-2 flex-wrap">
                                    @if($item->status === 'menunggu' && auth()->user()->role !== 'peminjam')
                                        <form action="{{ route('peminjaman.approve', $item) }}" method="POST">
                                            @csrf
                                            <button class="px-3 py-1 bg-green-600 text-white rounded">Approve</button>
                                        </form>

                                        <form action="{{ route('peminjaman.reject', $item) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="alasan_penolakan" value="Ditolak oleh admin">
                                            <button class="px-3 py-1 bg-red-600 text-white rounded">Tolak</button>
                                        </form>
                                    @endif

                                    @if($item->status === 'dipinjam')
                                        <a href="{{ route('peminjaman.print', $item) }}" target="_blank"
                                            class="px-3 py-1 bg-blue-600 text-white rounded">
                                            Print
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 border text-center text-slate-500">Belum ada data peminjaman.
                            </td>
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