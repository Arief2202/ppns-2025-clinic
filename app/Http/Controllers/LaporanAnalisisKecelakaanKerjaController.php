<?php

namespace App\Http\Controllers;

use App\Models\LaporanAnalisisKecelakaanKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\LaporanKecelakaanKerja;

class LaporanAnalisisKecelakaanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = LaporanAnalisisKecelakaanKerja::all();
        foreach($datas as $dt){
            $this->get_kecelakaan_count($dt->tahun);
        }
        return view('LaporanAnalisisKecelakaanKerja', [
            'datas' => $datas,
            'total' => $this->get_kecelakaan_count(date('Y'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = LaporanAnalisisKecelakaanKerja::where('tahun', "=", $request->tahun)->first();
        if($data) return redirect('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja');
        $destinationPath = 'uploads/pelaporan-kecelakaan-kerja/laporan-analisis';
        $fileName = date("YmdHis").'_'.$request->dokumen_laporan->getClientOriginalName();
        $request->dokumen_laporan->move(public_path($destinationPath), $fileName);
        $kecelakaan = $this->get_kecelakaan_count($request->tahun);

        LaporanAnalisisKecelakaanKerja::create([
            'tahun' => $request->tahun,
            'jumlah_kecelakaan' => $kecelakaan->jumlah_kecelakaan,
            'kecelakaan_ringan' => $kecelakaan->kecelakaan_ringan,
            'kecelakaan_sedang' => $kecelakaan->kecelakaan_sedang,
            'kecelakaan_berat' => $kecelakaan->kecelakaan_berat,
            'kecelakaan_fatality' => $kecelakaan->kecelakaan_fatality,
            'korban_meninggal' => $kecelakaan->korban_meninggal,
            'penyusun' => $request->penyusun,
            'dokumen_laporan' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja');
    }
    public function edit(Request $request)
    {
        $data = LaporanAnalisisKecelakaanKerja::where('id', "=", $request->id)->first();
        if($data){
            if(isset($request->tahun)){
                if($data->tahun != $request->tahun){
                    $data2 = LaporanAnalisisKecelakaanKerja::where('tahun', "=", $request->tahun)->first();
                    if($data2) return redirect('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja');
                    $data->tahun = $request->tahun;
                }
            }
            if(isset($request->penyusun)) $data->penyusun = $request->penyusun;
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;

            if($request->dokumen_laporan){
                File::delete(public_path().$data->dokumen_laporan);
                $destinationPath = 'uploads/pelaporan-kecelakaan-kerja/laporan-analisis';
                $fileName = date("YmdHis").'_'.$request->dokumen_laporan->getClientOriginalName();
                $request->dokumen_laporan->move(public_path($destinationPath), $fileName);
                $data->dokumen_laporan = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja');
    }
    public function delete(Request $request)
    {
        $data = LaporanAnalisisKecelakaanKerja::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_laporan);
            $data->delete();
        }
        return redirect('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja');
    }
    public function getById(Request $request)
    {
        $user = LaporanAnalisisKecelakaanKerja::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(Request $request){
        if(Auth::user()->role_id != 3) return redirect('/');
        $datas = LaporanAnalisisKecelakaanKerja::where('id', "=", $request->id)->first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja');
    }

    public function get_kecelakaan_count($tahun){
        $kecelakaan = (object) [
                'jumlah_kecelakaan' => 0,
                'kecelakaan_ringan' => 0,
                'kecelakaan_sedang' => 0,
                'kecelakaan_berat' => 0,
                'kecelakaan_fatality' => 0,
                'korban_meninggal' => 0,
        ];
        $laporans = LaporanKecelakaanKerja::where('tanggal_kejadian', '>=', $tahun.'-01-01 00:00:00')->where('tanggal_kejadian', '<=', $tahun.'-12-31 23:59:59')->get();
        $kecelakaan->jumlah_kecelakaan = $laporans->count();
        $kecelakaan->kecelakaan_ringan = $laporans->where('jenis_kecelakaan', "Ringan")->count();
        $kecelakaan->kecelakaan_sedang = $laporans->where('jenis_kecelakaan', "Sedang")->count();
        $kecelakaan->kecelakaan_berat = $laporans->where('jenis_kecelakaan', "Berat")->count();
        $fatality = $laporans->where('jenis_kecelakaan', "Fatality");
        $kecelakaan->kecelakaan_fatality = $fatality->count();
        foreach($fatality as $fatal) $kecelakaan->korban_meninggal += $fatal->korbans()->count();
        $laporanAnalysis = LaporanAnalisisKecelakaanKerja::where('tahun', '=', $tahun)->first();
        if($laporanAnalysis){
            $laporanAnalysis->jumlah_kecelakaan = $kecelakaan->jumlah_kecelakaan;
            $laporanAnalysis->kecelakaan_ringan = $kecelakaan->kecelakaan_ringan;
            $laporanAnalysis->kecelakaan_sedang = $kecelakaan->kecelakaan_sedang;
            $laporanAnalysis->kecelakaan_berat = $kecelakaan->kecelakaan_berat;
            $laporanAnalysis->kecelakaan_fatality = $kecelakaan->kecelakaan_fatality;
            $laporanAnalysis->korban_meninggal = $kecelakaan->korban_meninggal;
            $laporanAnalysis->save();
        }
        return $kecelakaan;
    }
}
