public function jurusan()
{
    return $this->belongsTo(Jurusan::class);
}

public function peminjamans()
{
    return $this->hasMany(Peminjaman::class);
}