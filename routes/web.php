<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            return view('dashboard.superadmin');
        }

        if ($user->role === 'admin_jurusan') {
            return view('dashboard.admin-jurusan');
        }

        return view('dashboard.peminjam');
    })->name('dashboard');
});

require __DIR__.'/auth.php';