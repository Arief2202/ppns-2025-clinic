<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengadaanPenerimaanObatRequest;
use App\Http\Requests\UpdatePengadaanPenerimaanObatRequest;
use App\Models\DetailPemusnahanObat;
use App\Models\PengadaanPenerimaanObat;
use App\Models\ItemPengadaanPenerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KorbanKecelakaan;
use App\Models\ObatBMHP;
use App\Models\PemusnahanObat;
use Illuminate\Support\Facades\File;

class PengadaanPenerimaanObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('PengadaanObatBMHP', [
            'datas' => PengadaanPenerimaanObat::all(),
        ]);
    }
    public function indexPenerimaan()
    {
        return view('PenerimaanObatBMHP', [
            'datas' => PengadaanPenerimaanObat::where('validator_pengadaan_id', '!=', null)->get(),
        ]);
    }
    public function detail(Request $request)
    {
        $data = PengadaanPenerimaanObat::where('id', "=", $request->id)->first();
        if($data){
            $itemsAdded = ItemPengadaanPenerimaan::where('pengadaan_id', '=', $request->id)->get()->pluck('obat_bmhp_id');
            $items = ObatBMHP::whereNotIn('id', $itemsAdded)->get();
            return view('PengadaanObatBMHPDetail', [
                'data' => $data,
                'items' => $items,
            ]);
        }
        return redirect('/manajemen-farmasi/pengadaan');
    }

    public function detailPenerimaan(Request $request)
    {
        $data = PengadaanPenerimaanObat::where('id', "=", $request->id)->first();
        if($data){
            $itemsAdded = ItemPengadaanPenerimaan::where('pengadaan_id', '=', $request->id)->get()->pluck('obat_bmhp_id');
            $items = ObatBMHP::whereNotIn('id', $itemsAdded)->get();
            return view('PenerimaanObatBMHPDetail', [
                'data' => $data,
                'items' => $items,
            ]);
        }
        return redirect('/manajemen-farmasi/pengadaan');
    }
    public function editPenerimaan(Request $request){
        $itemPengadaan = ItemPengadaanPenerimaan::where('id', '=', $request->id)->first();
        if($itemPengadaan){
            // $pengadaan = PengadaanPenerimaanObat::where('id', $itemPengadaan->pengadaan_id)->first();
            // if($pengadaan){
            //     $pengadaan->editor_penerimaan_id = Auth::user()->id;
            //     $pengadaan->save();
            // }
            $itemPengadaan->tanggal_kadaluarsa = $request->tanggal_kadaluarsa;
            $itemPengadaan->save();
        }
        return redirect()->back();
    }

    public function addItem(Request $request){
        $obat_bmhp_id = $request->obat_bmhp_id;
        if(isset($request->nama)){
            $obatFind = ObatBMHP::where('nama', "=", $request->nama)->first();
            if($obatFind) return redirect('/manajemen-farmasi/pengadaan/detail?id='.$request->pengadaan_id);
            $obatbmhp = ObatBMHP::create([
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'satuan' => $request->satuan,
                'tempat_penyimpanan' => $request->tempat_penyimpanan,
                'editor_id' => Auth::user()->id,
            ]);
            $obat_bmhp_id = $obatbmhp->id;
            $data = ItemPengadaanPenerimaan::create([
                'pengadaan_id' => $request->pengadaan_id,
                'obat_bmhp_id' => $obatbmhp->id,
                'jumlah' => $request->jumlah,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'status' => $request->status
            ]);
        }
        else{
            $data = ItemPengadaanPenerimaan::create([
                'pengadaan_id' => $request->pengadaan_id,
                'obat_bmhp_id' => $request->obat_bmhp_id,
                'jumlah' => $request->jumlah,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'status' => $request->status
            ]);
        }
        $pemusnahanFind = PemusnahanObat::where('pengadaan_id', $request->pengadaan_id)->first();
        if($pemusnahanFind){
            DetailPemusnahanObat::create([
                'pemusnahan_id' => $pemusnahanFind->id,
                'obat_bmhp_id' => $obat_bmhp_id,
                'jumlah' => 0
            ]);
        }
        return redirect('/manajemen-farmasi/pengadaan/detail?id='.$request->pengadaan_id);

    }
    public function deleteItem(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $data = ItemPengadaanPenerimaan::where('id', "=", $request->id)->first();
        if($data){
            $pemusnahanFind = PemusnahanObat::where('pengadaan_id', $data->pengadaan_id)->first();
            if($pemusnahanFind) DetailPemusnahanObat::where('obat_bmhp_id', $data->obat_bmhp_id)->first()->delete();
            $data->delete();
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $destinationPath = 'uploads/manajemen-farmasi/pengadaan';
        $fileName = date("YmdHis").'.'.$request->dokumen_pengadaan->extension();
        $request->dokumen_pengadaan->move(public_path($destinationPath), $fileName);
        $data = PengadaanPenerimaanObat::create([
            'nomor_pengadaan' => $request->nomor_pengadaan,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'dokumen_pengadaan' => '/'.$destinationPath.'/'.$fileName,
            'catatan' => $request->catatan,
            'status' => $request->status,
            'editor_pengadaan_id' => Auth::user()->id,
        ]);
        return redirect('/manajemen-farmasi/pengadaan/detail?id='.$data->id);
    }
    public function edit(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $data = PengadaanPenerimaanObat::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_pengadaan_id = null;
            $data->editor_pengadaan_id = Auth::user()->id;

            if($request->dokumen_pengadaan){
                File::delete(public_path().$data->dokumen_pengadaan);
                $destinationPath = 'uploads/manajemen-farmasi/pengadaan';
                $fileName = date("YmdHis").'_'.$request->dokumen_pengadaan->getClientOriginalName();
                $request->dokumen_pengadaan->move(public_path($destinationPath), $fileName);
                $data->dokumen_pengadaan = '/'.$destinationPath.'/'.$fileName;
            }
            if(isset($request->nomor_pengadaan)) $data->nomor_pengadaan = $request->nomor_pengadaan;
            if(isset($request->tanggal_pengadaan)) $data->tanggal_pengadaan = $request->tanggal_pengadaan;
            if(isset($request->catatan)) $data->catatan = $request->catatan;
            if(isset($request->status)) $data->status = $request->status;
            $data->save();
        }
        return redirect($request->from_link);
    }
    public function delete(Request $request)
    {
        if(Auth::user()->role_id != 6) return redirect('/');
        $data = PengadaanPenerimaanObat::where('id', "=", $request->id)->first();
        if($data){
            foreach(ItemPengadaanPenerimaan::where('pengadaan_id', '=', $data->id)->get() as $item){
                $item->delete();
            }

            $pemusnahanFind = PemusnahanObat::where('pengadaan_id', $data->id)->first();
            if($pemusnahanFind){
                foreach($pemusnahanFind->items() as $item) $item->delete();
                $pemusnahanFind->delete();
            }
            $data->delete();
        }
        return redirect('/manajemen-farmasi/pengadaan');
    }
    public function getById(Request $request)
    {
        $user = PengadaanPenerimaanObat::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data_pengadaan(Request $request){
        if(Auth::user()->role_id != 1) return redirect('/');
        $datas = PengadaanPenerimaanObat::where("id", "=", $request->id)->first();
        $datas->validator_pengadaan_id = Auth::user()->id;
        $datas->status = "Pengadaan diproses";
        $datas->save();
        return redirect('/manajemen-farmasi/pengadaan');
    }
    public function validate_data_penerimaan(Request $request){
        if(Auth::user()->role_id != 1) return redirect('/');
        $datas = PengadaanPenerimaanObat::where("id", "=", $request->id)->first();
        $datas->validator_penerimaan_id = Auth::user()->id;
        $datas->status = "Selesai";
        $datas->save();
        return redirect()->back();
    }

    public function createPenerimaan(Request $request){
        if(Auth::user()->role_id != 6) return redirect('/');
        $data = PengadaanPenerimaanObat::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_penerimaan_id = null;
            $data->editor_penerimaan_id = Auth::user()->id;

            if($request->dokumen_penerimaan){
                $destinationPath = 'uploads/manajemen-farmasi/penerimaan';
                $fileName = date("YmdHis").'_'.$request->dokumen_penerimaan->getClientOriginalName();
                $request->dokumen_penerimaan->move(public_path($destinationPath), $fileName);
                $data->dokumen_penerimaan = '/'.$destinationPath.'/'.$fileName;
            }
            if(isset($request->tanggal_penerimaan)) $data->tanggal_penerimaan = $request->tanggal_penerimaan;
            $data->status = "Menunggu Validasi Penerimaan";
            $data->save();
        }
        return redirect()->back();
    }
    public function cancelPenerimaan(Request $request){
        if(Auth::user()->role_id != 6) return redirect('/');
        $data = PengadaanPenerimaanObat::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_penerimaan);
            $data->dokumen_penerimaan = null;
            $data->tanggal_penerimaan = null;
            $data->editor_penerimaan_id = null;
            $data->validator_penerimaan_id = null;
            $data->status = "Menunggu Penerimaan";
            $data->save();

            $pemusnahanFind = PemusnahanObat::where('pengadaan_id', $request->id)->first();
            if($pemusnahanFind){
                foreach($pemusnahanFind->items() as $item) $item->delete();
                $pemusnahanFind->delete();
            }
        }
        return redirect()->back();
    }
}
