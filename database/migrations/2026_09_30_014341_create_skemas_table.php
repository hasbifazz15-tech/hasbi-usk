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
    Schema::create('skemas', function (Blueprint $table) {
        $table->id();
        $table->string('kode')->unique();
        $table->string('nama');
        $table->text('deskripsi')->nullable();
        $table->string('lembaga')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skemas');
    }
};
