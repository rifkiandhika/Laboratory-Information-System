<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class superadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah user adalah admin
        $user = auth()->user();

        // Opsi 1: menggunakan kolom is_admin
        if (isset($user->is_admin) && $user->is_admin == 4) {
            return $next($request);
        }

        // Opsi 2: menggunakan kolom role
        if (isset($user->role) && $user->role === 'superadmin') {
            return $next($request);
        }

        // Jika bukan admin
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
