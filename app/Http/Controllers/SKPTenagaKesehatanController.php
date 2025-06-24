<?php

namespace App\Http\Controllers;

use App\Models\SKPTenagaKesehatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SKPTenagaKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('SKPTenagaKesehatan', [
            'datas' => SKPTenagaKesehatan::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/SMK3/SKP-tenaga-kesehatan';
        $fileName = date("YmdHis").'_'.$request->dokumen_SKP->getClientOriginalName();
        $request->dokumen_SKP->move(public_path($destinationPath), $fileName);
        SKPTenagaKesehatan::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'masa_berlaku' => $request->masa_berlaku,
            'dokumen_SKP' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/smk3/skp-tenaga-kesehatan');
    }
    public function edit(Request $request)
    {
        $data = SKPTenagaKesehatan::where('id', "=", $request->id)->first();
        if($data){
            $data->editor_id = Auth::user()->id;
            if(isset($request->nama)) $data->nama = $request->nama;
            if(isset($request->nip)) $data->nip = $request->nip;
            if(isset($request->masa_berlaku)) $data->masa_berlaku = $request->masa_berlaku;
            if($request->dokumen_SKP){
                File::delete(public_path().$data->dokumen_SKP);
                $destinationPath = 'uploads/smk3/SKP-tenaga-kesehatan';
                $fileName = date("YmdHis").'_'.$request->dokumen_SKP->getClientOriginalName();
                $request->dokumen_SKP->move(public_path($destinationPath), $fileName);
                $data->dokumen_SKP = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/smk3/skp-tenaga-kesehatan');
    }
    public function delete(Request $request)
    {
        $data = SKPTenagaKesehatan::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_SKP);
            $data->delete();
        }
        return redirect('/smk3/skp-tenaga-kesehatan');
    }
    public function getById(Request $request)
    {
        $user = SKPTenagaKesehatan::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
}
