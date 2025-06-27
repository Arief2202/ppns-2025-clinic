<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanKecelakaanKerjaRequest;
use App\Http\Requests\UpdateLaporanKecelakaanKerjaRequest;
use App\Models\LaporanKecelakaanKerja;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\KorbanKecelakaan;

class LaporanKecelakaanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('LaporanKecelakaanKerja', [
            'datas' => LaporanKecelakaanKerja::all(),
        ]);
    }
    public function detail(Request $request)
    {
        $data = LaporanKecelakaanKerja::where('id', "=", $request->id)->first();
        if($data){
            $korbans = KorbanKecelakaan::where('laporan_id', '=', $request->id)->get()->pluck('pasien_id');
            $pasiens = Pasien::whereNotIn('id', $korbans)->get();
            return view('LaporanKecelakaanKerjaDetail', [
                'data' => $data,
                'pasiens' => $pasiens,
            ]);
        }
        return redirect('/pelaporan-kecelakaan/laporan-kecelakaan-kerja');
    }

    public function addKorban(Request $request){
        if(isset($request->nip)){
            $pasienNIP = Pasien::where('nip', "=", $request->nip)->first();
            if($pasienNIP) return redirect('/pelaporan-kecelakaan/laporan-kecelakaan-kerja/detail?id='.$request->laporan_id);
            $pasien = Pasien::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'bagian' => $request->bagian,
                'tanggal_registrasi' => $request->tanggal_registrasi,
            ]);
            $data = KorbanKecelakaan::create([
                'laporan_id' => $request->laporan_id,
                'pasien_id' => $pasien->id,
                'dampak_kejadian' => $request->dampak_kejadian,
                'tindakan_pertolongan' => $request->tindakan_pertolongan,
            ]);
        }
        else{
            $data = KorbanKecelakaan::create([
                'laporan_id' => $request->laporan_id,
                'pasien_id' => $request->pasien_id,
                'dampak_kejadian' => $request->dampak_kejadian,
                'tindakan_pertolongan' => $request->tindakan_pertolongan,
            ]);
        }
        return redirect('/pelaporan-kecelakaan/laporan-kecelakaan-kerja/detail?id='.$request->laporan_id);

    }
    public function deleteKorban(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2 && Auth::user()->role_id != 3) return redirect('/');
        $data = KorbanKecelakaan::where('id', "=", $request->id)->first();
        if($data){
            $data->delete();
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2 && Auth::user()->role_id != 3) return redirect('/');
        $data = LaporanKecelakaanKerja::create([
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'lokasi_kejadian' => $request->lokasi_kejadian,
            'jenis_kecelakaan' => $request->jenis_kecelakaan,
            'uraian_kejadian' => $request->uraian_kejadian,
            'berita_acara' => $request->berita_acara,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/pelaporan-kecelakaan/laporan-kecelakaan-kerja/detail?id='.$data->id);
    }
    public function edit(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 3) return redirect('/');
        $data = LaporanKecelakaanKerja::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->tanggal_kejadian)) $data->tanggal_kejadian = $request->tanggal_kejadian;
            if(isset($request->lokasi_kejadian)) $data->lokasi_kejadian = $request->lokasi_kejadian;
            if(isset($request->jenis_kecelakaan)) $data->jenis_kecelakaan = $request->jenis_kecelakaan;
            if(isset($request->uraian_kejadian)) $data->uraian_kejadian = $request->uraian_kejadian;
            if(isset($request->berita_acara)) $data->berita_acara = $request->berita_acara;
            $data->save();
        }
        return redirect('/pelaporan-kecelakaan/laporan-kecelakaan-kerja/detail?id='.$data->id);
    }
    public function delete(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2 && Auth::user()->role_id != 3) return redirect('/');
        $data = LaporanKecelakaanKerja::where('id', "=", $request->id)->first();
        if($data){
            foreach(KorbanKecelakaan::where('laporan_id', '=', $data->id)->get() as $korban){
                $korban->delete();
            }
            $data->delete();
        }
        return redirect('/pelaporan-kecelakaan/laporan-kecelakaan-kerja');
    }
    public function getById(Request $request)
    {
        $user = LaporanKecelakaanKerja::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(Request $request){
        if(Auth::user()->role_id != 3) return redirect('/');
        $datas = LaporanKecelakaanKerja::where("id", "=", $request->id)->first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/pelaporan-kecelakaan/laporan-kecelakaan-kerja');
    }
}
