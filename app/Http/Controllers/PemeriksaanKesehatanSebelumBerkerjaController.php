<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanKesehatanSebelumBerkerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PemeriksaanKesehatanSebelumBerkerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('PemeriksaanKesehatanSebelumBerkerja', [
            'datas' => PemeriksaanKesehatanSebelumBerkerja::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/SMK3/pemeriksaan-kesehatan/pemeriksaan-kesehatan-sebelum-bekerja';
        $fileName = date("YmdHis").'_'.$request->dokumen_hasil_pemeriksaan->getClientOriginalName();
        $request->dokumen_hasil_pemeriksaan->move(public_path($destinationPath), $fileName);
        PemeriksaanKesehatanSebelumBerkerja::create([
            'id_pekerja' => $request->id_pekerja,
            'nama_pekerja' => $request->nama_pekerja,
            'bagian' => $request->bagian,
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'hasil' => $request->hasil,
            'catatan' => $request->catatan,
            'dokumen_hasil_pemeriksaan' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja');
    }
    public function edit(Request $request)
    {
        $data = PemeriksaanKesehatanSebelumBerkerja::where('id', "=", $request->id)->first();
        if($data){
            $data->editor_id = Auth::user()->id;
            if(isset($request->id_pekerja)) $data->id_pekerja = $request->id_pekerja;
            if(isset($request->nama_pekerja)) $data->nama_pekerja = $request->nama_pekerja;
            if(isset($request->bagian)) $data->bagian = $request->bagian;
            if(isset($request->tanggal_pemeriksaan)) $data->tanggal_pemeriksaan = $request->tanggal_pemeriksaan;
            if(isset($request->hasil)) $data->hasil = $request->hasil;
            if(isset($request->catatan)) $data->catatan = $request->catatan;
            if($request->dokumen_hasil_pemeriksaan){
                File::delete(public_path().$data->dokumen_hasil_pemeriksaan);
                $destinationPath = 'uploads/SMK3/pemeriksaan-kesehatan/pemeriksaan-kesehatan-sebelum-bekerja';
                $fileName = date("YmdHis").'_'.$request->dokumen_hasil_pemeriksaan->getClientOriginalName();
                $request->dokumen_hasil_pemeriksaan->move(public_path($destinationPath), $fileName);
                $data->dokumen_hasil_pemeriksaan = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja');
    }
    public function delete(Request $request)
    {
        $data = PemeriksaanKesehatanSebelumBerkerja::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_hasil_pemeriksaan);
            $data->delete();
        }
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja');
    }
    public function getById(Request $request)
    {
        $user = PemeriksaanKesehatanSebelumBerkerja::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
}
