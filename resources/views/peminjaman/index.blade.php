<x-dashboard-layout title="Peminjaman">
    <div class="bg-white rounded-2xl shadow-sm border p-6">
        @if(session('success'))
            <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-xl bg-red-100 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
            <form method="GET" action="{{ route('peminjaman.index') }}" class="flex flex-col sm:flex-row gap-2">
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

            @if(auth()->user()->role === 'peminjam')
                <a href="{{ route('peminjaman.create') }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                    Ajukan Peminjaman
                </a>
            @endif
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-5 py-4 text-left font-semibold w-16">No.</th>
                            <th class="px-5 py-4 text-left font-semibold">No Peminjaman</th>
                            <th class="px-5 py-4 text-left font-semibold">Peminjam</th>
                            <th class="px-5 py-4 text-left font-semibold">Jurusan Tujuan</th>
                            <th class="px-5 py-4 text-left font-semibold">Jumlah Barang</th>
                            <th class="px-5 py-4 text-left font-semibold">Tanggal Pinjam</th>
                            <th class="px-5 py-4 text-left font-semibold">Rencana Kembali</th>
                            <th class="px-5 py-4 text-left font-semibold">Foto Peminjaman</th>
                            <th class="px-5 py-4 text-left font-semibold">Status</th>
                            <th class="px-5 py-4 text-left font-semibold">Petugas</th>
                            <th class="px-5 py-4 text-left font-semibold w-72">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($peminjamans as $index => $item)
                            @php
                                $jumlahBarang = $item->details->sum('jumlah');

                                $statusClass = match($item->status) {
                                    'menunggu' => 'bg-yellow-100 text-yellow-700',
                                    'dipinjam' => 'bg-blue-100 text-blue-700',
                                    'dikembalikan' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50 transition align-top">
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $peminjamans->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-800">
                                    {{ $item->no_peminjaman }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->user->name ?? auth()->user()->name }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->jurusanTujuan->nama ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $jumlahBarang }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->tanggal_pinjam }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->tanggal_rencana_kembali }}
                                </td>
                                <td class="px-5 py-4">
                                    @if($item->foto_peminjaman)
                                        <img
                                            src="{{ asset('storage/' . $item->foto_peminjaman) }}"
                                            alt="Foto Peminjaman"
                                            class="w-16 h-16 rounded-xl object-cover border border-slate-200"
                                        >
                                    @else
                                        <div class="w-16 h-16 rounded-xl border border-slate-200 bg-slate-100 flex items-center justify-center text-[10px] text-slate-500 text-center px-1">
                                            Belum Ada
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium {{ $statusClass }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->petugasPeminjaman->name ?? '-' }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-col gap-2 min-w-[240px]">
                                        @if($item->status === 'menunggu' && auth()->user()->role !== 'peminjam')
                                            <form action="{{ route('peminjaman.approve', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                                @csrf
                                                <input
                                                    type="file"
                                                    name="foto_peminjaman"
                                                    required
                                                    class="block w-full text-sm border border-slate-300 rounded-xl px-3 py-2"
                                                >
                                                <button
                                                    type="submit"
                                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition">
                                                    Approve
                                                </button>
                                            </form>

                                            <form action="{{ route('peminjaman.reject', $item) }}" method="POST" class="space-y-2">
                                                @csrf
                                                <input
                                                    type="text"
                                                    name="alasan_penolakan"
                                                    placeholder="Alasan penolakan"
                                                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm"
                                                    required
                                                >
                                                <button
                                                    type="submit"
                                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition">
                                                    Tolak
                                                </button>
                                            </form>
                                        @endif

                                        @if($item->status === 'dipinjam')
                                            <a href="{{ route('peminjaman.print', $item) }}" target="_blank"
                                                class="w-full text-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                                                Print
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5">
            {{ $peminjamans->links() }}
        </div>
    </div>
</x-dashboard-layout>