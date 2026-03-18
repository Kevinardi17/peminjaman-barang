<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable = ['kode', 'nama'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}