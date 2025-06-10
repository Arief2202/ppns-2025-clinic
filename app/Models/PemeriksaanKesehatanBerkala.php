<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanKesehatanBerkala extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function editor(){
        return User::where('id', $this->editor_id)->first();
    }
}
