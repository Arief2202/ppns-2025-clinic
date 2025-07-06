<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDistribusiRekamMedisRequest;
use App\Http\Requests\UpdateDistribusiRekamMedisRequest;
use App\Models\DistribusiRekamMedis;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DistribusiRekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('DistribusiRekamMedis', [
            'datas' => DistribusiRekamMedis::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/rekam-medis/distribusi-rekam-medis';
        $fileName = date("YmdHis").'_'.$request->dokumentasi_distribusi->getClientOriginalName();
        $request->dokumentasi_distribusi->move(public_path($destinationPath), $fileName);
        DistribusiRekamMedis::create([
            'tanggal_distribusi' => $request->tanggal_distribusi,
            'tujuan' => $request->tujuan,
            'dokumentasi_distribusi' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/rekam-medis/distribusi-rekam-medis');
    }
    public function edit(Request $request)
    {
        $data = DistribusiRekamMedis::where('id', "=", $request->id)->first();
        if($data){
            $data->editor_id = Auth::user()->id;
            if(isset($request->tanggal_distribusi)) $data->tanggal_distribusi = $request->tanggal_distribusi;
            if(isset($request->tujuan)) $data->tujuan = $request->tujuan;
            if($request->dokumentasi_distribusi){
                File::delete(public_path().$data->dokumentasi_distribusi);
                $destinationPath = 'uploads/rekam-medis/distribusi-rekam-medis';
                $fileName = date("YmdHis").'_'.$request->dokumentasi_distribusi->getClientOriginalName();
                $request->dokumentasi_distribusi->move(public_path($destinationPath), $fileName);
                $data->dokumentasi_distribusi = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/rekam-medis/distribusi-rekam-medis');
    }
    public function delete(Request $request)
    {
        $data = DistribusiRekamMedis::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumentasi_distribusi);
            $data->delete();
        }
        return redirect('/rekam-medis/distribusi-rekam-medis');
    }
    public function getById(Request $request)
    {
        $user = DistribusiRekamMedis::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
}
