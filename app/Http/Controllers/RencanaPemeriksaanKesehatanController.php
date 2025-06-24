<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRencanaPemeriksaanKesehatanRequest;
use App\Http\Requests\UpdateRencanaPemeriksaanKesehatanRequest;
use App\Models\RencanaPemeriksaanKesehatan;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class RencanaPemeriksaanKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('RencanaPemeriksaanKesehatan', [
            'datas' => RencanaPemeriksaanKesehatan::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 3) return redirect('/');
        RencanaPemeriksaanKesehatan::create([
            'jenis_pemeriksaan' => $request->jenis_pemeriksaan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'jumlah_peserta' => $request->jumlah_peserta,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan');
    }
    public function edit(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 3) return redirect('/');
        $data = RencanaPemeriksaanKesehatan::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->jenis_pemeriksaan)) $data->jenis_pemeriksaan = $request->jenis_pemeriksaan;
            if(isset($request->tanggal_pelaksanaan)) $data->tanggal_pelaksanaan = $request->tanggal_pelaksanaan;
            if(isset($request->jumlah_peserta)) $data->jumlah_peserta = $request->jumlah_peserta;
            $data->save();
        }
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan');
    }
    public function delete(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 3) return redirect('/');
        $data = RencanaPemeriksaanKesehatan::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_inspeksi);
            $data->delete();
        }
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan');
    }
    public function getById(Request $request)
    {
        $user = RencanaPemeriksaanKesehatan::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(Request $request){
        if(Auth::user()->role_id != 3) return redirect('/');
        $datas = RencanaPemeriksaanKesehatan::where("id", "=", $request->id)->first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan');
    }
}
