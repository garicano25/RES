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
        'Formulario-vacantes', 
        'Vacantes',            
        'login',               
        '',
        'logout',              
        'inicio',
        'Directorio',          
        'actualizarinfo',           
        'actualizarinfoproveedor',      
        'actualizarinfocv',         
        'FormCVSave',
        'ServiciosSave',
        'enviar-codigo' ,
        'verificar-codigo',      
        'Proveedor' ,
        'codigo-postal'        





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
