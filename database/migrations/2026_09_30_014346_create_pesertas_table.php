<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('pesertas', function (Blueprint $table) {
        $table->id();
        $table->string('nik', 16)->unique();
        $table->string('nama');
        $table->string('email')->unique();
        $table->string('no_hp', 20);
        $table->text('alamat');
        $table->foreignId('skema_id')
            ->constrained('skemas')
            ->cascadeOnUpdate()
            ->restrictOnDelete();
        $table->date('tanggal_daftar');
        $table->enum('status', [
            'Terdaftar',
            'Proses',
            'Lulus',
            'Tidak Lulus'
        ])->default('Terdaftar');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
