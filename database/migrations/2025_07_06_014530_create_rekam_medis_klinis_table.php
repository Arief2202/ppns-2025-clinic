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
        Schema::create('rekam_medis_klinis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id');
            $table->string('kode_icd');
            $table->string('gejala');
            $table->string('diagnosis');
            $table->string('tindakan_medis');
            $table->string('dokumentasi_resep');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis_klinis');
    }
};
