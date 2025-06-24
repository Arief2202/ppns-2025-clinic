<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanPelayananDanPemeriksaanKesehatanRequest;
use App\Http\Requests\UpdateLaporanPelayananDanPemeriksaanKesehatanRequest;
use App\Models\LaporanPelayananDanPemeriksaanKesehatan;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class LaporanPelayananDanPemeriksaanKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('LaporanPelayananDanPemeriksaanKesehatan', [
            'datas' => LaporanPelayananDanPemeriksaanKesehatan::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/SMK3/laporan-pelayanan';
        $fileName = date("YmdHis").'_'.$request->dokumen_laporan->getClientOriginalName();
        $request->dokumen_laporan->move(public_path($destinationPath), $fileName);
        LaporanPelayananDanPemeriksaanKesehatan::create([
            'nama_laporan' => $request->nama_laporan,
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'jenis_laporan' => $request->jenis_laporan,
            'dokumen_laporan' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan');
    }
    public function edit(Request $request)
    {
        $data = LaporanPelayananDanPemeriksaanKesehatan::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->nama_laporan)) $data->nama_laporan = $request->nama_laporan;
            if(isset($request->tanggal_pelaporan)) $data->tanggal_pelaporan = $request->tanggal_pelaporan;
            if(isset($request->jenis_laporan)) $data->jenis_laporan = $request->jenis_laporan;
            if($request->dokumen_laporan){
                File::delete(public_path().$data->dokumen_laporan);
                $destinationPath = 'uploads/SMK3/laporan-pelayanan';
                $fileName = date("YmdHis").'_'.$request->dokumen_laporan->getClientOriginalName();
                $request->dokumen_laporan->move(public_path($destinationPath), $fileName);
                $data->dokumen_laporan = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan');
    }
    public function delete(Request $request)
    {
        $data = LaporanPelayananDanPemeriksaanKesehatan::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_laporan);
            $data->delete();
        }
        return redirect('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan');
    }
    public function getById(Request $request)
    {
        $user = LaporanPelayananDanPemeriksaanKesehatan::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(Request $request){
        if(Auth::user()->role_id != 4) return redirect('/');
        $datas = LaporanPelayananDanPemeriksaanKesehatan::where('id', "=", $request->id)->first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan');
    }
}
