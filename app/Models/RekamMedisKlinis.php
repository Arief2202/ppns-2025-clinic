<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedisKlinis extends Model
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
    public function registrasi(){
        return RegistrasiKunjunganKlinis::where('id', $this->registrasi_id)->first();
    }
    public function penggunaanObatBMHP(){
        return DetailPenggunaanObatBMHP::where('rekam_medis_klinis_id', $this->id)->get();
    }
}
