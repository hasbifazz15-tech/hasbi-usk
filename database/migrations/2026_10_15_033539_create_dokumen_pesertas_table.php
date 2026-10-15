<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_pesertas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peserta_id')
                ->constrained('pesertas')
                ->cascadeOnDelete();

            $table->enum('jenis_dokumen', [
                'ktp',
                'ijazah',
                'sertifikat'
            ]);

            $table->string('file_path');

            $table->enum('status', [
                'menunggu',
                'diterima',
                'ditolak'
            ])->default('menunggu');

            $table->text('catatan_admin')->nullable();

            $table->foreignId('diverifikasi_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('diverifikasi_pada')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_pesertas');
    }
};