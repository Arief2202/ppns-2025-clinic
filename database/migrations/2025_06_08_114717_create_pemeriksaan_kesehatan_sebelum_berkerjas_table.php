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
        Schema::create('pemeriksaan_kesehatan_sebelum_berkerjas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pekerja');
            $table->string('nama_pekerja');
            $table->string('bagian');
            $table->timestamp('tanggal_pemeriksaan');
            $table->string('hasil');
            $table->string('catatan');
            $table->string('dokumen_hasil_pemeriksaan');
            $table->foreignId('editor_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_kesehatan_sebelum_berkerjas');
    }
};
