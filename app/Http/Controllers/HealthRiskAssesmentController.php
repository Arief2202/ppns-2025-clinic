<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHealthRiskAssesmentRequest;
use App\Http\Requests\UpdateHealthRiskAssesmentRequest;
use App\Models\HealthRiskAssesment;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class HealthRiskAssesmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('HealthRiskAssesment', [
            'datas' => HealthRiskAssesment::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/SMK3/health-risk-assesment';
        $fileName = date("YmdHis").'_'.$request->dokumen_HRA->getClientOriginalName();
        $request->dokumen_HRA->move(public_path($destinationPath), $fileName);
        HealthRiskAssesment::create([
            'tanggal' => $request->tanggal,
            'nama_dokumen' => $request->nama_dokumen,
            'dokumen_HRA' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/smk3/health-risk-assesment');
    }
    public function edit(Request $request)
    {
        $data = HealthRiskAssesment::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->tanggal)) $data->tanggal = $request->tanggal;
            if(isset($request->nama_dokumen)) $data->nama_dokumen = $request->nama_dokumen;
            if($request->dokumen_HRA){
                File::delete(public_path().$data->dokumen_HRA);
                $destinationPath = 'uploads/SMK3/health-risk-assesment';
                $fileName = date("YmdHis").'_'.$request->dokumen_HRA->getClientOriginalName();
                $request->dokumen_HRA->move(public_path($destinationPath), $fileName);
                $data->dokumen_HRA = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/smk3/health-risk-assesment');
    }
    public function delete(Request $request)
    {
        $data = HealthRiskAssesment::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_HRA);
            $data->delete();
        }
        return redirect('/smk3/health-risk-assesment');
    }
    public function getById(Request $request)
    {
        $user = HealthRiskAssesment::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(Request $request){
        if(Auth::user()->role_id != 3) return redirect('/');
        $datas = HealthRiskAssesment::where('id', "=", $request->id)->first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/smk3/health-risk-assesment');
    }
}
