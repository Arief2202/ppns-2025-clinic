<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDataKesehatanMentalRequest;
use App\Http\Requests\UpdateDataKesehatanMentalRequest;
use App\Models\DataKesehatanMental;
use App\Models\User;
use App\Models\Role;
use App\Models\SurveyKesehatanMental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DataKesehatanMentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function updateSurvey(Request $request)
    {
        SurveyKesehatanMental::create([
            'link_survey' => $request->link_survey,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect()->back();
    }

    public function index()
    {
        $link = SurveyKesehatanMental::latest()->first()->link_survey;
        return view('DataKesehatanMental', [
            'datas' => DataKesehatanMental::all(),
            'link' => $link
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/kesehatan-mental/data-kesehatan-mental';
        $fileName = date("YmdHis").'_'.$request->dokumen_kesehatan_mental->getClientOriginalName();
        $request->dokumen_kesehatan_mental->move(public_path($destinationPath), $fileName);
        DataKesehatanMental::create([
            'tanggal_pendataan' => $request->tanggal_pendataan,
            'nama_dokumen' => $request->nama_dokumen,
            'dokumen_kesehatan_mental' => '/'.$destinationPath.'/'.$fileName,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/kesehatan-mental/data-kesehatan-mental');
    }
    public function edit(Request $request)
    {
        $data = DataKesehatanMental::where('id', "=", $request->id)->first();
        if($data){
            $data->validator_id = null;
            $data->editor_id = Auth::user()->id;
            if(isset($request->tanggal_pendataan)) $data->tanggal_pendataan = $request->tanggal_pendataan;
            if(isset($request->nama_dokumen)) $data->nama_dokumen = $request->nama_dokumen;
            if($request->dokumen_kesehatan_mental){
                File::delete(public_path().$data->dokumen_kesehatan_mental);
                $destinationPath = 'uploads/kesehatan-mental/data-kesehatan-mental';
                $fileName = date("YmdHis").'_'.$request->dokumen_kesehatan_mental->getClientOriginalName();
                $request->dokumen_kesehatan_mental->move(public_path($destinationPath), $fileName);
                $data->dokumen_kesehatan_mental = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/kesehatan-mental/data-kesehatan-mental');
    }
    public function delete(Request $request)
    {
        $data = DataKesehatanMental::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_kesehatan_mental);
            $data->delete();
        }
        return redirect('/kesehatan-mental/data-kesehatan-mental');
    }
    public function getById(Request $request)
    {
        $user = DataKesehatanMental::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
    public function validate_data(Request $request){
        if(Auth::user()->role_id != 1) return redirect('/');
        $datas = DataKesehatanMental::where('id', "=", $request->id)->first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/kesehatan-mental/data-kesehatan-mental');
    }
}
