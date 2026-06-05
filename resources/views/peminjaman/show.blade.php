<x-dashboard-layout title="Detail Peminjaman">
    <div class="bg-white rounded-2xl shadow-sm border p-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-800">Detail Peminjaman #{{ $peminjaman->no_peminjaman }}</h2>
            <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition text-sm font-medium">
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
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 mb-1">Status</h3>
                    @php
                        $statusClass = match($peminjaman->status) {
                            'menunggu' => 'bg-yellow-100 text-yellow-700',
                            'dipinjam' => 'bg-blue-100 text-blue-700',
                            'dikembalikan' => 'bg-green-100 text-green-700',
                            'ditolak' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium {{ $statusClass }}">
                        {{ ucfirst($peminjaman->status) }}
                    </span>
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
                </div>
                @if($peminjaman->petugasPeminjaman)
                    <div>
                        <h3 class="text-sm font-semibold text-slate-500 mb-1">Petugas Peminjaman</h3>
                        <p class="text-slate-800 font-medium">{{ $peminjaman->petugasPeminjaman->name }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Barang yang Dipinjam</h3>
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

        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Bukti / Foto Peminjaman</h3>
            @if($peminjaman->foto_peminjaman)
                <img
                    src="{{ asset('storage/' . $peminjaman->foto_peminjaman) }}"
                    alt="Foto Peminjaman"
                    class="max-w-xs rounded-xl border border-slate-200 shadow-sm"
                >
            @else
                <p class="text-slate-500 italic">Belum ada foto peminjaman.</p>
            @endif
        </div>

        @if($peminjaman->status === 'ditolak')
            <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-xl">
                <h3 class="text-sm font-semibold text-red-700 mb-1">Alasan Penolakan:</h3>
                <p class="text-red-600">{{ $peminjaman->alasan_penolakan ?? '-' }}</p>
            </div>
        @endif

        @if(auth()->user()->role !== 'peminjam')


            @if($peminjaman->status === 'dipinjam')
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('peminjaman.print', $peminjaman) }}" target="_blank"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.728 9.75h10.544M6.728 14.25h10.544M19.5 10.5h-15a2.25 2.25 0 0 0-2.25 2.25v6a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25v-6a2.25 2.25 0 0 0-2.25-2.25Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5V4.5a2.25 2.25 0 0 0-2.25-2.25h-10.5a2.25 2.25 0 0 0-2.25 2.25v6" />
                        </svg>
                        Cetak Surat Peminjaman
                    </a>
                </div>
            @endif
        @endif
    </div>
</x-dashboard-layout>
