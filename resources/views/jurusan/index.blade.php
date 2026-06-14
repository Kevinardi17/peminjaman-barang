<x-dashboard-layout title="Jurusan">
    <div class="bg-white rounded-2xl shadow-sm border p-6">
        @if(session('success'))
            <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
            <form method="GET" action="{{ route('jurusan.index') }}" class="flex flex-col sm:flex-row gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Filter pencarian..."
                    class="border border-slate-300 rounded-xl px-4 py-2.5 w-full sm:w-80 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button class="px-5 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition">
                    Cari
                </button>
            </form>

            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('jurusan.create') }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                    + Tambah Jurusan
                </a>
            @endif
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-5 py-4 text-left font-semibold w-20">No.</th>
                            <th class="px-5 py-4 text-left font-semibold w-40">Kode</th>
                            <th class="px-5 py-4 text-left font-semibold">Nama Jurusan</th>
                            @if(auth()->user()->role === 'superadmin')
                                <th class="px-5 py-4 text-left font-semibold w-44">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="realtime-tbody" class="divide-y divide-slate-200">
                        @forelse($jurusans as $index => $jurusan)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $jurusans->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 text-blue-700 font-semibold">
                                        {{ $jurusan->kode }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-800 font-medium">
                                    {{ $jurusan->nama }}
                                </td>
                                @if(auth()->user()->role === 'superadmin')
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('jurusan.edit', $jurusan) }}"
                                                class="inline-flex items-center px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('jurusan.destroy', $jurusan) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'superadmin' ? 4 : 3 }}"
                                    class="px-5 py-10 text-center text-slate-500">
                                    Data jurusan belum ada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="realtime-pagination" class="mt-5">
            {{ $jurusans->links() }}
        </div>
    </div>
</x-dashboard-layout>