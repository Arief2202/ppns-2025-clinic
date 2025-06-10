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
        Schema::create('izin_pendirian_dan_operasional_kliniks', function (Blueprint $table) {
            $table->id();
            $table->string('judul_surat');
            $table->timestamp('tanggal_terbit');
            $table->timestamp('berlaku_hingga');
            $table->string('dokumen_surat');
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
        Schema::dropIfExists('izin_pendirian_dan_operasional_kliniks');
    }
};
