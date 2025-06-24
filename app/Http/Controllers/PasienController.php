<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasienRequest;
use App\Http\Requests\UpdatePasienRequest;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pasien', [
            'pasiens' => Pasien::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Pasien::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'bagian' => $request->bagian,
            'tanggal_registrasi' => $request->tanggal_registrasi,
        ]);
        return redirect('/pasien');
    }
    public function edit(Request $request)
    {
        $pasien = Pasien::where('id', "=", $request->id)->first();
        if(isset($request->nip)){
            if($pasien->nip != $request->nip){
                $pasienNIP = Pasien::where('nip', "=", $request->nip)->first();
                if($pasienNIP) return redirect('/users')->with('errorMessage', "this NIP has registred!");
            }
            $pasien->nip = $request->nip;
        }
        if(isset($request->nama)) $pasien->nama = $request->nama;
        if(isset($request->tanggal_lahir)) $pasien->tanggal_lahir = $request->tanggal_lahir;
        if(isset($request->jenis_kelamin)) $pasien->jenis_kelamin = $request->jenis_kelamin;
        if(isset($request->bagian)) $pasien->bagian = $request->bagian;
        if(isset($request->tanggal_registrasi)) $pasien->tanggal_registrasi = $request->tanggal_registrasi;
        $pasien->save();
        return redirect('/pasien');
    }
    public function delete(Request $request)
    {
        $pasien = Pasien::where('id', "=", $request->id)->first();
        if($pasien) $pasien->delete();
        return redirect('/pasien');
    }
    public function getById(Request $request)
    {
        $pasien = Pasien::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($pasien);die;
    }

}
