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
            'email'=>'required',
            'password'=>'required'
        ],[
            'email.required'=>'Email Wajib Diisi',
            'password.required'=>'Password Wajib Diisi',
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($infologin)){
            $user = Auth::user();
            
            // REDIRECT BERDASARKAN ROLE (MENGGUNAKAN ROUTE NAME)
            if($user->role == 'Super Admin'){
                return redirect('admin/SuperAdmin');
            } elseif ($user->role == 'Kepala Lab'){
                return redirect('admin/KaLab');
            } elseif ($user->role == 'Tim Pemelihara'){
                return redirect('admin/TimPemelihara');
            } elseif ($user->role == 'Kaprodi'){
                return redirect()->route('kaprodi.dashboard'); 
            } elseif ($user->role == 'Pembantu Direktur 1'){
                // Diperbaiki: Mengarah ke salah satu menu Pudir 1 (misal: readiness)
                return redirect()->route('pudir1.index');
            } elseif ($user->role == 'Pembantu Direktur 2'){
                // Diperbaiki: Mengarah ke index Pudir 2
                return redirect()->route('pudir2.index');
            }

            // Fallback jika role tidak terdaftar di atas tapi login berhasil
            return redirect()->route('dashboard');

        } else {
            return redirect('')->withErrors('Username atau Password yang dimasukan tidak sesuai')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('')->with('success', 'Berhasil logout');
    }
}