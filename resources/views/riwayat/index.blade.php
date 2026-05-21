<x-dashboard-layout title="Riwayat">
    <div class="bg-white rounded-2xl shadow-sm border p-6">
        @if(session('success'))
            <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-xl bg-red-100 text-red-700 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
            <form method="GET" action="{{ route('riwayat.index') }}" class="flex flex-col sm:flex-row gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Filter pencarian..."
                    class="border border-slate-300 rounded-xl px-4 py-2.5 w-full sm:w-80 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                >
                <button class="px-5 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition text-sm">
                    Cari
                </button>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-5 py-4 text-left font-semibold w-16 text-sm">No.</th>
                            <th class="px-5 py-4 text-left font-semibold text-sm">No Peminjaman</th>
                            <th class="px-5 py-4 text-left font-semibold text-sm">Peminjam</th>
                            <th class="px-5 py-4 text-left font-semibold text-sm">Jurusan Tujuan</th>
                            <th class="px-5 py-4 text-left font-semibold text-sm">Status</th>
                            <th class="px-5 py-4 text-left font-semibold text-sm">Keterlambatan</th>
                            <th class="px-5 py-4 text-left font-semibold text-sm">Tanggal Kembali</th>
                            <th class="px-5 py-4 text-left font-semibold text-sm">Petugas</th>
                            <th class="px-5 py-4 text-left font-semibold text-sm">Foto</th>
                            @if(auth()->user()->role !== 'peminjam')
                                <th class="px-5 py-4 text-left font-semibold w-32 text-sm">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($riwayats as $index => $item)
                            @php
                                $statusClass = match($item->status) {
                                    'dikembalikan' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };

                                $petugas = $item->petugasPengembalian->name 
                                    ?? $item->petugasPeminjaman->name 
                                    ?? '-';
                            @endphp

                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 text-slate-700 text-sm">
                                    {{ $riwayats->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-800 text-sm">
                                    {{ $item->no_peminjaman }}
                                </td>
                                <td class="px-5 py-4 text-slate-700 text-sm">
                                    {{ $item->user->name ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-700 text-sm">
                                    {{ $item->jurusanTujuan->nama ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium {{ $statusClass }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-700 text-sm">
                                    {{ str_replace('_', ' ', ucfirst($item->status_keterlambatan ?? '-')) }}
                                </td>
                                <td class="px-5 py-4 text-slate-700 text-sm">
                                    {{ $item->tanggal_kembali ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-700 text-sm">
                                    {{ $petugas }}
                                </td>
                                <td class="px-5 py-4 text-sm">
                                    @if($item->foto_pengembalian)
                                        <img src="{{ asset('storage/' . $item->foto_pengembalian) }}"
                                            class="w-16 h-16 object-cover rounded-xl border border-slate-200">
                                    @elseif($item->foto_peminjaman)
                                        <img src="{{ asset('storage/' . $item->foto_peminjaman) }}"
                                            class="w-16 h-16 object-cover rounded-xl border border-slate-200">
                                    @else
                                        <span class="text-slate-500">-</span>
                                    @endif
                                </td>
                                @if(auth()->user()->role !== 'peminjam')
                                    <td class="px-5 py-4">
                                        <form action="{{ route('riwayat.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus riwayat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition text-xs font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role !== 'peminjam' ? 10 : 9 }}"
                                    class="px-5 py-10 text-center text-slate-500 text-sm">
                                    Belum ada data riwayat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5">
            {{ $riwayats->links() }}
        </div>
    </div>
</x-dashboard-layout>