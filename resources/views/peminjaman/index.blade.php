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
                            <th class="px-5 py-4 text-left font-semibold">Barang</th>
                            <th class="px-5 py-4 text-left font-semibold">Peminjam</th>
                            <th class="px-5 py-4 text-left font-semibold">Waktu Pinjam</th>
                            <th class="px-5 py-4 text-left font-semibold">Status</th>
                            <th class="px-5 py-4 text-left font-semibold w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($peminjamans as $index => $item)
                            @php
                                $statusClass = match($item->status) {
                                    'menunggu' => 'bg-yellow-100 text-yellow-700',
                                    'dipinjam' => 'bg-blue-100 text-blue-700',
                                    'dikembalikan' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                                $namaBarang = $item->details->first()?->barang->nama_barang;
                                if ($item->details->count() > 1) {
                                    $namaBarang .= ' (+' . ($item->details->count() - 1) . ' lainnya)';
                                }
                            @endphp

                            <tr class="hover:bg-slate-50 transition align-middle">
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $peminjamans->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-800">
                                    {{ $namaBarang ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->user->name ?? auth()->user()->name }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $item->tanggal_pinjam }}
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium {{ $statusClass }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('peminjaman.show', $item) }}"
                                            class="inline-block w-full text-center px-4 py-1.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-sm font-medium">
                                            Detail
                                        </a>
                                        @if(auth()->user()->role !== 'peminjam' && $item->status === 'menunggu')
                                            <button onclick="openModalSetuju('{{ $item->id }}', '{{ $item->no_peminjaman }}')"
                                                class="inline-block w-full text-center px-4 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                                Setujui
                                            </button>
                                            <button onclick="openModalTolak('{{ $item->id }}', '{{ $item->no_peminjaman }}')"
                                                class="inline-block w-full text-center px-4 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                                Tolak
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-slate-500">
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

    @if(auth()->user()->role !== 'peminjam')
        <!-- Modal Setujui -->
        <div id="modalSetuju" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full shadow-xl">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Setujui Peminjaman</h3>
                    <button type="button" onclick="closeModalSetuju()" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-600 mb-4">No Peminjaman: <span id="modalSetujuNo" class="font-bold text-slate-800"></span></p>
                    <form id="formSetuju" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Foto Bukti Peminjaman <span class="text-red-500">*</span></label>
                            <input type="file" name="foto_peminjaman" required class="block w-full text-sm border border-slate-300 rounded-xl px-3 py-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                        <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeModalSetuju()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 font-medium transition">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 font-medium transition">Setujui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Tolak -->
        <div id="modalTolak" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full shadow-xl">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Tolak Peminjaman</h3>
                    <button type="button" onclick="closeModalTolak()" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-600 mb-4">No Peminjaman: <span id="modalTolakNo" class="font-bold text-slate-800"></span></p>
                    <form id="formTolak" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                            <textarea name="alasan_penolakan" rows="3" required placeholder="Tuliskan alasan penolakan..." class="w-full text-sm border border-slate-300 rounded-xl px-3 py-2 focus:ring-red-500 focus:border-red-500"></textarea>
                        </div>
                        <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeModalTolak()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 font-medium transition">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 font-medium transition">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openModalSetuju(id, no) {
                document.getElementById('modalSetujuNo').textContent = no;
                document.getElementById('formSetuju').action = `/peminjaman/${id}/approve`;
                const modal = document.getElementById('modalSetuju');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModalSetuju() {
                const modal = document.getElementById('modalSetuju');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.getElementById('formSetuju').reset();
            }

            function openModalTolak(id, no) {
                document.getElementById('modalTolakNo').textContent = no;
                document.getElementById('formTolak').action = `/peminjaman/${id}/reject`;
                const modal = document.getElementById('modalTolak');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModalTolak() {
                const modal = document.getElementById('modalTolak');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.getElementById('formTolak').reset();
            }
        </script>
    @endif
</x-dashboard-layout>