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
        Schema::create('program_promotif_kesehatan_mentals', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->string('tujuan_program');
            $table->string('deskripsi_program');
            $table->timestamp('tanggal_pelaksanaan');
            $table->string('dokumentasi');
            $table->foreignId('editor_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_promotif_kesehatan_mentals');
    }
};
