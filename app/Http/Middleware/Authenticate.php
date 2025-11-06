<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            // Jika route admin, redirect ke admin login
            if ($request->is('admin/*')) {
                return route('admin.login');
            }
            // Jika route biasa, redirect ke user login
            return route('login');
        }
        
        return null;
    }
    
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        // Cek apakah user atau admin sudah login
        if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
            return;
        }

        $this->unauthenticated($request, $guards);
    }
}