<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePedomanPemeriksaanKesehatanRequest;
use App\Http\Requests\UpdatePedomanPemeriksaanKesehatanRequest;
use App\Models\PedomanPemeriksaanKesehatan;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class PedomanPemeriksaanKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('PedomanPemeriksaanKesehatan', [
            'data' => PedomanPemeriksaanKesehatan::first(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/SMK3/pemeriksaan-kesehatan/pedoman-pemeriksaan-kesehatan';
        $fileName = date("YmdHis").'.'.$request->file->extension();
        $request->file->move(public_path($destinationPath), $fileName);
        $datas = PedomanPemeriksaanKesehatan::first();
        if($datas){
            File::delete(public_path().$datas->dokumen_pedoman);
            $datas->dokumen_pedoman = '/'.$destinationPath.'/'.$fileName;
            $datas->editor_id = Auth::user()->id;
            $datas->save();
        }
        else{
            PedomanPemeriksaanKesehatan::create([
                'id' => 1,
                'dokumen_pedoman' => '/'.$destinationPath.'/'.$fileName,
                'editor_id' => Auth::user()->id,
            ]);
        }
        return redirect('/smk3/pemeriksaan-kesehatan-pekerja/pedoman-pemeriksaan-kesehatan');
    }
}
