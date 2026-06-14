<x-dashboard-layout title="Dashboard Superadmin">
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

        <!-- Total User -->
        <a href="{{ route('management-user.index') }}" class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-purple-200 transition-all flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-purple-100 text-purple-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sistem</span>
            </div>
            <div>
                <h3 id="stat-user" class="text-3xl font-bold text-slate-800">{{ $totalUser }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Total Pengguna</p>
            </div>
        </a>

    </div>

    <!-- Chart and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Chart Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center items-center">
            <h3 class="text-lg font-bold text-slate-800 mb-4 w-full text-left">Proporsi Status Peminjaman</h3>
            <div class="relative w-full h-64 flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col h-full">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Aksi Cepat</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 h-full content-center">
                <a href="{{ route('barang.create') }}" class="flex items-center justify-center gap-2 px-4 py-4 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition font-semibold w-full text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Barang
                </a>
                <a href="{{ route('management-user.create') }}" class="flex items-center justify-center gap-2 px-4 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold w-full text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 19.5v-15m-6 15v-15m-6 15v-15" />
                    </svg>
                    Tambah User
                </a>
                <a href="{{ route('riwayat.index') }}" class="flex items-center justify-center gap-2 px-4 py-4 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-semibold w-full text-center border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Cek Riwayat
                </a>
                <a href="{{ route('barang.index') }}" class="flex items-center justify-center gap-2 px-4 py-4 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-semibold w-full text-center border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Stok Barang (<span id="stat-barang">{{ $totalBarang }}</span>)
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
                    // Update Text Stats
                    const elMenunggu = document.getElementById('stat-menunggu');
                    const elTelat = document.getElementById('stat-telat');
                    const elDipinjam = document.getElementById('stat-dipinjam');
                    const elUser = document.getElementById('stat-user');
                    const elBarang = document.getElementById('stat-barang');

                    if(elMenunggu) elMenunggu.innerText = data.totalMenunggu;
                    if(elTelat) elTelat.innerText = data.totalTelat;
                    if(elDipinjam) elDipinjam.innerText = data.totalDipinjam;
                    if(elUser) elUser.innerText = data.totalUser;
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