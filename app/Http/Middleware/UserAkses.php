<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAkses
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/');
        }

        // 2. Ambil data user yang sedang login
        $user = Auth::user();
        $userRole = $user->role;

        // --- UPDATE TAMBAHAN: Logika Khusus Admin Rumah Tangga ---
        // Jika halaman yang diminta membutuhkan akses 'Kaprodi', 
        // tapi yang login adalah Admin Rumah Tangga (User dengan email RT),
        // kita izinkan masuk karena mereka setara secara hak akses dashboard.
        if (in_array('Kaprodi', $roles) && $user->email == 'rumahtangga@politeknikatk.ac.id') {
            return $next($request);
        }
        // -------------------------------------------------------

        // 3. Cek apakah role user ada di dalam daftar parameter $roles
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika user adalah Kaprodi / Admin Rumah Tangga tapi mencoba akses halaman Admin lain
        if ($userRole == 'Kaprodi' || $user->email == 'rumahtangga@politeknikatk.ac.id') {
            return redirect()->route('kaprodi.dashboard');
        }

        return redirect('/admin')->withErrors('Anda tidak memiliki akses ke halaman tersebut.');
    }
}