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
                <h3 id="stat-menunggu" class="text-3xl font-bold text-slate-800">{{ $totalMenunggu }}</h3>
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
                <h3 id="stat-telat" class="text-3xl font-bold text-slate-800">{{ $totalTelat }}</h3>
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
                <h3 id="stat-dipinjam" class="text-3xl font-bold text-slate-800">{{ $totalDipinjam }}</h3>
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
                <h3 id="stat-barang" class="text-3xl font-bold text-slate-800">{{ $totalBarang }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Total Barang Jurusan</p>
            </div>
        </a>

    </div>

    <!-- Chart and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Chart Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center items-center">
            <h3 class="text-lg font-bold text-slate-800 mb-4 w-full text-left">Proporsi Status Peminjaman Jurusan</h3>
            <div class="relative w-full h-64 flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col h-full">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Aksi Cepat</h3>
            <div class="flex flex-col gap-4 h-full justify-center">
                <a href="{{ route('peminjaman.index') }}" class="flex items-center justify-center gap-2 px-4 py-4 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition font-semibold w-full text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Proses Peminjaman
                </a>
                <a href="{{ route('barang.create') }}" class="flex items-center justify-center gap-2 px-4 py-4 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition font-semibold w-full text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Barang
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
                    const elTelat = document.getElementById('stat-telat');
                    const elDipinjam = document.getElementById('stat-dipinjam');
                    const elBarang = document.getElementById('stat-barang');

                    if(elMenunggu) elMenunggu.innerText = data.totalMenunggu;
                    if(elTelat) elTelat.innerText = data.totalTelat;
                    if(elDipinjam) elDipinjam.innerText = data.totalDipinjam;
                    if(elBarang) elBarang.innerText = data.totalBarang;

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