<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = $request->user();

        if (! $user) {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses!');
        }

        $allowedRoles = explode('|', $roles);

        if (in_array($user->role, $allowedRoles, true)) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    }
}