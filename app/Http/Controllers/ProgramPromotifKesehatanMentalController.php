<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramPromotifKesehatanMentalRequest;
use App\Http\Requests\UpdateProgramPromotifKesehatanMentalRequest;
use App\Models\ProgramPromotifKesehatanMental;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProgramPromotifKesehatanMentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ProgramPromotifKesehatanMental', [
            'datas' => ProgramPromotifKesehatanMental::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/kesehatan-mental/program-promotif-kesehatan-mental';
        $fileName = date("YmdHis").'_'.$request->dokumentasi->getClientOriginalName();
        $request->dokumentasi->move(public_path($destinationPath), $fileName);
        ProgramPromotifKesehatanMental::create([
            'nama_program' => $request->nama_program,
            'tujuan_program' => $request->tujuan_program,
            'deskripsi_program' => $request->deskripsi_program,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'dokumentasi' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/kesehatan-mental/program-promotif-kesehatan-mental');
    }
    public function edit(Request $request)
    {
        $data = ProgramPromotifKesehatanMental::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->nama_program)) $data->nama_program = $request->nama_program;
            if(isset($request->tujuan_program)) $data->tujuan_program = $request->tujuan_program;
            if(isset($request->deskripsi_program)) $data->deskripsi_program = $request->deskripsi_program;
            if(isset($request->tanggal_pelaksanaan)) $data->tanggal_pelaksanaan = $request->tanggal_pelaksanaan;
            if($request->dokumentasi){
                File::delete(public_path().$data->dokumentasi);
                $destinationPath = 'uploads/kesehatan-mental/program-promotif-kesehatan-mental';
                $fileName = date("YmdHis").'_'.$request->dokumentasi->getClientOriginalName();
                $request->dokumentasi->move(public_path($destinationPath), $fileName);
                $data->dokumentasi = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/kesehatan-mental/program-promotif-kesehatan-mental');
    }
    public function delete(Request $request)
    {
        $data = ProgramPromotifKesehatanMental::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumentasi);
            $data->delete();
        }
        return redirect('/kesehatan-mental/program-promotif-kesehatan-mental');
    }
    public function getById(Request $request)
    {
        $user = ProgramPromotifKesehatanMental::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
}

