<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index(){
        return view('login');
    }

    function login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ],[
            'username.required'=>'Username wajib diisi',
            'password.required'=>"Password wajib diisi"
        ]);
        $infologin = [
            'username'=>$request->username,
            'password'=>$request->password,
        ];

        if(Auth::attempt($infologin)){
            if(Auth::user()->role == 'admin'){
                return redirect('/roleadmin/dashboard');
            }elseif(Auth::user()->role == 'validator'){
                return redirect('/rolevalidator/dashboard');
            }elseif(Auth::user()->role == 'karyawan'){
                return redirect('/rolekaryawan/dashboard');
            }
        }else{
            return redirect('')->withErrors('Username atau Password yang dimasukkan tidak sesuai')->withInput();
        }
    }

    function logout(){
        Auth::logout();
        return redirect('');
    }
}
