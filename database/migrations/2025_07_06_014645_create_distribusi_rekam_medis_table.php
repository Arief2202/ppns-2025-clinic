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
        Schema::create('distribusi_rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal_distribusi');
            $table->string('tujuan');
            $table->string('dokumentasi_distribusi');
            $table->foreignId('editor_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_rekam_medis');
    }
};
