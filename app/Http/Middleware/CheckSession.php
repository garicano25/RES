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
        // Rutas excluidas del middleware (sin barra inicial)
        $excludedRoutes = [
            'Formulario-vacantes', // Ruta externa
            'Vacantes',            // Ruta externa
            'login',               // Ruta de login
            '',                    // Redirección inicial
            'logout',
            'inicio',         // Ruta de logout
        ];

        // Verificar si la solicitud coincide con una ruta excluida
        if (in_array($request->path(), $excludedRoutes)) {
            return $next($request);
        }

        // Si el usuario no está autenticado, redirigir al login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
        }

        // Continuar con la solicitud si el usuario está autenticado
        return $next($request);
    }
}
