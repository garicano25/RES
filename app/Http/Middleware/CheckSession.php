<?php

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Crypt;
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
            'Formulario-vacantes', // Ruta externa
            'Vacantes',            // Ruta externa
            'login',               // Ruta de login
            '',                    // Redirección inicial
            'logout',              // Ruta de logout
            'inicio',              // Ruta externa
            'Directorio'           // Ruta sin encriptar
        ];

        if ($request->is('login') || $request->is('Directorio') || $request->is('Vacantes')  || $request->is('Formulario-vacantes')  || $request->is('inicio')  || $request->is('Vacantes') ) {
            return $next($request);
        }

        try {
            $decryptedRoute = Crypt::decryptString($request->path());
            if (in_array($decryptedRoute, $excludedRoutes)) {
                return $next($request);
            }
        } catch (\Exception $e) {
        }

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
        }

        return $next($request);
    }
}
