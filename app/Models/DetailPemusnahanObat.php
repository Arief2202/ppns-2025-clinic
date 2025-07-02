<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemusnahanObat extends Model
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
    public function pemusnahan(){
        return PemusnahanObat::where('id', $this->pemusnahan_id)->first();
    }
    public function obatBMHP(){
        return ObatBMHP::where('id', $this->obat_bmhp_id)->first();
    }
}
