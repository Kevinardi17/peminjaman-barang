<x-dashboard-layout title="Jurusan">
    <div class="bg-white rounded-2xl shadow-sm border p-5">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <form method="GET" action="{{ route('jurusan.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter pencarian..." class="border rounded-lg px-3 py-2 w-full md:w-72">
                <button class="px-4 py-2 bg-slate-800 text-white rounded-lg">Cari</button>
            </form>

            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('jurusan.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                   + Tambah Jurusan
                </a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 border text-left">No.</th>
                        <th class="px-4 py-3 border text-left">Kode</th>
                        <th class="px-4 py-3 border text-left">Nama Jurusan</th>
                        @if(auth()->user()->role === 'superadmin')
                            <th class="px-4 py-3 border text-left">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurusans as $index => $jurusan)
                        <tr>
                            <td class="px-4 py-3 border">{{ $jurusans->firstItem() + $index }}</td>
                            <td class="px-4 py-3 border">{{ $jurusan->kode }}</td>
                            <td class="px-4 py-3 border">{{ $jurusan->nama }}</td>
                            @if(auth()->user()->role === 'superadmin')
                                <td class="px-4 py-3 border">
                                    <div class="flex gap-2">
                                        <a href="{{ route('jurusan.edit', $jurusan) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                                        <form action="{{ route('jurusan.destroy', $jurusan) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'superadmin' ? 4 : 3 }}" class="px-4 py-4 border text-center text-slate-500">
                                Data jurusan belum ada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $jurusans->links() }}
        </div>
    </div>
</x-dashboard-layout>