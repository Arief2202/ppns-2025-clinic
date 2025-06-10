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
        Schema::create('laporan_kecelakaan_kerjas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal_kejadian');
            $table->string('lokasi_kejadian');
            $table->string('jenis_kecelakaan');
            $table->string('uraian_kejadian');
            $table->string('berita_acara');
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
        Schema::dropIfExists('laporan_kecelakaan_kerjas');
    }
};
