<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('jurusan_id')
                ->nullable()
                ->after('id')
                ->constrained('jurusans')
                ->nullOnDelete();

            $table->string('no_hp')->nullable()->after('email');

            $table->enum('role', [
                'superadmin',
                'admin_jurusan',
                'peminjam'
            ])->default('peminjam')->after('no_hp');

            $table->enum('jenis_pengguna', [
                'siswa',
                'guru'
            ])->nullable()->after('role');

            $table->string('asal_kelas_jabatan')
                ->nullable()
                ->after('jenis_pengguna');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('jurusan_id');

            $table->dropColumn([
                'no_hp',
                'role',
                'jenis_pengguna',
                'asal_kelas_jabatan',
            ]);
        });
    }
};