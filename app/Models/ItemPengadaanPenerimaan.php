<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ItemPengadaanPenerimaan extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function obatBMHP(){
        return obatBMHP::where('id', $this->obat_bmhp_id)->first();
    }
    public function pengadaan(){
        return PengadaanPenerimaanObat::where('id', $this->pengadaan_id)->first();
    }
    public function hasExpired(){
        $expiredFound = 0;
        $now = Carbon::now();
        $expired = Carbon::parse(date('Y-m-d', strtotime($this->tanggal_kadaluarsa)));
        if($now->gt($expired)) $expiredFound = 1;
        return $expiredFound;
    }
}
