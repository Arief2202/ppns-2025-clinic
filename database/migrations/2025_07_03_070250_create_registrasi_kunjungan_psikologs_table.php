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
        Schema::create('registrasi_kunjungan_psikologs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id');
            $table->foreignId('pemeriksa_id');
            $table->timestamp('tanggal_kunjungan');
            $table->foreignId('editor_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_kunjungan_psikologs');
    }
};
