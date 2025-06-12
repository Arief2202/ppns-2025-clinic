<?php

namespace App\Http\Controllers;

use App\Models\IzinPendirianDanOperasionalKlinik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class IzinPendirianDanOperasionalKlinikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('IzinPendirianDanOperasionalKlinik', [
            'datas' => IzinPendirianDanOperasionalKlinik::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/sarana-prasarana/surat-izin-klinik';
        $fileName = date("YmdHis").'_'.$request->dokumen_surat->getClientOriginalName();
        $request->dokumen_surat->move(public_path($destinationPath), $fileName);
        IzinPendirianDanOperasionalKlinik::create([
            'judul_surat' => $request->judul_surat,
            'tanggal_terbit' => $request->tanggal_terbit,
            'berlaku_hingga' => $request->berlaku_hingga,
            'dokumen_surat' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/sarana-prasarana/izin-pendirian-dan-operasional-klinik');
    }
    public function edit(Request $request)
    {
        $data = IzinPendirianDanOperasionalKlinik::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->judul_surat)) $data->judul_surat = $request->judul_surat;
            if(isset($request->tanggal_terbit)) $data->tanggal_terbit = $request->tanggal_terbit;
            if(isset($request->berlaku_hingga)) $data->berlaku_hingga = $request->berlaku_hingga;
            if($request->dokumen_surat){
                File::delete(public_path().$data->dokumen_surat);
                $destinationPath = 'uploads/sarana-prasarana/surat-izin-klinik';
                $fileName = date("YmdHis").'_'.$request->dokumen_surat->getClientOriginalName();
                $request->dokumen_surat->move(public_path($destinationPath), $fileName);
                $data->dokumen_surat = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/sarana-prasarana/izin-pendirian-dan-operasional-klinik');
    }
    public function delete(Request $request)
    {
        $data = IzinPendirianDanOperasionalKlinik::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_surat);
            $data->delete();
        }
        return redirect('/sarana-prasarana/izin-pendirian-dan-operasional-klinik');
    }
    public function getById(Request $request)
    {
        $user = IzinPendirianDanOperasionalKlinik::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(){
        if(Auth::user()->role_id != 4) return redirect('/');
        $datas = IzinPendirianDanOperasionalKlinik::first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/sarana-prasarana/izin-pendirian-dan-operasional-klinik');
    }
}
