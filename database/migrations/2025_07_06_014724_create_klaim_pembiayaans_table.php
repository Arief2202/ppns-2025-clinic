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
        Schema::create('klaim_pembiayaans', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal_pengajuan');
            $table->string('dokumentasi_klaim');
            $table->string('status');
            $table->string('alasan_penolakan')->nullable();
            $table->foreignId('editor_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klaim_pembiayaans');
    }
};
