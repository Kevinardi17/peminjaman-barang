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
                <h3 id="stat-menunggu" class="text-3xl font-bold text-slate-800">{{ $totalMenunggu }}</h3>
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
                <h3 id="stat-dipinjam" class="text-3xl font-bold text-slate-800">{{ $totalDipinjam }}</h3>
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
                <h3 id="stat-riwayat" class="text-3xl font-bold text-slate-800">{{ $totalRiwayat }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Total Riwayat (<span id="stat-pengajuan">{{ $totalPengajuan }}</span> Pengajuan)</p>
            </div>
        </a>

    </div>

    <!-- Chart and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Chart Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center items-center">
            <h3 class="text-lg font-bold text-slate-800 mb-4 w-full text-left">Status Pengajuan Saya</h3>
            <div class="relative w-full h-64 flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col h-full">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Aksi Cepat</h3>
            <div class="flex flex-col gap-4 h-full justify-center">
                <a href="{{ route('peminjaman.create') }}" class="flex items-center justify-center gap-2 px-4 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold w-full text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Buat Peminjaman Baru
                </a>
                <a href="{{ route('peminjaman.index') }}" class="flex items-center justify-center gap-2 px-4 py-4 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition font-semibold w-full text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                    </svg>
                    Daftar Peminjaman Saya
                </a>
                <a href="{{ route('riwayat.index') }}" class="flex items-center justify-center gap-2 px-4 py-4 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-semibold w-full text-center border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Cek Riwayat
                </a>
            </div>
        </div>
    </div>

    <script>
        // Inisialisasi Chart
        const ctx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Dipinjam', 'Dikembalikan', 'Ditolak'],
                datasets: [{
                    data: [{{ $totalMenunggu }}, {{ $totalDipinjam }}, {{ $totalDikembalikan }}, {{ $totalDitolak }}],
                    backgroundColor: [
                        '#eab308', // yellow-500
                        '#3b82f6', // blue-500
                        '#10b981', // emerald-500
                        '#ef4444'  // red-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Polling Data Real-time
        setInterval(() => {
            fetch('{{ route('dashboard.stats') }}')
                .then(res => res.json())
                .then(data => {
                    const elMenunggu = document.getElementById('stat-menunggu');
                    const elDipinjam = document.getElementById('stat-dipinjam');
                    const elRiwayat = document.getElementById('stat-riwayat');
                    const elPengajuan = document.getElementById('stat-pengajuan');

                    if(elMenunggu) elMenunggu.innerText = data.totalMenunggu;
                    if(elDipinjam) elDipinjam.innerText = data.totalDipinjam;
                    if(elRiwayat) elRiwayat.innerText = data.totalRiwayat;
                    if(elPengajuan) elPengajuan.innerText = data.totalPengajuan;

                    // Update Chart Data
                    statusChart.data.datasets[0].data = [
                        data.totalMenunggu,
                        data.totalDipinjam,
                        data.totalDikembalikan,
                        data.totalDitolak
                    ];
                    statusChart.update();
                })
                .catch(err => console.error('Error fetching stats:', err));
        }, 5000);
    </script>
</x-dashboard-layout>