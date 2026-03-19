<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'jurusan_id',
        'kategori_id',
        'kode_barang',
        'nama_barang',
        'stok',
        'kondisi',
        'keterangan',
        'foto'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}