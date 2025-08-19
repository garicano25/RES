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
        'Clientes',
        'Solicitudes',
        'Ofertas',
        'organigrama',
        'PPT',
        'DPT',
        'Jerárquico',
        'Asesores',
        'FuncionesCargo',
        'Funcionesgestión',
        'RelacionesExternas',
        'Categorías',
        'Género',
        'Puesto-experiencia',
        'Competencias-básicas',
        'Competencias-gerenciales',
        'Tipo-vacante',
        'Motivo-vacante',
        'Anuncios',
        'Catálogo_ppt',
        'Catálogo_dpt',
        'Catálogo_requisición',
        'Catálogo_generales',
        'Listavacantes',
        'CatálogoDeVacantes',
        'Área_interes',
        'Postulaciones',
        'Pendiente-Contratar',
        'Rec.Empleado',
        'Brecha_competencia',
        'Desvinculación',
        'Confirmación',
        'Orden_trabajo',
        'Catálogo_solicitudes',
        'Catálogo_clientes_titulos',
        'Catálogo_medio_contacto',
        'Catálogo_giro_empresa',
        'Catálogo_necesidad_servicio',
        'Catálogo_línea_negocio',
        'Catálogo_tipo_servicio',
        'Catálogo_confirmación',
        'Catálogo_verificación',
        'Requisición_Materiales',
        'Requisición_materiales_líderes',
        'Requisición_materiales_aprobación',
        'Bitácora',
        'Banco_proveedores',
        'Lista_proveedores',
        'Proveedores_temporales',
        'Matriz_comparativa',
        'Orden_compra',
        'Catálogos_proveedores',
        'Catálogo_funciones',
        'Catálogo_títulos',
        'Catálogo_documento_soporte',
        'Módulos',
        'usuario',
        'Catálogo_verificación_proveedor',
        'Matriz_aprobación',
        'Orden_compra_aprobación',
        'Bitácora-GR',
        'RequisiciónDePersonal'

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
                    return redirect()->route('Alta')
                        ->with('error', 'No tienes permiso para acceder a esta sección.');
                }
            }
        }

        return $next($request);
    }
}





