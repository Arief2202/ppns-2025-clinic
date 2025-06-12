<?php

namespace App\Http\Controllers;

use App\Models\InventarisPeralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class InventarisPeralatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('InventarisPeralatan', [
            'datas' => InventarisPeralatan::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/sarana-prasarana/inventaris-peralatan';
        $fileName = date("YmdHis").'_inspeksi_'.$request->dokumen_inspeksi->getClientOriginalName();
        $fileName2 = date("YmdHis").'_kalibrasi_'.$request->dokumen_kalibrasi->getClientOriginalName();
        $request->dokumen_inspeksi->move(public_path($destinationPath), $fileName);
        $request->dokumen_kalibrasi->move(public_path($destinationPath), $fileName2);
        InventarisPeralatan::create([
            'nama' => $request->nama,
            'kategori_peralatan' => $request->kategori_peralatan,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'tanggal_inspeksi' => $request->tanggal_inspeksi,
            'tanggal_kalibrasi' => $request->tanggal_kalibrasi,
            'dokumen_inspeksi' => '/'.$destinationPath.'/'.$fileName,
            'dokumen_kalibrasi' => '/'.$destinationPath.'/'.$fileName2,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/sarana-prasarana/inventaris-peralatan');
    }
    public function edit(Request $request)
    {
        $destinationPath = 'uploads/sarana-prasarana/inventaris-peralatan';
        $data = InventarisPeralatan::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->nama)) $data->nama = $request->nama;
            if(isset($request->kategori_peralatan)) $data->kategori_peralatan = $request->kategori_peralatan;
            if(isset($request->jumlah)) $data->jumlah = $request->jumlah;
            if(isset($request->kondisi)) $data->kondisi = $request->kondisi;
            if(isset($request->tanggal_inspeksi)) $data->tanggal_inspeksi = $request->tanggal_inspeksi;
            if(isset($request->tanggal_kalibrasi)) $data->tanggal_kalibrasi = $request->tanggal_kalibrasi;

            if($request->dokumen_inspeksi){
                File::delete(public_path().$data->dokumen_inspeksi);
                $fileName = date("YmdHis").'_inspeksi_'.$request->dokumen_inspeksi->getClientOriginalName();
                $request->dokumen_inspeksi->move(public_path($destinationPath), $fileName);
                $data->dokumen_inspeksi = '/'.$destinationPath.'/'.$fileName;
            }
            if($request->dokumen_kalibrasi){
                File::delete(public_path().$data->dokumen_kalibrasi);
                $fileName2 = date("YmdHis").'_kalibrasi_'.$request->dokumen_kalibrasi->getClientOriginalName();
                $request->dokumen_kalibrasi->move(public_path($destinationPath), $fileName2);
                $data->dokumen_kalibrasi = '/'.$destinationPath.'/'.$fileName2;
            }
            $data->save();
        }
        return redirect('/sarana-prasarana/inventaris-peralatan');
    }
    public function delete(Request $request)
    {
        $data = InventarisPeralatan::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_inspeksi);
            File::delete(public_path().$data->dokumen_kalibrasi);
            $data->delete();
        }
        return redirect('/sarana-prasarana/inventaris-peralatan');
    }
    public function getById(Request $request)
    {
        $user = InventarisPeralatan::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(){
        if(Auth::user()->role_id != 1) return redirect('/');
        $datas = InventarisPeralatan::first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/sarana-prasarana/inventaris-peralatan');
    }
}
