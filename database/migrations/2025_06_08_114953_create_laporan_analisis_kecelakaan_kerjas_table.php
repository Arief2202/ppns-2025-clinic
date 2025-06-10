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
        Schema::create('laporan_analisis_kecelakaan_kerjas', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('jumlah_kecelakaan');
            $table->integer('kecelakaan_ringan');
            $table->integer('kecelakaan_sedang');
            $table->integer('kecelakaan_berat');
            $table->integer('kecelakaan_fatality');
            $table->integer('korban_meninggal');
            $table->string('penyusun');
            $table->string('dokumen_laporan');
            $table->foreignId('editor_id');
            $table->foreignId('validator_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_analisis_kecelakaan_kerjas');
    }
};
