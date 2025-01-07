<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
        }

        if (Auth::user()->hasAnyRole($roles)) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'No tienes acceso a este módulo.');
    }
}
