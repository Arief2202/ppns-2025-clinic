<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventarisPeralatanRequest;
use App\Http\Requests\UpdateInventarisPeralatanRequest;
use App\Models\InventarisPeralatan;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InventarisPeralatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role_id != 1) return redirect('/');
        return view('InventarisPeralatan', [
            'datas' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        User::create([
            'name' => $request->name,
            'role_id' => $request->role,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/users');
    }
    public function edit(Request $request)
    {
        $user = User::where('id', "=", $request->id)->first();
        if(isset($request->name)) $user->name = $request->name;
        if(isset($request->role)) $user->role_id = $request->role;
        if(isset($request->password)) $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/users');
    }
    public function delete(Request $request)
    {
        $user = User::where('id', "=", $request->id)->first();
        if($user) $user->delete();
        return redirect('/users');
    }
    public function getById(Request $request)
    {
        $user = User::where('id', "=", $request->id)->first();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);die;
    }
}
