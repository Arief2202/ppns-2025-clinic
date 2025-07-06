<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObatBMHPRequest;
use App\Http\Requests\UpdateObatBMHPRequest;
use App\Models\DetailPemusnahanObat;
use App\Models\DetailPenggunaanObatBMHP;
use App\Models\ItemPengadaanPenerimaan;
use App\Models\ObatBMHP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ObatBMHPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexObat()
    {
        return view('ObatBMHP', [
            'title' => "Daftar Obat",
            'kategori' => "Obat",
            'datas' => ObatBMHP::where('kategori', 'Obat')->get()
        ]);
    }
    public function indexBMHP()
    {
        return view('ObatBMHP', [
            'title' => "Daftar BMHP",
            'kategori' => "BMHP",
            'datas' => ObatBMHP::where('kategori', 'BMHP')->get()
        ]);
    }
    public function indexListPengadaan(Request $request)
    {
        $obatBMHP = ObatBMHP::where('id', $request->id)->first();
        return view('ListPengadaanObatBMHP', [
            'title' => "List Pengadaan ".$obatBMHP->nama,
            'obatBMHP' => $obatBMHP,
            'datas' => ItemPengadaanPenerimaan::where('obat_bmhp_id', $request->id)->get()
        ]);
    }
    public function indexListPemusnahan(Request $request)
    {
        $obatBMHP = ObatBMHP::where('id', $request->id)->first();
        return view('ListPemusnahanObatBMHP', [
            'title' => "List Pemusnahan ".$obatBMHP->nama,
            'obatBMHP' => $obatBMHP,
            'datas' => DetailPemusnahanObat::where('obat_bmhp_id', $request->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        ObatBMHP::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'satuan' => $request->satuan,
            'tempat_penyimpanan' => $request->tempat_penyimpanan,
            'editor_id' => Auth::user()->id,
        ]);
        if($request->kategori == "Obat") return redirect('/manajemen-farmasi/daftar-obat');
        if($request->kategori == "BMHP") return redirect('/manajemen-farmasi/daftar-bmhp');
    }
    public function edit(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $ObatBMHP = ObatBMHP::where('id', "=", $request->id)->first();
        if(isset($request->nama)) $ObatBMHP->nama = $request->nama;
        if(isset($request->kategori)) $ObatBMHP->kategori = $request->kategori;
        if(isset($request->satuan)) $ObatBMHP->satuan = $request->satuan;
        if(isset($request->tempat_penyimpanan)) $ObatBMHP->tempat_penyimpanan = $request->tempat_penyimpanan;
        $ObatBMHP->save();
        if($ObatBMHP->kategori == "Obat") return redirect('/manajemen-farmasi/daftar-obat');
        if($ObatBMHP->kategori == "BMHP") return redirect('/manajemen-farmasi/daftar-bmhp');
    }
    public function delete(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $ObatBMHP = ObatBMHP::where('id', "=", $request->id)->first();
        if($ObatBMHP){
            $kategori = $ObatBMHP->kategori;
            foreach(ItemPengadaanPenerimaan::where('obat_bmhp_id', $ObatBMHP->id)->get() as $item) $item->delete();
            foreach(DetailPenggunaanObatBMHP::where('obat_bmhp_id', $ObatBMHP->id)->get() as $item) $item->delete();
            $ObatBMHP->delete();
        }
        if($kategori == "Obat") return redirect('/manajemen-farmasi/daftar-obat');
        if($kategori == "BMHP") return redirect('/manajemen-farmasi/daftar-bmhp');
    }
    public function getById(Request $request)
    {
        $ObatBMHP = ObatBMHP::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($ObatBMHP);die;
    }

}
