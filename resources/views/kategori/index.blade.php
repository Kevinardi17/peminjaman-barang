<x-dashboard-layout title="Kategori">
    <div class="bg-white rounded-2xl shadow-sm border p-5">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <form method="GET" action="{{ route('kategori.index') }}" class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Filter pencarian..."
                    class="border rounded-lg px-3 py-2 w-full md:w-72"
                >
                <button class="px-4 py-2 bg-slate-800 text-white rounded-lg">Cari</button>
            </form>

            <a href="{{ route('kategori.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                + Tambah Kategori
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 border text-left">No.</th>
                        <th class="px-4 py-3 border text-left">Jurusan</th>
                        <th class="px-4 py-3 border text-left">Nama Kategori</th>
                        <th class="px-4 py-3 border text-left">Deskripsi</th>
                        <th class="px-4 py-3 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody id="realtime-tbody">
                    @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td class="px-4 py-3 border">
                                {{ $kategoris->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 border">{{ $kategori->jurusan->nama }}</td>
                            <td class="px-4 py-3 border">{{ $kategori->nama }}</td>
                            <td class="px-4 py-3 border">{{ $kategori->deskripsi ?? '-' }}</td>
                            <td class="px-4 py-3 border">
                                <div class="flex gap-2">
                                    <a href="{{ route('kategori.edit', $kategori) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 border text-center text-slate-500">
                                Data kategori belum ada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="realtime-pagination" class="mt-4">
            {{ $kategoris->links() }}
        </div>
    </div>
</x-dashboard-layout>