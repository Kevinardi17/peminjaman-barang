<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminJurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusans = Jurusan::all();

        foreach ($jurusans as $jurusan) {
            $emailKode = Str::lower($jurusan->kode);

            User::updateOrCreate(
                ['email' => "admin.{$emailKode}@gmail.com"],
                [
                    'name' => 'Admin ' . $jurusan->kode,
                    'password' => Hash::make('password123'),
                    'role' => 'admin_jurusan',
                    'no_hp' => '081234567890',
                    'jenis_pengguna' => null,
                    'asal_kelas_jabatan' => 'Admin Jurusan ' . $jurusan->nama,
                    'jurusan_id' => $jurusan->id,
                ]
            );
        }
    }
}