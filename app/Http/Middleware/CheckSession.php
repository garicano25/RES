<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSession
{
    /**
     * Manejar una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $excludedRoutes = [
            '/Formulario-vacantes', // Ruta externa
            '/Vacantes',           // Ruta externa
        ];

        if (in_array($request->path(), $excludedRoutes)) {
            return $next($request);
        }

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
        }

        return $next($request);
    }
}
