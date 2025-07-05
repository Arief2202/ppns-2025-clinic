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
        Schema::create('data_kesehatan_mentals', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal_pendataan');
            $table->string('nama_dokumen');
            $table->string('dokumen_kesehatan_mental');
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
        Schema::dropIfExists('data_kesehatan_mentals');
    }
};
