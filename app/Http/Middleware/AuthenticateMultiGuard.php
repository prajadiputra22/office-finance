<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateMultiGuard
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Jika tidak ada guard yang dispesifik, gunakan semua guard yang ada
        if (empty($guards)) {
            $guards = ['web', 'admin'];
        }

        // Cek apakah user sudah authenticated dengan salah satu dari guard yang dispesifik
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $next($request);
            }
        }

        // Jika tidak ada yang authenticated, redirect ke login
        return redirect()->route('login');
    }
}
