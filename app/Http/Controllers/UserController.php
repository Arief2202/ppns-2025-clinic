<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role_id != 1) return redirect('/');
        return view('users', [
            'users' => User::all(),
            'roles' => Role::all()
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
        if(isset($request->nip)){
            if($user->nip != $request->nip){
                $userNIP = User::where('nip', "=", $request->nip)->first();
                if($userNIP) return redirect('/users');
            }
            $user->nip = $request->nip;
        }
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

    public function viewProfile()
    {
        return view('profile');
    }

    public function editProfile(Request $request)
    {
        $user = User::where("id", "=", Auth::user()->id)->first();
        if($user){
            if(isset($request->nip)){
                if($user->nip != $request->nip){
                    $userNIP = User::where('nip', "=", $request->nip)->first();
                    if($userNIP) return view('profile', ['errorMessage' => 'this NIP alredy taken!']);
                }
                $user->nip = $request->nip;
            }
            if(isset($request->name)) $user->name = $request->name;
            if(isset($request->password) || isset($request->password2)){
                if(!isset($request->password) || !isset($request->password2)) return view('profile', ['errorMessage' => 'Password & Password Confirmation Needed if update password!']);
                if($request->password != $request->password2)  return view('profile', ['errorMessage' => 'Password & Password Confirmation not match!']);
                $user->password = Hash::make($request->password);
            }
            $user->save();
            Auth::setUser($user);
            return view('profile', ['successMessage' => 'Update Profile Successfully', 'reload' => true]);
        }

        return redirect('/profile');
    }


}
