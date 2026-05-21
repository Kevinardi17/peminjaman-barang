<x-dashboard-layout title="Barang">
    <div class="bg-white rounded-2xl shadow-sm border p-5">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <form method="GET" action="{{ route('barang.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter pencarian..." class="border rounded-lg px-3 py-2 w-full md:w-72 text-sm">
                <button class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium">Cari</button>
            </form>

            <a href="{{ route('barang.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">
                + Tambah Barang
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-200 text-sm">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 border text-left font-semibold">No.</th>
                        <th class="px-4 py-3 border text-left font-semibold">Kode</th>
                        <th class="px-4 py-3 border text-left font-semibold">Jurusan</th>
                        <th class="px-4 py-3 border text-left font-semibold">Kategori</th>
                        <th class="px-4 py-3 border text-left font-semibold">Nama Barang</th>
                        <th class="px-4 py-3 border text-left font-semibold">Stok</th>
                        <th class="px-4 py-3 border text-left font-semibold">Kondisi</th>
                        <th class="px-4 py-3 border text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $index => $barang)
                        <tr>
                            <td class="px-4 py-3 border text-sm">{{ $barangs->firstItem() + $index }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $barang->kode_barang }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $barang->jurusan->nama }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $barang->kategori->nama }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $barang->nama_barang }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $barang->stok }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $barang->kondisi }}</td>
                            <td class="px-4 py-3 border">
                                <div class="flex gap-2">
                                    <a href="{{ route('barang.edit', $barang) }}" class="px-3 py-1 bg-yellow-500 text-white rounded text-xs font-medium">Edit</a>
                                    <form action="{{ route('barang.destroy', $barang) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded text-xs font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 border text-center text-sm text-slate-500">Data barang belum ada.</td>
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