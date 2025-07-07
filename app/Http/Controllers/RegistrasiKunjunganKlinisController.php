<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrasiKunjunganKlinisRequest;
use App\Http\Requests\UpdateRegistrasiKunjunganKlinisRequest;
use App\Models\DetailPenggunaanObatBMHP;
use App\Models\ObatBMHP;
use App\Models\RegistrasiKunjunganKlinis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\User;
use App\Models\PemusnahanObat;
use App\Models\RegistrasiKunjunganPsikolog;
use App\Models\RekamMedisKlinis;
use Illuminate\Support\Facades\File;

class RegistrasiKunjunganKlinisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('RegistrasiKunjunganKlinis', [
            'datas' => RegistrasiKunjunganKlinis::all(),
            'pasiens' => Pasien::get(),
            'pemeriksas' =>User::where('role_id', 1)->get(),
        ]);
    }
    public function detail(Request $request)
    {
        $data = RegistrasiKunjunganKlinis::where('id', "=", $request->id)->first();
        if($data){
            // $itemsAdded = RekamMedisKlinis::where('registrasi_id', '=', $request->id)->get();
            // $items = ObatBMHP::whereNotIn('id', $itemsAdded)->get();
            return view('RegistrasiKunjunganKlinisDetail', [
                'data' => $data,
                'pasiens' => Pasien::get(),
                'pemeriksas' => User::where('role_id', 1)->get(),
                // 'items' => $items,
            ]);
        }
        return redirect('/rekam-medis/registrasi-kunjungan-klinis');
    }

    public function addItem(Request $request){
        $destinationPath = 'uploads/rekam-medis/rekam-medis-klinis';
        $fileName = date("YmdHis").'_'.$request->dokumentasi_resep->getClientOriginalName();
        $request->dokumentasi_resep->move(public_path($destinationPath), $fileName);
        $data = RekamMedisKlinis::create([
            'registrasi_id' => $request->registrasi_id,
            'kode_icd' => $request->kode_icd,
            'gejala' => $request->gejala,
            'diagnosis' => $request->diagnosis,
            'tindakan_medis' => $request->tindakan_medis,
            'dokumentasi_resep' => '/'.$destinationPath.'/'.$fileName,
            'status' => $request->status
        ]);
        return redirect()->back();
    }
    public function deleteItem(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2) return redirect('/');
        $data = RekamMedisKlinis::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumentasi_resep);
                foreach(DetailPenggunaanObatBMHP::where('rekam_medis_klinis_id', $data->id)->get() as $item2) $item2->delete();
            $data->delete();
        }
        return redirect()->back();
    }

    public function detailObatBMHP(Request $request)
    {
        $data = RekamMedisKlinis::where('id', "=", $request->id)->first();

        if($data){
            return view('RegistrasiKunjunganklinisDetailObatBMHP', [
                'data' => $data,
                'obatbmhps' => ObatBMHP::get()
            ]);
        }
        return redirect('/rekam-medis/registrasi-kunjungan-klinis');
    }

    public function addItemObatBMHP(Request $request){

        if(isset($request->nama)){
            $obatFind = ObatBMHP::where('nama', "=", $request->nama)->first();
            if($obatFind) return redirect('/manajemen-farmasi/pengadaan/detail?id='.$request->pengadaan_id);
            $obatbmhp = ObatBMHP::create([
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'satuan' => $request->satuan,
                'tempat_penyimpanan' => $request->tempat_penyimpanan,
                'editor_id' => Auth::user()->id,
            ]);
            $obat_bmhp_id = $obatbmhp->id;
            $data = DetailPenggunaanObatBMHP::create([
                'rekam_medis_klinis_id' => $request->rekam_medis_klinis_id,
                'obat_bmhp_id' => $obatbmhp->id,
                'jumlah' => $request->jumlah,
            ]);
        }
        else{
            $data = DetailPenggunaanObatBMHP::create([
                'rekam_medis_klinis_id' => $request->rekam_medis_klinis_id,
                'obat_bmhp_id' => $request->obat_bmhp_id,
                'jumlah' => $request->jumlah,
            ]);
        }
        return redirect()->back();

    }
    public function deleteItemObatBMHP(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2) return redirect('/');
        $data = DetailPenggunaanObatBMHP::where('id', "=", $request->id)->first();
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
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2) return redirect('/');
        if(isset($request->nip)){
            $newPasien = Pasien::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'bagian' => $request->bagian,
                'tanggal_registrasi' => $request->tanggal_registrasi,
            ]);
            $data = RegistrasiKunjunganKlinis::create([
                'pasien_id' => $newPasien->id,
                'pemeriksa_id' => $request->pemeriksa_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'editor_id' => Auth::user()->id,
            ]);
        }
        else{
            $data = RegistrasiKunjunganKlinis::create([
                'pasien_id' => $request->pasien_id,
                'pemeriksa_id' => $request->pemeriksa_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'editor_id' => Auth::user()->id,
            ]);
        }
        return redirect('/rekam-medis/registrasi-kunjungan-klinis/detail?id='.$data->id);
    }
    public function edit(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2) return redirect('/');
        $data = RegistrasiKunjunganKlinis::where('id', "=", $request->id)->first();
        if($data){
            $data->editor_id = Auth::user()->id;
            if(isset($request->pasien_id)) $data->pasien_id = $request->pasien_id;
            if(isset($request->pemeriksa_id)) $data->pemeriksa_id = $request->pemeriksa_id;
            if(isset($request->tanggal_kunjungan)) $data->tanggal_kunjungan = $request->tanggal_kunjungan;
            $data->save();
        }
        return redirect()->back();
    }
    public function delete(Request $request)
    {
        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2) return redirect('/');
        $data = RegistrasiKunjunganKlinis::where('id', "=", $request->id)->first();
        if($data){
            foreach(RekamMedisKlinis::where('registrasi_id', '=', $data->id)->get() as $item){
                foreach(DetailPenggunaanObatBMHP::where('rekam_medis_klinis_id', $item->id)->get() as $item2) $item2->delete();
                $item->delete();
            }
            $data->delete();
        }
    }

    public function getById(Request $request)
    {
        $user = RegistrasiKunjunganKlinis::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }

    public function statistikKodeIcd(Request $request)
    {
        $rekamMedisKlinis = RekamMedisKlinis::get();
        $kode_icds = $rekamMedisKlinis->unique('kode_icd')->pluck('kode_icd');
        return view('StatistikKodeICD', [
            'datas' => $rekamMedisKlinis,
            'kode_icds' => $kode_icds,
        ]);
    }

    public function rekamMedisPasien(Request $request)
    {
        return view('RekamMedisPasien', [
            'pasiens' => Pasien::get(),
        ]);
    }
    public function rekamMedisKlinisPasien(Request $request)
    {
        $pasien = Pasien::where('id', $request->id)->first();
        if($pasien){
            $datas = RegistrasiKunjunganKlinis::where('pasien_id', $pasien->id)->get();
            return view('RekamMedisKlinisPasien', [
                'datas' => $datas,
                'pasien' => $pasien,
            ]);
        }
    }
    public function rekamMedisPsikologPasien(Request $request)
    {
        $pasien = Pasien::where('id', $request->id)->first();
        if($pasien){
            $datas = RegistrasiKunjunganPsikolog::where('pasien_id', $pasien->id)->get();
            return view('RekamMedisPsikologPasien', [
                'datas' => $datas,
                'pasien' => $pasien,
            ]);
        }
    }
}
