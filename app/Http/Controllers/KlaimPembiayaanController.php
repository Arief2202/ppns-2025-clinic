<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKlaimPembiayaanRequest;
use App\Http\Requests\UpdateKlaimPembiayaanRequest;
use App\Models\KlaimPembiayaan;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class KlaimPembiayaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('KlaimPembiayaan', [
            'datas' => KlaimPembiayaan::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/rekam-medis/klaim-pembiayaan';
        $fileName = date("YmdHis").'_'.$request->dokumentasi_klaim->getClientOriginalName();
        $request->dokumentasi_klaim->move(public_path($destinationPath), $fileName);
        KlaimPembiayaan::create([
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'dokumentasi_klaim' => '/'.$destinationPath.'/'.$fileName,
            'status' => $request->status,
            'alasan_penolakan' => $request->alasan_penolakan,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/rekam-medis/klaim-pembiayaan');
    }
    public function edit(Request $request)
    {
        $data = KlaimPembiayaan::where('id', "=", $request->id)->first();
        if($data){
            $data->editor_id = Auth::user()->id;
            if(isset($request->tanggal_pengajuan)) $data->tanggal_pengajuan = $request->tanggal_pengajuan;
            if(isset($request->status)) $data->status = $request->status;
            if(isset($request->alasan_penolakan)) $data->alasan_penolakan = $request->alasan_penolakan;
            if($request->dokumentasi_klaim){
                File::delete(public_path().$data->dokumentasi_klaim);
                $destinationPath = 'uploads/rekam-medis/klaim-pembiayaan';
                $fileName = date("YmdHis").'_'.$request->dokumentasi_klaim->getClientOriginalName();
                $request->dokumentasi_klaim->move(public_path($destinationPath), $fileName);
                $data->dokumentasi_klaim = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/rekam-medis/klaim-pembiayaan');
    }
    public function delete(Request $request)
    {
        $data = KlaimPembiayaan::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumentasi_klaim);
            $data->delete();
        }
        return redirect('/rekam-medis/klaim-pembiayaan');
    }
    public function getById(Request $request)
    {
        $user = KlaimPembiayaan::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
}
