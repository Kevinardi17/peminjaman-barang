<x-dashboard-layout title="Riwayat">
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
            <form method="GET" action="{{ route('riwayat.index') }}" class="flex flex-col sm:flex-row gap-2">
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
                            <th class="px-5 py-4 text-left font-semibold">Status</th>
                            <th class="px-5 py-4 text-left font-semibold">Keterlambatan</th>
                            <th class="px-5 py-4 text-left font-semibold">Tanggal Kembali</th>
                            <th class="px-5 py-4 text-left font-semibold">Petugas</th>
                            <th class="px-5 py-4 text-left font-semibold">Foto</th>
                            <th class="px-5 py-4 text-left font-semibold w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="realtime-tbody" class="divide-y divide-slate-200">
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
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $riwayats->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-800">
                                    {{ $item->no_peminjaman }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->user->name ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->jurusanTujuan->nama ?? '-' }}
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium {{ $statusClass }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ str_replace('_', ' ', ucfirst($item->status_keterlambatan ?? '-')) }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->tanggal_kembali ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $petugas }}
                                </td>
                                <td class="px-5 py-4">
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
                                <td class="px-5 py-4">
                                    <div class="flex flex-col gap-2">
                                        @if($item->status === 'dikembalikan')
                                            <a href="{{ route('pengembalian.print', $item) }}" target="_blank"
                                                class="w-full px-4 py-2 bg-blue-600 text-white text-center rounded-xl hover:bg-blue-700 transition">
                                                Cetak Bukti
                                            </a>
                                        @endif
                                        @if(auth()->user()->role === 'superadmin')
                                            <form action="{{ route('riwayat.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus riwayat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="w-full px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada data riwayat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="realtime-pagination" class="mt-5">
            {{ $riwayats->links() }}
        </div>
    </div>
</x-dashboard-layout>