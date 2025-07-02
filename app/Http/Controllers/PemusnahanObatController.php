<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePemusnahanObatRequest;
use App\Http\Requests\UpdatePemusnahanObatRequest;
use App\Models\DetailPemusnahanObat;
use App\Models\PemusnahanObat;
use App\Models\ItemPengadaanPenerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KorbanKecelakaan;
use App\Models\ObatBMHP;
use App\Models\PengadaanPenerimaanObat;
use Illuminate\Support\Facades\File;

class PemusnahanObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('PemusnahanObatBMHP', [
            'datas' => PemusnahanObat::all(),
            'pengadaans' => PengadaanPenerimaanObat::where('validator_penerimaan_id', '!=', null)->get(),
        ]);
    }

    public function detail(Request $request)
    {
        $data = PemusnahanObat::where('id', "=", $request->id)->first();
        if($data){
            return view('PemusnahanObatBMHPDetail', [
                'data' => $data,
                'pengadaans' => PengadaanPenerimaanObat::where('validator_penerimaan_id', '!=', null)->get(),
            ]);
        }
        return redirect('/manajemen-farmasi/pemusnahan');
    }
    public function editItem(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $data = DetailPemusnahanObat::where('id', "=", $request->id)->first();
        if($data){
            if(isset($request->jumlah)) $data->jumlah = $request->jumlah;
            $data->save();
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $find = PemusnahanObat::where('pengadaan_id', '=', $request->pengadaan_id)->first();
        if($find) return redirect('/manajemen-farmasi/pemusnahan/detail?id='.$find->id);
        $find2 = PengadaanPenerimaanObat::where('id', '=', $request->pengadaan_id)->first();
        if(!$find2) return redirect('/manajemen-farmasi/pemusnahan');
        $data = PemusnahanObat::create([
            'pengadaan_id' => $request->pengadaan_id,
            'tanggal_pemusnahan' => $request->tanggal_pemusnahan,
            'alasan_pemusnahan' => $request->alasan_pemusnahan,
            'berita_acara' => $request->berita_acara,
            'editor_id' => Auth::user()->id,
        ]);
        foreach($find2->items() as $obat){
            DetailPemusnahanObat::create([
                'pemusnahan_id' => $data->id,
                'obat_bmhp_id' => $obat->obat_bmhp_id,
                'jumlah' => 0
            ]);
        }
        return redirect('/manajemen-farmasi/pemusnahan/detail?id='.$data->id);
    }
    public function edit(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $data = PemusnahanObat::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->tanggal_pemusnahan)) $data->tanggal_pemusnahan = $request->tanggal_pemusnahan;
            if(isset($request->alasan_pemusnahan)) $data->alasan_pemusnahan = $request->alasan_pemusnahan;
            if(isset($request->berita_acara)) $data->berita_acara = $request->berita_acara;
            $data->save();
        }
        return redirect($request->from_link);
    }
    public function delete(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $data = PemusnahanObat::where('id', "=", $request->id)->first();
        if($data){
            foreach($data->items() as $item){
                $item->delete();
            }
            $data->delete();
        }
        return redirect('/manajemen-farmasi/pemusnahan');
    }

    public function getById(Request $request)
    {
        $user = PemusnahanObat::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }

    public function validate_data(Request $request){
        if(Auth::user()->role_id != 1) return redirect('/');
        $datas = PemusnahanObat::where("id", "=", $request->id)->first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect()->back();
    }
}
