<x-dashboard-layout title="Dashboard Peminjam">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-2">
        
        <!-- Status Pengajuan (Menunggu) -->
        <a href="{{ route('peminjaman.index') }}" class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-yellow-200 transition-all flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-yellow-100 text-yellow-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sedang Diproses</span>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalMenunggu }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Menunggu Persetujuan</p>
            </div>
        </a>

        <!-- Sedang Dipinjam -->
        <a href="{{ route('peminjaman.index') }}" class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Aktif</span>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalDipinjam }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Barang Sedang Dipinjam</p>
            </div>
        </a>

        <!-- Riwayat Peminjaman -->
        <a href="{{ route('riwayat.index') }}" class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Selesai</span>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalRiwayat }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Total Riwayat ({{ $totalPengajuan }} Pengajuan)</p>
            </div>
        </a>

    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Aksi Cepat</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Peminjaman Baru
            </a>
            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                </svg>
                Daftar Peminjaman Saya
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