<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStandardOperasionalProsedurKlinikRequest;
use App\Http\Requests\UpdateStandardOperasionalProsedurKlinikRequest;
use App\Models\StandardOperasionalProsedurKlinik;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SOPKlinikExport;

class StandardOperasionalProsedurKlinikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function export(){
		return Excel::download(new SOPKlinikExport, 'SOPKlinik.xlsx');
    }
    public function index()
    {
        return view('StandardOperasionalProsedurKlinik', [
            'datas' => StandardOperasionalProsedurKlinik::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/sarana-prasarana/SOP-klinik';
        $fileName = date("YmdHis").'_'.$request->dokumen_sop->getClientOriginalName();
        $request->dokumen_sop->move(public_path($destinationPath), $fileName);
        StandardOperasionalProsedurKlinik::create([
            'nama_sop' => $request->nama_sop,
            'dokumen_sop' => '/'.$destinationPath.'/'.$fileName,
            'tanggal_peninjauan' => $request->tanggal_peninjauan,
            'editor_id' => Auth::user()->id,
        ]);
        return redirect('/sarana-prasarana/standard-operasional-prosedur-klinik');
    }
    public function edit(Request $request)
    {
        $data = StandardOperasionalProsedurKlinik::where('id', "=", $request->id)->first();
        if($data){
            $data->editor_id = Auth::user()->id;
            if(isset($request->nama_sop)) $data->nama_sop = $request->nama_sop;
            if(isset($request->tanggal_peninjauan)) $data->tanggal_peninjauan = $request->tanggal_peninjauan;
            if($request->dokumen_sop){
                File::delete(public_path().$data->dokumen_sop);
                $destinationPath = 'uploads/sarana-prasarana/SOP-klinik';
                $fileName = date("YmdHis").'_'.$request->dokumen_sop->getClientOriginalName();
                $request->dokumen_sop->move(public_path($destinationPath), $fileName);
                $data->dokumen_sop = '/'.$destinationPath.'/'.$fileName;
            }
            $data->save();
        }
        return redirect('/sarana-prasarana/standard-operasional-prosedur-klinik');
    }
    public function delete(Request $request)
    {
        $data = StandardOperasionalProsedurKlinik::where('id', "=", $request->id)->first();
        if($data){
            File::delete(public_path().$data->dokumen_sop);
            $data->delete();
        }
        return redirect('/sarana-prasarana/standard-operasional-prosedur-klinik');
    }
    public function getById(Request $request)
    {
        $user = StandardOperasionalProsedurKlinik::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
}
