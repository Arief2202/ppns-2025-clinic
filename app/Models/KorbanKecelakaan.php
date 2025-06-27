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
}
