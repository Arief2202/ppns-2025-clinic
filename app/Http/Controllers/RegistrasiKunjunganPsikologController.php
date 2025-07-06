<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrasiKunjunganPsikologRequest;
use App\Http\Requests\UpdateRegistrasiKunjunganPsikologRequest;
use App\Models\DataKesehatanMental;
use App\Models\RegistrasiKunjunganPsikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\User;
use App\Models\PemusnahanObat;
use App\Models\RekamMedisPsikolog;
use Illuminate\Support\Facades\File;

class RegistrasiKunjunganPsikologController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('RegistrasiKunjunganPsikolog', [
            'datas' => RegistrasiKunjunganPsikolog::all(),
            'pasiens' => Pasien::get(),
            'pemeriksas' => User::where('role_id', 5)->get(),
        ]);
    }
    public function detail(Request $request)
    {
        $data = RegistrasiKunjunganPsikolog::where('id', "=", $request->id)->first();
        if($data){
            // $itemsAdded = RekamMedisPsikolog::where('registrasi_id', '=', $request->id)->get();
            // $items = ObatBMHP::whereNotIn('id', $itemsAdded)->get();
            return view('RegistrasiKunjunganPsikologDetail', [
                'data' => $data,
                'pasiens' => Pasien::get(),
                'pemeriksas' => User::where('role_id', 5)->get(),
                // 'items' => $items,
            ]);
        }
        return redirect('/kesehatan-mental/registrasi-kunjungan-psikolog');
    }

    public function addItem(Request $request){
        $destinationPath = 'uploads/kesehatan-mental/rekam-medis-psikologis';
        $fileName = date("YmdHis").'_'.$request->dokumen_rujukan->getClientOriginalName();
        $request->dokumen_rujukan->move(public_path($destinationPath), $fileName);
        $data = RekamMedisPsikolog::create([
            'registrasi_id' => $request->registrasi_id,
            'catatan_kondisi' => $request->catatan_kondisi,
            'intervensi' => $request->intervensi,
            'status_intervensi_lanjutan' => $request->status_intervensi_lanjutan,
            'tanggal_rujukan' => $request->tanggal_rujukan,
            'dokumen_rujukan' => '/'.$destinationPath.'/'.$fileName,
            'status' => $request->status
        ]);
        return redirect()->back();

    }
    public function deleteItem(Request $request)
    {
        if(Auth::user()->role_id != 5) return redirect('/');
        $data = RekamMedisPsikolog::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_rujukan);
            $data->delete();
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(Auth::user()->role_id != 5) return redirect('/');
        if(isset($request->nip)){
            $newPasien = Pasien::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'bagian' => $request->bagian,
                'tanggal_registrasi' => $request->tanggal_registrasi,
            ]);
            $data = RegistrasiKunjunganPsikolog::create([
                'pasien_id' => $newPasien->id,
                'pemeriksa_id' => $request->pemeriksa_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'editor_id' => Auth::user()->id,
            ]);
        }
        else{
            $data = RegistrasiKunjunganPsikolog::create([
                'pasien_id' => $request->pasien_id,
                'pemeriksa_id' => $request->pemeriksa_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'editor_id' => Auth::user()->id,
            ]);
        }
        return redirect('/kesehatan-mental/registrasi-kunjungan-psikolog/detail?id='.$data->id);
    }
    public function edit(Request $request)
    {
        if(Auth::user()->role_id != 5) return redirect('/');
        $data = RegistrasiKunjunganPsikolog::where('id', "=", $request->id)->first();
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
        if(Auth::user()->role_id != 5) return redirect('/');
        $data = RegistrasiKunjunganPsikolog::where('id', "=", $request->id)->first();
        if($data){
            foreach(RekamMedisPsikolog::where('registrasi_id', '=', $data->id)->get() as $item){
                $item->delete();
            }
            $data->delete();
        }
    }

    public function getById(Request $request)
    {
        $user = RegistrasiKunjunganPsikolog::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
}
