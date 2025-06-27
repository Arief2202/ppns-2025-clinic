<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KorbanKecelakaan extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function pasien(){
        return Pasien::where('id', $this->pasien_id)->first();
    }
    public function laporan(){
        return LaporanKecelakaanKerja::where('id', $this->laporan_id)->first();
    }
}
