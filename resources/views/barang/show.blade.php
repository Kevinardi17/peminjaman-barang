<x-dashboard-layout title="Detail Barang">
    <div class="bg-white rounded-2xl shadow-sm border p-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-800">Detail Barang</h2>
            <div class="flex gap-2">
                <a href="{{ route('barang.history', $barang) }}" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition text-sm font-medium">
                    Lihat Riwayat
                </a>
                <a href="{{ route('barang.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition text-sm font-medium">
                    Kembali
                </a>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-1/3">
                @if($barang->foto)
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto {{ $barang->nama_barang }}" class="w-full aspect-square object-cover rounded-2xl border border-slate-200 shadow-sm">
                @else
                    <div class="w-full aspect-square bg-slate-50 flex flex-col items-center justify-center rounded-2xl border border-slate-200 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <span>Belum ada foto</span>
                    </div>
                @endif
            </div>
            <div class="w-full md:w-2/3">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $barang->nama_barang }}</h1>
                    <p class="text-slate-500 font-mono">{{ $barang->kode_barang }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Jurusan</h3>
                        <p class="font-medium text-slate-800">{{ $barang->jurusan->nama }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kategori</h3>
                        <p class="font-medium text-slate-800">{{ $barang->kategori->nama }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Stok Total</h3>
                        <p class="font-medium text-slate-800">{{ $barang->stok }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Stok Tersedia</h3>
                        <p class="font-bold text-blue-600 text-lg">{{ $tersedia }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Sedang Dipinjam</h3>
                        <p class="font-medium text-orange-600">{{ $dipinjam }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kondisi</h3>
                        <p class="font-medium text-slate-800">{{ $barang->kondisi ?? '-' }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-slate-800 mb-2">Keterangan</h3>
                    <div class="p-4 bg-slate-50 rounded-xl text-slate-700 text-sm border border-slate-100 min-h-[100px]">
                        {{ $barang->keterangan ?: 'Tidak ada keterangan.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
