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
        Schema::create('pemusnahan_obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengadaan_id');
            $table->timestamp('tanggal_pemusnahan');
            $table->string('alasan_pemusnahan');
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
        Schema::dropIfExists('pemusnahan_obats');
    }
};
