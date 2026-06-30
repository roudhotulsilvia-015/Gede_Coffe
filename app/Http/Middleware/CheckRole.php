<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// Middleware untuk memeriksa peran pengguna sebelum mengakses rute tertentu.
class CheckRole
{// Memeriksa apakah pengguna memiliki peran yang diizinkan untuk mengakses rute.
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = $request->user();
// Jika pengguna tidak ditemukan, arahkan ke halaman login dengan pesan error.
        if (! $user) {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses!');
        }
// Memisahkan peran yang diizinkan menjadi array.
        $allowedRoles = explode('|', $roles);
// Memeriksa apakah peran pengguna termasuk dalam daftar peran yang diizinkan.
        if (in_array($user->role, $allowedRoles, true)) {
            return $next($request);
        }
// Jika peran pengguna tidak diizinkan, arahkan ke dashboard dengan pesan error.
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    }
}