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
        Schema::create('laporan_pelayanan_dan_pemeriksaan_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_laporan');
            $table->timestamp('tanggal_pelaporan');
            $table->string('jenis_laporan');
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
        Schema::dropIfExists('laporan_pelayanan_dan_pemeriksaan_kesehatans');
    }
};
