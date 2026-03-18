<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('no_peminjaman')->unique();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jurusan_tujuan_id')->constrained('jurusans')->cascadeOnDelete();

            $table->enum('status', ['menunggu', 'dipinjam', 'dikembalikan', 'ditolak'])->default('menunggu');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_rencana_kembali');
            $table->date('tanggal_kembali')->nullable();

            $table->text('alasan_penolakan')->nullable();

            $table->string('foto_peminjaman')->nullable();
            $table->string('foto_pengembalian')->nullable();

            $table->foreignId('petugas_peminjaman_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('petugas_pengembalian_id')->nullable()->constrained('users')->nullOnDelete();

            $table->enum('status_keterlambatan', ['belum_kembali', 'tepat_waktu', 'terlambat'])->default('belum_kembali');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};