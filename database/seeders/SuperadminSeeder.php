<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Superadmin',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'no_hp' => '081234567890',
                'jenis_pengguna' => null,
                'asal_kelas_jabatan' => 'Superadmin Sistem',
                'jurusan_id' => null,
            ]
        );
    }
}