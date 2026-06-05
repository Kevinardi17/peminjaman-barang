<x-dashboard-layout title="Barang">
    <div class="bg-white rounded-2xl shadow-sm border p-5">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <form method="GET" action="{{ route('barang.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter pencarian..." class="border rounded-lg px-3 py-2 w-full md:w-72">
                <button class="px-4 py-2 bg-slate-800 text-white rounded-lg">Cari</button>
            </form>

            <a href="{{ route('barang.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                + Tambah Barang
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 border text-left">No.</th>
                        <th class="px-4 py-3 border text-left">Foto</th>
                        <th class="px-4 py-3 border text-left">Kode</th>
                        <th class="px-4 py-3 border text-left">Jurusan</th>
                        <th class="px-4 py-3 border text-left">Nama Barang</th>
                        <th class="px-4 py-3 border text-left">Tersedia</th>
                        <th class="px-4 py-3 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $index => $barang)
                        @php
                            $dipinjam = \App\Models\DetailPeminjaman::where('barang_id', $barang->id)
                                ->whereHas('peminjaman', function($q) {
                                    $q->where('status', 'dipinjam');
                                })->sum('jumlah');
                            $tersedia = $barang->stok - $dipinjam;
                        @endphp
                        <tr>
                            <td class="px-4 py-3 border">{{ $barangs->firstItem() + $index }}</td>
                            <td class="px-4 py-3 border">
                                @if($barang->foto)
                                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto" class="w-10 h-10 object-cover rounded">
                                @else
                                    <span class="text-xs text-slate-400">No img</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border">{{ $barang->kode_barang }}</td>
                            <td class="px-4 py-3 border">{{ $barang->jurusan->nama }}</td>
                            <td class="px-4 py-3 border">
                                <a href="{{ route('barang.history', $barang) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ $barang->nama_barang }}
                                </a>
                            </td>
                            <td class="px-4 py-3 border">{{ $tersedia }}</td>
                            <td class="px-4 py-3 border">
                                <div class="flex gap-2 text-sm">
                                    <a href="{{ route('barang.show', $barang) }}" class="px-3 py-1 bg-slate-800 text-white rounded hover:bg-slate-700">Detail</a>
                                    <a href="{{ route('barang.edit', $barang) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                                    <form action="{{ route('barang.destroy', $barang) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 border text-center text-slate-500">Data barang belum ada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $barangs->links() }}
        </div>
    </div>
</x-dashboard-layout>