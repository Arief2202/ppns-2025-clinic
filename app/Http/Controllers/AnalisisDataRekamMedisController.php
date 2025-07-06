<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnalisisDataRekamMedisRequest;
use App\Http\Requests\UpdateAnalisisDataRekamMedisRequest;
use App\Models\AnalisisDataRekamMedis;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AnalisisDataRekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('AnalisisDataRekamMedis', [
            'datas' => AnalisisDataRekamMedis::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/rekam-medis/analisis-data-rekam-medis';
        $fileName = date("YmdHis").'_'.$request->dokumen_analisis->getClientOriginalName();
        $request->dokumen_analisis->move(public_path($destinationPath), $fileName);
        AnalisisDataRekamMedis::create([
            'tanggal_analisis' => $request->tanggal_analisis,
            'dokumen_analisis' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/rekam-medis/analisis-data-rekam-medis');
    }
    public function edit(Request $request)
    {
        $data = AnalisisDataRekamMedis::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->tanggal_analisis)) $data->tanggal_analisis = $request->tanggal_analisis;
            if($request->dokumen_analisis){
                File::delete(public_path().$data->dokumen_analisis);
                $destinationPath = 'uploads/rekam-medis/analisis-data-rekam-medis';
                $fileName = date("YmdHis").'_'.$request->dokumen_analisis->getClientOriginalName();
                $request->dokumen_analisis->move(public_path($destinationPath), $fileName);
                $data->dokumen_analisis = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/rekam-medis/analisis-data-rekam-medis');
    }
    public function delete(Request $request)
    {
        $data = AnalisisDataRekamMedis::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_analisis);
            $data->delete();
        }
        return redirect('/rekam-medis/analisis-data-rekam-medis');
    }
    public function getById(Request $request)
    {
        $user = AnalisisDataRekamMedis::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(Request $request){
        if(Auth::user()->role_id != 1) return redirect('/');
        $datas = AnalisisDataRekamMedis::where('id', "=", $request->id)->first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/rekam-medis/analisis-data-rekam-medis');
    }
}
