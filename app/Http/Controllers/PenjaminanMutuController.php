<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenjaminanMutuRequest;
use App\Http\Requests\UpdatePenjaminanMutuRequest;
use App\Models\PenjaminanMutu;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class PenjaminanMutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('PenjaminanMutu', [
            'datas' => PenjaminanMutu::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/rekam-medis/penjaminan-mutu';
        $fileName = date("YmdHis").'_'.$request->dokumen_audit->getClientOriginalName();
        $request->dokumen_audit->move(public_path($destinationPath), $fileName);
        PenjaminanMutu::create([
            'tanggal_audit' => $request->tanggal_audit,
            'dokumen_audit' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/rekam-medis/penjaminan-mutu');
    }
    public function edit(Request $request)
    {
        $data = PenjaminanMutu::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->tanggal_audit)) $data->tanggal_audit = $request->tanggal_audit;
            if($request->dokumen_audit){
                File::delete(public_path().$data->dokumen_audit);
                $destinationPath = 'uploads/rekam-medis/penjaminan-mutu';
                $fileName = date("YmdHis").'_'.$request->dokumen_audit->getClientOriginalName();
                $request->dokumen_audit->move(public_path($destinationPath), $fileName);
                $data->dokumen_audit = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/rekam-medis/penjaminan-mutu');
    }
    public function delete(Request $request)
    {
        $data = PenjaminanMutu::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_audit);
            $data->delete();
        }
        return redirect('/rekam-medis/penjaminan-mutu');
    }
    public function getById(Request $request)
    {
        $user = PenjaminanMutu::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(Request $request){
        if(Auth::user()->role_id != 1) return redirect('/');
        $datas = PenjaminanMutu::where('id', "=", $request->id)->first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/rekam-medis/penjaminan-mutu');
    }
}
