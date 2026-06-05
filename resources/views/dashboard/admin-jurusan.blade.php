<x-dashboard-layout title="Dashboard Admin Jurusan">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-2">
        
        <!-- Peminjaman Menunggu -->
        <a href="{{ route('peminjaman.index') }}" class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-yellow-200 transition-all flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-yellow-100 text-yellow-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Perlu Proses</span>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalMenunggu }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Menunggu Persetujuan</p>
            </div>
        </a>

        <!-- Peminjaman Telat -->
        <a href="{{ route('pengembalian.index') }}" class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-red-200 transition-all flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-red-100 text-red-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Peringatan</span>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalTelat }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Peminjaman Terlambat</p>
            </div>
        </a>

        <!-- Peminjaman Aktif -->
        <a href="{{ route('pengembalian.index') }}" class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Berjalan</span>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalDipinjam }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Peminjaman Aktif</p>
            </div>
        </a>

        <!-- Total Barang -->
        <a href="{{ route('barang.index') }}" class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Inventaris</span>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalBarang }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Total Barang Jurusan</p>
            </div>
        </a>

    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Aksi Cepat</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Proses Peminjaman
            </a>
            <a href="{{ route('barang.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Barang
            </a>
            <a href="{{ route('riwayat.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Cek Riwayat
            </a>
        </div>
    </div>
</x-dashboard-layout>