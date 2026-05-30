<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index(){
        // Jika sudah login, jangan lempar ke halaman login lagi
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    function login(Request $request){
        $request->validate([
            'email' => 'required|email', // Tambahkan validasi format email
            'password' => 'required'
        ],[
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Format Email Tidak Valid',
            'password.required' => 'Password Wajib Diisi',
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Proses Otentikasi
        if(Auth::attempt($infologin)){
            $request->session()->regenerate(); // Keamanan: Cegah Session Fixation
            
            $user = Auth::user();
            
            // REDIRECT TERPUSAT: 
            // Kita arahkan semua role ke 'dashboard' karena 
            // MaintenanceController@index sudah mengatur filter data per role.
            if(in_array($user->role, ['Super Admin', 'Kepala Lab', 'Tim Pemelihara'])){
                return redirect()->intended('/dashboard');
            } 
            
            // Redirect khusus Kaprodi (Jika dashboardnya berbeda file blade)
            if ($user->role == 'Kaprodi'){
                return redirect()->intended(route('kaprodi.dashboard')); 
            } 

            // Redirect khusus Pudir
            if ($user->role == 'Pembantu Direktur 1'){
                return redirect()->intended(route('pudir1.index'));
            } 
            
            if ($user->role == 'Pembantu Direktur 2'){
                return redirect()->intended(route('pudir2.index'));
            }

            return redirect()->intended('/dashboard');

        } else {
            // Jika gagal, kembali dengan input agar user tidak mengetik ulang email
            return redirect()->back()
                ->withErrors('Email atau Password yang dimasukkan tidak sesuai')
                ->withInput($request->only('email'));
        }
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Berhasil logout');
    }
}