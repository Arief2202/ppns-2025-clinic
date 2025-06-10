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
        Schema::create('standard_operasional_prosedur_kliniks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sop');
            $table->string('dokumen_sop');
            $table->timestamp('tanggal_peninjauan');
            $table->foreignId('editor_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standard_operasional_prosedur_kliniks');
    }
};
