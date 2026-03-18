<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $fillable = [
        'no_peminjaman',
        'user_id',
        'jurusan_tujuan_id',
        'status',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'tanggal_kembali',
        'alasan_penolakan',
        'foto_peminjaman',
        'foto_pengembalian',
        'petugas_peminjaman_id',
        'petugas_pengembalian_id',
        'status_keterlambatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusanTujuan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_tujuan_id');
    }

    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}