<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ObatBMHP extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function editor(){
        return User::where('id', $this->editor_id)->first();
    }
    public function stok(){
        $count = 0;
        foreach(ItemPengadaanPenerimaan::where('obat_bmhp_id', $this->id)->get() as $item){
            if($item->pengadaan()->validator_penerimaan_id != null){
                $count += $item->jumlah;
                $pemusnahan = PemusnahanObat::where('pengadaan_id', $item->pengadaan()->id)->where('validator_id', '!=', null)->first();
                if($pemusnahan){
                    $count -= $pemusnahan->items()->where('obat_bmhp_id', $item->obat_bmhp_id)->first()->jumlah;
                }
            }
        }
        foreach(DetailPenggunaanObatBMHP::where('obat_bmhp_id', $this->id)->get() as $item) $count -= $item->jumlah;
        return $count;
    }
    public function hasExpired(){
        $expiredFound = 0;
        $now = Carbon::now();
        foreach(ItemPengadaanPenerimaan::where('obat_bmhp_id', $this->id)->get() as $item){
            $expired = Carbon::parse(date('Y-m-d', strtotime($item->tanggal_kadaluarsa)));
            $pemusnahanObat = PemusnahanObat::where('pengadaan_id', $item->pengadaan()->id)->first();
            if($pemusnahanObat){
                if($item->jumlah > $pemusnahanObat->items()->where('obat_bmhp_id', $item->obat_bmhp_id)->first()->jumlah){
                    if($now->gt($expired)) $expiredFound = 1;
                }
            }
            else{
                if($now->gt($expired) && $this->stok() != 0) $expiredFound = 1;
            }

        }
        return $expiredFound;
    }
}
