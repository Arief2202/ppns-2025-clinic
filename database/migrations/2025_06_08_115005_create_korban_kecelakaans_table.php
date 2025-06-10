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
        Schema::create('korban_kecelakaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('korban_id');
            $table->foreignId('laporan_id');
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->integer('usia');
            $table->string('bagian');
            $table->string('dampak_kejadian');
            $table->string('tindakan_pertolongan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korban_kecelakaans');
    }
};
