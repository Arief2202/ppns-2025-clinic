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
        Schema::create('detail_penggunaan_obat_b_m_h_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('rekam_medis_klinis_id');
            $table->string('obat_bmhp_id');
            $table->string('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penggunaan_obat_b_m_h_p_s');
    }
};
