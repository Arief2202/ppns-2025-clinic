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
        Schema::create('obat_b_m_h_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori');
            $table->string('satuan');
            $table->string('tempat_penyimpanan');
            $table->foreignId('editor_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_b_m_h_p_s');
    }
};
