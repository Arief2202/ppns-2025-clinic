<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanPenerimaanObat extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function editorPengadaan(){
        return User::where('id', $this->editor_pengadaan_id)->first();
    }
    public function validatorPengadaan(){
        return User::where('id', $this->validator_pengadaan_id)->first();
    }
    public function editorPenerimaan(){
        return User::where('id', $this->editor_penerimaan_id)->first();
    }
    public function validatorPenerimaan(){
        return User::where('id', $this->validator_penerimaan_id)->first();
    }
    public function items(){
        return ItemPengadaanPenerimaan::where('pengadaan_id', $this->id)->get();
    }
    public function checkExpired(){
        $found = false;
        foreach($this->items() as $item){
            if($item->tanggal_kadaluarsa == null)$found = true;
        }
        return $found;
    }
}
