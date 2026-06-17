<x-dashboard-layout title="Detail Pengembalian">
    <div class="bg-white rounded-2xl shadow-sm border p-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-800">Detail Pengembalian #{{ $peminjaman->no_peminjaman }}</h2>
            <a href="{{ route('pengembalian.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition text-sm font-medium">
                Kembali
            </a>
        </div>

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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 mb-1">Informasi Peminjam</h3>
                    <p class="text-slate-800 font-medium">{{ $peminjaman->user->name }}</p>
                    <p class="text-slate-600 text-sm">{{ $peminjaman->user->role }} - {{ $peminjaman->user->asal_kelas_jabatan }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 mb-1">Jurusan Tujuan</h3>
                    <p class="text-slate-800 font-medium">{{ $peminjaman->jurusanTujuan->nama ?? '-' }}</p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 mb-1">Tanggal Peminjaman</h3>
                    <p class="text-slate-800 font-medium">{{ $peminjaman->tanggal_pinjam }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 mb-1">Rencana Kembali</h3>
                    <p class="text-slate-800 font-medium">{{ $peminjaman->tanggal_rencana_kembali }}</p>
                    @if(now()->toDateString() > $peminjaman->tanggal_rencana_kembali)
                        <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-[10px] font-medium bg-red-100 text-red-700">
                            Terlambat
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 mb-1">Petugas Peminjaman</h3>
                    <p class="text-slate-800 font-medium">{{ $peminjaman->nama_petugas_peminjaman ?? $peminjaman->petugasPeminjaman->name ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Barang yang Harus Dikembalikan</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border-collapse border border-slate-200">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="border border-slate-200 px-4 py-2 text-left w-16">No.</th>
                            <th class="border border-slate-200 px-4 py-2 text-left">Foto</th>
                            <th class="border border-slate-200 px-4 py-2 text-left">Kode</th>
                            <th class="border border-slate-200 px-4 py-2 text-left">Nama Barang</th>
                            <th class="border border-slate-200 px-4 py-2 text-left w-32">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman->details as $index => $detail)
                            <tr>
                                <td class="border border-slate-200 px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border border-slate-200 px-4 py-2">
                                    @if($detail->barang->foto)
                                        <img src="{{ asset('storage/' . $detail->barang->foto) }}" alt="Foto Barang" class="w-12 h-12 rounded object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-slate-100 flex items-center justify-center text-[10px] text-slate-400 rounded">No img</div>
                                    @endif
                                </td>
                                <td class="border border-slate-200 px-4 py-2 font-medium">{{ $detail->barang->kode_barang }}</td>
                                <td class="border border-slate-200 px-4 py-2">{{ $detail->barang->nama_barang }}</td>
                                <td class="border border-slate-200 px-4 py-2">{{ $detail->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</x-dashboard-layout>
