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

        // 2. Ambil role user yang sedang login
        $userRole = Auth::user()->role;

        // 3. Cek apakah role user ada di dalam daftar parameter $roles
        // Kita menggunakan array agar bisa menerima lebih dari satu role jika diperlukan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika user adalah Kaprodi tapi mencoba akses halaman Admin (atau sebaliknya)
        // Kita arahkan ke halaman yang sesuai dengan rolenya untuk menghindari 404/403
        if ($userRole == 'Kaprodi') {
            return redirect()->route('kaprodi.dashboard');
        }

        return redirect('/admin')->withErrors('Anda tidak memiliki akses ke halaman tersebut.');
    }
}