<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemusnahanObat extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function editor(){
        return User::where('id', $this->editor_id)->first();
    }
    public function validator(){
        return User::where('id', $this->validator_id)->first();
    }
    public function pengadaan(){
        return PengadaanPenerimaanObat::where('id', $this->pengadaan_id)->first();
    }
    public function items(){
        return DetailPemusnahanObat::where('pemusnahan_id', $this->id)->get();
    }
}
