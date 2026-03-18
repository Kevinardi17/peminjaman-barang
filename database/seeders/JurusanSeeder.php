<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'TSM', 'nama' => 'Teknik Sepeda Motor'],
            ['kode' => 'TKR', 'nama' => 'Teknik Kendaraan Ringan'],
            ['kode' => 'ANM', 'nama' => 'Animasi'],
            ['kode' => 'DKV', 'nama' => 'Desain Komunikasi Visual'],
            ['kode' => 'KKBT', 'nama' => 'Kriya Kreatif Batik dan Tekstil'],
            ['kode' => 'KKLP', 'nama' => 'Kriya Kreatif Logam dan Perhiasan'],
            ['kode' => 'KKR', 'nama' => 'Kriya Kreatif Kayu dan Rotan'],
        ];

        foreach ($data as $item) {
            Jurusan::updateOrCreate(
                ['kode' => $item['kode']],
                ['nama' => $item['nama']]
            );
        }
    }
}