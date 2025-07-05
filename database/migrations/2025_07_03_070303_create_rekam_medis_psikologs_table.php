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
        Schema::create('rekam_medis_psikologs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id');
            $table->string('catatan_kondisi');
            $table->string('intervensi');
            $table->string('status_intervensi_lanjutan');
            $table->timestamp('tanggal_rujukan');
            $table->string('dokumen_rujukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis_psikologs');
    }
};
