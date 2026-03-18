<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Barang;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ManagementUserController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['role:superadmin,admin_jurusan'])->group(function () {
    Route::resource('management-user', ManagementUserController::class)->except(['show']);
});

Route::middleware(['role:superadmin,admin_jurusan'])->group(function () {
    Route::resource('barang', BarangController::class);
});

Route::middleware(['role:superadmin,admin_jurusan'])->group(function () {
    Route::resource('kategori', KategoriController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            return view('dashboard.superadmin', [
                'totalJurusan' => Jurusan::count(),
                'totalUser' => User::count(),
                'totalBarang' => Barang::count(),
                'totalPeminjamanAktif' => Peminjaman::where('status', 'dipinjam')->count(),
            ]);
        }

        if ($user->role === 'admin_jurusan') {
            return view('dashboard.admin-jurusan', [
                'totalKategori' => Kategori::where('jurusan_id', $user->jurusan_id)->count(),
                'totalBarang' => Barang::where('jurusan_id', $user->jurusan_id)->count(),
                'totalMenunggu' => Peminjaman::where('jurusan_tujuan_id', $user->jurusan_id)
                    ->where('status', 'menunggu')
                    ->count(),
                'totalDipinjam' => Peminjaman::where('jurusan_tujuan_id', $user->jurusan_id)
                    ->where('status', 'dipinjam')
                    ->count(),
            ]);
        }

        return view('dashboard.peminjam', [
            'totalPengajuan' => Peminjaman::where('user_id', $user->id)->count(),
            'totalDipinjam' => Peminjaman::where('user_id', $user->id)
                ->where('status', 'dipinjam')
                ->count(),
            'totalRiwayat' => Peminjaman::where('user_id', $user->id)
                ->whereIn('status', ['dikembalikan', 'ditolak'])
                ->count(),
        ]);
    })->name('dashboard');
});

require __DIR__ . '/auth.php';