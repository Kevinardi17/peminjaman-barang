<x-dashboard-layout title="Pengembalian">
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

        <div class="overflow-hidden rounded-2xl border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-5 py-4 text-left font-semibold w-16">No.</th>
                            <th class="px-5 py-4 text-left font-semibold">No Peminjaman</th>
                            <th class="px-5 py-4 text-left font-semibold">Peminjam</th>
                            <th class="px-5 py-4 text-left font-semibold">Jumlah Barang</th>
                            <th class="px-5 py-4 text-left font-semibold">Rencana Kembali</th>
                            <th class="px-5 py-4 text-left font-semibold">Status Telat</th>
                            <th class="px-5 py-4 text-left font-semibold">Petugas Peminjaman</th>
                            <th class="px-5 py-4 text-left font-semibold">Petugas Pengembalian</th>
                            <th class="px-5 py-4 text-left font-semibold w-64">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($peminjamans as $index => $item)
                            @php
                                $jumlahBarang = $item->details->sum('jumlah');
                            @endphp

                            <tr class="hover:bg-slate-50 transition align-top">
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $peminjamans->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-800">
                                    {{ $item->no_peminjaman }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->user->name }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $jumlahBarang }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->tanggal_rencana_kembali }}
                                </td>
                                <td class="px-5 py-4">
                                    @if(now()->toDateString() > $item->tanggal_rencana_kembali)
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-red-100 text-red-700">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-blue-100 text-blue-700">
                                            Belum Telat
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->petugasPeminjaman->name ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->petugasPengembalian->name ?? '-' }}
                                </td>
                                <td class="px-5 py-4">
                                    <form action="{{ route('pengembalian.kembalikan', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-2 min-w-[220px]">
                                        @csrf
                                        <input type="file" name="foto_pengembalian" required class="block w-full text-sm border border-slate-300 rounded-xl px-3 py-2">
                                        <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                                            Kembalikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada data pengembalian.
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