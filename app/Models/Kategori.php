<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['jurusan_id', 'nama', 'deskripsi'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}