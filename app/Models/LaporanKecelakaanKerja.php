<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKecelakaanKerja extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function korban(){
        return KorbanKecelakaan::where('laporan_id', $this->id)->get();
    }
    public function editor(){
        return User::where('id', $this->editor_id)->first();
    }
    public function validator(){
        return User::where('id', $this->validator_id)->first();
    }
    public function korbans(){
        return KorbanKecelakaan::where('laporan_id', $this->id)->get();
    }
}
