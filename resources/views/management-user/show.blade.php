<x-dashboard-layout title="Detail Management User">
    <div class="bg-white rounded-2xl shadow-sm border p-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-800">Detail Pengguna</h2>
            <div class="flex gap-2">
                <a href="{{ route('management-user.edit', $user) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition text-sm font-medium">
                    Edit Pengguna
                </a>
                <a href="{{ route('management-user.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition text-sm font-medium">
                    Kembali
                </a>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Lengkap</h3>
                    <p class="font-medium text-slate-900 text-lg">{{ $user->name }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email</h3>
                    <p class="font-medium text-slate-800">{{ $user->email }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nomor HP</h3>
                    <p class="font-medium text-slate-800">{{ $user->no_hp }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Role</h3>
                    <p class="font-medium text-slate-800">
                        @if($user->role === 'admin_jurusan')
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm font-medium">Admin Jurusan</span>
                        @else
                            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded-lg text-sm font-medium">Peminjam</span>
                        @endif
                    </p>
                </div>
                
                @if($user->role === 'peminjam')
                    <div>
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Jenis Pengguna</h3>
                        <p class="font-medium text-slate-800">{{ ucfirst($user->jenis_pengguna) }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Asal/Kelas/Jabatan</h3>
                        <p class="font-medium text-slate-800">{{ $user->asal_kelas_jabatan }}</p>
                    </div>
                @endif
                
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Jurusan</h3>
                    <p class="font-medium text-slate-800">{{ $user->jurusan?->nama ?? '-' }}</p>
                </div>
                
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Terdaftar Sejak</h3>
                    <p class="font-medium text-slate-800">{{ $user->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
