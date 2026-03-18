<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'role',
        'jenis_pengguna',
        'asal_kelas_jabatan',
        'jurusan_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🔹 Relasi
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // 🔹 Helper role
    public function isSuperadmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdminJurusan()
    {
        return $this->role === 'admin_jurusan';
    }

    public function isPeminjam()
    {
        return $this->role === 'peminjam';
    }
}