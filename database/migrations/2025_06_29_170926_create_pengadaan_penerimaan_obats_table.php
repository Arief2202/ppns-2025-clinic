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
        Schema::create('pengadaan_penerimaan_obats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengadaan');
            $table->timestamp('tanggal_pengadaan');
            $table->string('dokumen_pengadaan');
            $table->foreignId('editor_pengadaan_id');
            $table->foreignId('validator_pengadaan_id')->nullable();
            $table->timestamp('tanggal_penerimaan')->nullable();
            $table->string('dokumen_penerimaan')->nullable();
            $table->foreignId('editor_penerimaan_id')->nullable();
            $table->foreignId('validator_penerimaan_id')->nullable();
            $table->string('catatan');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_penerimaan_obats');
    }
};
