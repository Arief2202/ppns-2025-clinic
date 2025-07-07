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
        Schema::create('item_pengadaan_penerimaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengadaan_id');
            $table->foreignId('obat_bmhp_id');
            $table->string('jumlah');
            $table->timestamp('tanggal_kadaluarsa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pengadaan_penerimaans');
    }
};
