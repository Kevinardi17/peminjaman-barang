<x-dashboard-layout title="Riwayat Peminjaman Barang">
    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Riwayat Peminjaman: {{ $barang->nama_barang }}</h2>
                <p class="text-sm text-slate-500">Kode: {{ $barang->kode_barang }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('barang.show', $barang) }}" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition text-sm font-medium">
                    Detail Barang
                </a>
                <a href="{{ route('barang.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition text-sm font-medium">
                    Kembali
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border-collapse border border-slate-200">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold w-16 border">No.</th>
                        <th class="px-5 py-4 text-left font-semibold border">No Peminjaman</th>
                        <th class="px-5 py-4 text-left font-semibold border">Peminjam</th>
                        <th class="px-5 py-4 text-left font-semibold border">Tanggal Pinjam</th>
                        <th class="px-5 py-4 text-left font-semibold border">Tanggal Kembali</th>
                        <th class="px-5 py-4 text-left font-semibold border">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($riwayats as $index => $item)
                        @php
                            $statusClass = match($item->status) {
                                'menunggu' => 'bg-yellow-100 text-yellow-700',
                                'dipinjam' => 'bg-blue-100 text-blue-700',
                                'dikembalikan' => 'bg-green-100 text-green-700',
                                'ditolak' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50 transition align-middle">
                            <td class="px-5 py-4 border text-slate-700">
                                {{ $riwayats->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-4 font-medium border text-slate-800">
                                {{ $item->no_peminjaman }}
                            </td>
                            <td class="px-5 py-4 border text-slate-700">
                                {{ $item->user->name }}
                                <br><span class="text-xs text-slate-500">{{ $item->user->role }}</span>
                            </td>
                            <td class="px-5 py-4 border text-slate-700">
                                {{ $item->tanggal_pinjam }}
                            </td>
                            <td class="px-5 py-4 border text-slate-700">
                                {{ $item->tanggal_kembali ?? '-' }}
                            </td>
                            <td class="px-5 py-4 border">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium {{ $statusClass }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-500 border">
                                Belum ada riwayat peminjaman untuk barang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-5">
            {{ $riwayats->links() }}
        </div>
    </div>
</x-dashboard-layout>
