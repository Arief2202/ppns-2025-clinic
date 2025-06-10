<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFasilitasPrasaranaRequest;
use App\Http\Requests\UpdateFasilitasPrasaranaRequest;
use App\Models\FasilitasPrasarana;
use App\Models\User;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class FasilitasPrasaranaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role_id != 1) return redirect('/');
        return view('FasilitasPrasarana', [
            'datas' => FasilitasPrasarana::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/sarana-prasarana/fasilitas-prasarana';
        $fileName = date("YmdHis").'_'.$request->dokumen_inspeksi->getClientOriginalName();
        $request->dokumen_inspeksi->move(public_path($destinationPath), $fileName);
        FasilitasPrasarana::create([
            'nama' => $request->nama,
            'kondisi' => $request->kondisi,
            'tanggal_inspeksi' => $request->tanggal_inspeksi,
            'dokumen_inspeksi' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/sarana-prasarana/fasilitas-prasarana');
    }
    public function edit(Request $request)
    {
        $data = FasilitasPrasarana::where('id', "=", $request->id)->first();
        $data->validator_id = null;
        $data->editor_id = Auth::user()->id;
        if(isset($request->nama)) $data->nama = $request->nama;
        if(isset($request->kondisi)) $data->kondisi = $request->kondisi;
        if(isset($request->tanggal_inspeksi)) $data->tanggal_inspeksi = $request->tanggal_inspeksi;
        if($request->dokumen_inspeksi){
            File::delete(public_path().$data->dokumen_inspeksi);
            $destinationPath = 'uploads/sarana-prasarana/fasilitas-prasarana';
            $fileName = date("YmdHis").'_'.$request->dokumen_inspeksi->getClientOriginalName();
            $request->dokumen_inspeksi->move(public_path($destinationPath), $fileName);
            $data->dokumen_inspeksi = '/'.$destinationPath.'/'.$fileName;
        }
        $data->save();
        return redirect('/sarana-prasarana/fasilitas-prasarana');
    }
    public function delete(Request $request)
    {
        $data = FasilitasPrasarana::where('id', "=", $request->id)->first();
        if($data){
            try{
                File::delete(public_path().$data->dokumen_inspeksi);
            }catch (Exception $e){}
            $data->delete();
        }
        return redirect('/sarana-prasarana/fasilitas-prasarana');
    }
    public function getById(Request $request)
    {
        $user = FasilitasPrasarana::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(){
        if(Auth::user()->role_id != 1) return redirect('/');
        $datas = FasilitasPrasarana::first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/sarana-prasarana/fasilitas-prasarana');
    }
}
