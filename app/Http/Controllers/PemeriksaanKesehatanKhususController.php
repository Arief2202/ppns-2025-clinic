<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanKesehatanKhusus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PemeriksaanKesehatanKhususController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('PemeriksaanKesehatanKhusus', [
            'datas' => PemeriksaanKesehatanKhusus::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/SMK3/pemeriksaan-kesehatan/pemeriksaan-kesehatan-khusus';
        $fileName = date("YmdHis").'_'.$request->dokumen_hasil_pemeriksaan->getClientOriginalName();
        $request->dokumen_hasil_pemeriksaan->move(public_path($destinationPath), $fileName);
        PemeriksaanKesehatanKhusus::create([
            'id_pekerja' => $request->id_pekerja,
            'nama_pekerja' => $request->nama_pekerja,
            'bagian' => $request->bagian,
            'alasan_pemeriksaan' => $request->alasan_pemeriksaan,
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'hasil' => $request->hasil,
            'catatan' => $request->catatan,
            'dokumen_hasil_pemeriksaan' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus');
    }
    public function edit(Request $request)
    {
        $data = PemeriksaanKesehatanKhusus::where('id', "=", $request->id)->first();
        if($data){
            $data->editor_id = Auth::user()->id;
            if(isset($request->id_pekerja)) $data->id_pekerja = $request->id_pekerja;
            if(isset($request->nama_pekerja)) $data->nama_pekerja = $request->nama_pekerja;
            if(isset($request->bagian)) $data->bagian = $request->bagian;
            if(isset($request->alasan_pemeriksaan)) $data->alasan_pemeriksaan = $request->alasan_pemeriksaan;
            if(isset($request->tanggal_pemeriksaan)) $data->tanggal_pemeriksaan = $request->tanggal_pemeriksaan;
            if(isset($request->hasil)) $data->hasil = $request->hasil;
            if(isset($request->catatan)) $data->catatan = $request->catatan;
            if($request->dokumen_hasil_pemeriksaan){
                File::delete(public_path().$data->dokumen_hasil_pemeriksaan);
                $destinationPath = 'uploads/SMK3/pemeriksaan-kesehatan/pemeriksaan-kesehatan-khusus';
                $fileName = date("YmdHis").'_'.$request->dokumen_hasil_pemeriksaan->getClientOriginalName();
                $request->dokumen_hasil_pemeriksaan->move(public_path($destinationPath), $fileName);
                $data->dokumen_hasil_pemeriksaan = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus');
    }
    public function delete(Request $request)
    {
        $data = PemeriksaanKesehatanKhusus::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_hasil_pemeriksaan);
            $data->delete();
        }
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus');
    }
    public function getById(Request $request)
    {
        $user = PemeriksaanKesehatanKhusus::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
}
