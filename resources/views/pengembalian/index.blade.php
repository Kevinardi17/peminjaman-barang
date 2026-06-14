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
                            <th class="px-5 py-4 text-left font-semibold">Rencana Kembali</th>
                            <th class="px-5 py-4 text-left font-semibold">Status Telat</th>
                            <th class="px-5 py-4 text-left font-semibold w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="realtime-tbody" class="divide-y divide-slate-200">
                        @forelse($peminjamans as $index => $item)
                            <tr class="hover:bg-slate-50 transition align-middle">
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
                                <td class="px-5 py-4">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('pengembalian.show', $item) }}"
                                            class="inline-block w-full text-center px-4 py-1.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-sm font-medium">
                                            Detail
                                        </a>
                                        <button onclick="openModalKembalikan('{{ $item->id }}', '{{ $item->no_peminjaman }}')"
                                            class="inline-block w-full text-center px-4 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                            Kembalikan
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada data peminjaman yang perlu dikembalikan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="realtime-pagination" class="mt-5">
            {{ $peminjamans->links() }}
        </div>
    </div>

    <!-- Modal Kembalikan -->
    <div id="modalKembalikan" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-xl">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Proses Pengembalian</h3>
                <button type="button" onclick="closeModalKembalikan()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-slate-600 mb-4">No Peminjaman: <span id="modalNoPeminjaman" class="font-bold text-slate-800"></span></p>
                <form id="formKembalikan" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Foto Bukti Pengembalian <span class="text-red-500">*</span></label>
                        <input type="file" name="foto_pengembalian" required class="block w-full text-sm border border-slate-300 rounded-xl px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-slate-100">
                        <button type="button" onclick="closeModalKembalikan()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 font-medium transition">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium transition">Kirim Bukti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModalKembalikan(id, no) {
            document.getElementById('modalNoPeminjaman').textContent = no;
            document.getElementById('formKembalikan').action = `/pengembalian/${id}`;
            const modal = document.getElementById('modalKembalikan');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModalKembalikan() {
            const modal = document.getElementById('modalKembalikan');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('formKembalikan').reset();
        }
    </script>
</x-dashboard-layout>