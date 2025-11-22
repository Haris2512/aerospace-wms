<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login?
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Ambil role user yang sedang login
        $userRole = Auth::user()->role;

        // 3. Cek apakah role user ada di dalam daftar role yang diizinkan?
        // (Kita pakai in_array karena $roles bisa banyak)
        if (in_array($userRole, $roles)) {
            return $next($request); // Silakan masuk
        }

        // 4. Kalau tidak cocok, tendang keluar (403 Forbidden)
        abort(403, 'Akses Ditolak! Anda tidak memiliki izin untuk masuk ke sini.');
    }
}