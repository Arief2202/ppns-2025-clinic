<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function umur()
    {
        return ((int) date("Y")) - ((int) date("Y", strtotime($this->tanggal_lahir)));
    }
}
