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
        Schema::create('health_risk_assesments', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal');
            $table->string('nama_dokumen');
            $table->string('dokumen_HRA');
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
        Schema::dropIfExists('health_risk_assesments');
    }
};
