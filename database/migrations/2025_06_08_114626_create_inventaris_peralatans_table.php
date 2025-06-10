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
        Schema::create('inventaris_peralatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori_peralatan');
            $table->integer('jumlah');
            $table->string('kondisi');
            $table->timestamp('tanggal_inspeksi');
            $table->string('dokumen_inspeksi');
            $table->timestamp('tanggal_kalibrasi');
            $table->string('dokumen_kalibrasi');
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
        Schema::dropIfExists('inventaris_peralatans');
    }
};
