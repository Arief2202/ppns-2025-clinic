<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInformasiTataRuangKlinikRequest;
use App\Http\Requests\UpdateInformasiTataRuangKlinikRequest;
use App\Models\InformasiTataRuangKlinik;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class InformasiTataRuangKlinikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('InformasiTataRuangKlinik', [
            'data' => InformasiTataRuangKlinik::first(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinationPath = 'uploads/sarana-prasarana/informasi-tata-ruang-klinik';
        $imageName = date("YmdHis").'.'.$request->file->extension();
        $request->file->move(public_path($destinationPath), $imageName);
        $datas = InformasiTataRuangKlinik::first();
        if($datas){
            File::delete(public_path().$datas->gambar_ruang_klinik);
            $datas->gambar_ruang_klinik = '/'.$destinationPath.'/'.$imageName;
            $datas->validator_id = null;
            $datas->editor_id = Auth::user()->id;
            $datas->save();
        }
        else{
            InformasiTataRuangKlinik::create([
                'id' => 1,
                'gambar_ruang_klinik' => '/'.$destinationPath.'/'.$imageName,
                'editor_id' => Auth::user()->id,
            ]);
        }
        return redirect('/sarana-prasarana/informasi-tata-ruang-klinik');
    }

    public function validate_image(){
        if(Auth::user()->role_id != 1) return redirect('/');
        $datas = InformasiTataRuangKlinik::first();
        $datas->validator_id = Auth::user()->id;
        $datas->save();
        return redirect('/sarana-prasarana/informasi-tata-ruang-klinik');
    }
}
