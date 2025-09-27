<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


class DenyRoleGlobalMiddleware
{
    // Rutas donde se quiere bloquear a los proveedores
    protected $rutasProtegidas = [
        'clientes',
        'solicitudes',
        'ofertas',
        'organigrama',
        'ppt',
        'dpt',
        'jerarquico',
        'asesores',
        'funcionescargo',
        'funcionesgestion',
        'relacionesexternas',
        'categorias',
        'genero',
        'puestoexperiencia',
        'competenciasbasicas',
        'competenciasgerenciales',
        'tipovacante',
        'motivovacante',
        'anuncios',
        'catalogoppt',
        'catalogodpt',
        'catalogorequisicion',
        'catalogogenerales',
        'listavacantes',
        'catalogodevacantes',
        'areainteres',
        'postulaciones',
        'pendientecontratar',
        'recempleado',
        'brechacompetencia',
        'desvinculacion',
        'confirmacion',
        'ordentrabajo',
        'catalogosolicitudes',
        'catalogoclientestitulos',
        'catalogomediocontacto',
        'catalogogiroempresa',
        'catalogonecesidadservicio',
        'catalogolineanegocio',
        'catalogotiposervicio',
        'catalogoconfirmacion',
        'catalogoverificacion',
        'requisicionmateriales',
        'requisicionmaterialeslideres',
        'requisicionmaterialesaprobacion',
        'bitacora',
        'bancoproveedores',
        'listaproveedores',
        'proveedorestemporales',
        'matrizcomparativa',
        'ordencompra',
        'catalogosproveedores',
        'catalogofunciones',
        'catalogotitulos',
        'catalogodocumentosoporte',
        'modulos',
        'usuario',
        'catalogoverificacionproveedor',
        'matrizaprobacion',
        'ordencompraaprobacion',
        'bitacoragr',
        'requisiciondepersonal',
        'inventario',
        'catalogosinventarios',
        'catalogotipoinventario',
        'vobogrusuario',
        'solicitudesvobo',
        'solicitudesaprobaciones'
        
    ];

    // public function handle($request, Closure $next)
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();

    //         // Obtiene roles activos
    //         $userRoles = $user->roles()->where('ACTIVO', 1)->pluck('NOMBRE_ROL')->map(fn($rol) => strtolower(trim($rol)))->toArray();

    //         if (in_array('Proveedor', $userRoles)) {
    //             $rutaActual = $request->path(); // Ejemplo: "Clientes"
    //             $rutaActualBase = explode('/', $rutaActual)[0]; // Toma solo el primer segmento

    //             if (in_array($rutaActualBase, $this->rutasProtegidas)) {
    //                 return redirect()->route('Alta')->with('error', 'No tienes permiso para acceder a esta sección.');
    //             }
    //         }
    //     }

    //     return $next($request);
    // }




    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $userRoles = $user->roles()
                ->where('ACTIVO', 1)
                ->pluck('NOMBRE_ROL')
                ->map(fn($rol) => trim($rol))
                ->toArray();

            if (in_array('Proveedor', $userRoles)) {
                // Nombre de la ruta actual
                $rutaActual = Route::currentRouteName();

                // Normalizamos ruta actual y rutas protegidas (sin tildes)
                $rutaNormalizada = Str::ascii($rutaActual);

                $rutasProtegidasNormalizadas = array_map(
                    fn($r) => Str::ascii($r),
                    $this->rutasProtegidas
                );

                if ($rutaActual && in_array($rutaNormalizada, $rutasProtegidasNormalizadas)) {
                    return redirect()->route('alta')
                        ->with('error', 'No tienes permiso para acceder a esta sección.');
                }
            }
        }

        return $next($request);
    }
}





