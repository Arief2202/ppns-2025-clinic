<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiKunjunganKlinis extends Model
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
    public function pasien(){
        return Pasien::where('id', $this->pasien_id)->first();
    }
    public function pemeriksa(){
        return User::where('id', $this->pemeriksa_id)->first();
    }
    public function items(){
        return RekamMedisKlinis::where('registrasi_id', $this->id)->get();
    }
}
