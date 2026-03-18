<x-dashboard-layout title="Riwayat">
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

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <form method="GET" action="{{ route('riwayat.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter pencarian..."
                    class="border rounded-lg px-3 py-2 w-full md:w-72">
                <button class="px-4 py-2 bg-slate-800 text-white rounded-lg">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 border text-left">No.</th>
                        <th class="px-4 py-3 border text-left">No Peminjaman</th>
                        <th class="px-4 py-3 border text-left">Peminjam</th>
                        <th class="px-4 py-3 border text-left">Jurusan Tujuan</th>
                        <th class="px-4 py-3 border text-left">Status</th>
                        <th class="px-4 py-3 border text-left">Keterlambatan</th>
                        <th class="px-4 py-3 border text-left">Tanggal Kembali</th>
                        @if(auth()->user()->role !== 'peminjam')
                            <th class="px-4 py-3 border text-left">Aksi</th>
                        @endif
                        <th class="px-4 py-3 border text-left">Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayats as $index => $item)
                                        <tr>
                                            <td class="px-4 py-3 border">{{ $riwayats->firstItem() + $index }}</td>
                                            <td class="px-4 py-3 border">{{ $item->no_peminjaman }}</td>
                                            <td class="px-4 py-3 border">{{ $item->user->name ?? '-' }}</td>
                                            <td class="px-4 py-3 border">{{ $item->jurusanTujuan->nama ?? '-' }}</td>
                                            <td class="px-4 py-3 border">
                                                <span class="px-2 py-1 text-xs rounded 
                            {{ $item->status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $item->status == 'dipinjam' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $item->status == 'dikembalikan' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $item->status == 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                        ">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{ str_replace('_', ' ', ucfirst($item->status_keterlambatan ?? '-')) }}
                                            </td>
                                            <td class="px-4 py-3 border">{{ $item->tanggal_kembali ?? '-' }}</td>
                                            @if(auth()->user()->role !== 'peminjam')
                                                <td class="px-4 py-3 border">
                                                    <form action="{{ route('riwayat.destroy', $item) }}" method="POST"
                                                        onsubmit="return confirm('Yakin hapus riwayat ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                                    </form>
                                                </td>
                                                <td class="px-4 py-3 border">
                                                    @if($item->foto_pengembalian)
                                                        <img src="{{ asset('storage/' . $item->foto_pengembalian) }}"
                                                            class="w-16 h-16 object-cover rounded">
                                                    @elseif($item->foto_peminjaman)
                                                        <img src="{{ asset('storage/' . $item->foto_peminjaman) }}"
                                                            class="w-16 h-16 object-cover rounded">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role !== 'peminjam' ? 8 : 7 }}"
                                class="px-4 py-4 border text-center text-slate-500">
                                Belum ada data riwayat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $riwayats->links() }}
        </div>
    </div>
</x-dashboard-layout>