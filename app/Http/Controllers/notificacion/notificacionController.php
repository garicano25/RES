<?php

namespace App\Http\Controllers\notificacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;


use App\Models\requisicionmaterial\mrModel;
use App\Models\recempleados\recemplaedosModel;




// BITACORA


use App\Models\HojaTrabajo;

class notificacionController extends Controller
{


    // public function notificaciones()
    // {
    //     try {
    //         $usuario = Auth::user();
    //         $roles = $usuario->roles()->pluck('NOMBRE_ROL')->toArray();
    //         $idUsuario = $usuario->ID_USUARIO;

    //         /** 1️⃣ CATEGORÍAS LIDERADAS POR LOS ROLES DEL USUARIO */
    //         $categoriasLideradas = DB::table('lideres_categorias as lc')
    //             ->join('catalogo_categorias as cc', 'cc.ID_CATALOGO_CATEGORIA', '=', 'lc.LIDER_ID')
    //             ->whereIn('cc.NOMBRE_CATEGORIA', $roles)
    //             ->pluck('lc.CATEGORIA_ID')
    //             ->toArray();

    //         /** 2️⃣ OBTENER TODOS LOS USUARIOS A CARGO SEGÚN ROLES */
    //         $usuariosACargo = DB::table('asignar_rol')
    //             ->whereIn('NOMBRE_ROL', function ($q) use ($categoriasLideradas) {
    //                 $q->select('NOMBRE_CATEGORIA')
    //                     ->from('catalogo_categorias')
    //                     ->whereIn('ID_CATALOGO_CATEGORIA', $categoriasLideradas);
    //             })
    //             ->pluck('USUARIO_ID')
    //             ->toArray();

    //         /** 3️⃣ SI ES DIRECTOR → INCLUIR EMPLEADOS SIN LÍDER DIRECTO */
    //         if (in_array('Director', $roles)) {
    //             $usuariosSinLider = DB::table('asignar_rol as ar')
    //                 ->leftJoin('catalogo_categorias as cc', 'cc.NOMBRE_CATEGORIA', '=', 'ar.NOMBRE_ROL')
    //                 ->leftJoin('lideres_categorias as lc', 'lc.CATEGORIA_ID', '=', 'cc.ID_CATALOGO_CATEGORIA')
    //                 ->whereNull('lc.LIDER_ID')
    //                 ->pluck('ar.USUARIO_ID')
    //                 ->toArray();

    //             $usuariosACargo = array_merge($usuariosACargo, $usuariosSinLider);
    //         }

    //         /** 4️⃣ ELIMINAR DUPLICADOS */
    //         $usuariosACargo = array_unique($usuariosACargo);

    //         if (empty($usuariosACargo)) {
    //             return response()->json(['notificaciones' => [], 'total' => 0]);
    //         }

    //         /** 🔥 5️⃣ CONSULTA DE NOTIFICACIONES */
    //         $notis = recemplaedosModel::whereIn('USUARIO_ID', $usuariosACargo)
    //             ->where('DAR_BUENO', 0)              // 🔥 Solo pendientes
    //             ->whereIn('TIPO_SOLICITUD', [1, 3])  // 🔥 Solo tipo 1 y 3
    //             ->orderBy('FECHA_SALIDA', 'desc')
    //             ->get();

    //         /** 6️⃣ FORMATEAR NOTIFICACIONES */
    //         $data = $notis->map(function ($n) {

    //             // 🔥 BADGE 100% ESTILIZADO DESDE EL CONTROLADOR
    //             $badge = "<span style='
    //                     background-color: #f4c542; 
    //                     color: black; 
    //                     padding: 3px 8px; 
    //                     border-radius: 6px; 
    //                     font-size: 11px; 
    //                     font-weight: bold;
    //                     display: inline-block;
    //                 '>Vo.Bo</span>";

    //             return [
    //                 'id' => $n->ID_FORMULARIO_RECURSOS_EMPLEADOS,
    //                 'titulo' => $this->textoTipoSolicitud($n->TIPO_SOLICITUD),
    //                 'detalle' => $n->SOLICITANTE_SALIDA ?? 'Sin nombre',
    //                 'fecha' => 'Fecha solicitud: ' . ($n->FECHA_SALIDA ?? ''),
    //                 'estatus_badge' => $badge,   
    //                 'link' => url('/solicitudesvobo')
    //             ];
    //         });

    //         return response()->json([
    //             'notificaciones' => $data,
    //             'total' => count($data)
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


    // public function notificaciones()
    // {
    //     try {
    //         $usuario = Auth::user();
    //         $idUsuario = $usuario->ID_USUARIO;
    //         $roles = $usuario->roles()->pluck('NOMBRE_ROL')->toArray();


    //         $categoriasLideradas = DB::table('lideres_categorias as lc')
    //             ->join('catalogo_categorias as cc', 'cc.ID_CATALOGO_CATEGORIA', '=', 'lc.LIDER_ID')
    //             ->whereIn('cc.NOMBRE_CATEGORIA', $roles)
    //             ->pluck('lc.CATEGORIA_ID')
    //             ->toArray();

    //         $usuariosACargo = DB::table('asignar_rol')
    //             ->whereIn('NOMBRE_ROL', function ($query) use ($categoriasLideradas) {
    //                 $query->select('NOMBRE_CATEGORIA')
    //                     ->from('catalogo_categorias')
    //                     ->whereIn('ID_CATALOGO_CATEGORIA', $categoriasLideradas);
    //             })
    //             ->pluck('USUARIO_ID')
    //             ->toArray();

    //         if (in_array('Director', $roles)) {
    //             $usuariosSinLider = DB::table('asignar_rol as ar')
    //                 ->leftJoin('catalogo_categorias as cc', 'cc.NOMBRE_CATEGORIA', '=', 'ar.NOMBRE_ROL')
    //                 ->leftJoin('lideres_categorias as lc', 'lc.CATEGORIA_ID', '=', 'cc.ID_CATALOGO_CATEGORIA')
    //                 ->whereNull('lc.LIDER_ID')
    //                 ->pluck('ar.USUARIO_ID')
    //                 ->toArray();

    //             $usuariosACargo = array_merge($usuariosACargo, $usuariosSinLider);
    //         }

    //         $usuariosACargo = array_unique($usuariosACargo);



    //         $badgeVoBo = "<span style='
    //         background-color:#f4c542;
    //         color:black;
    //         padding:3px 8px;
    //         border-radius:6px;
    //         font-size:11px;
    //         font-weight:bold;
    //         display:inline-block;
    //     '>Vo.Bo</span>";

    //         $notiVoBo = recemplaedosModel::whereIn('USUARIO_ID', $usuariosACargo)
    //             ->where('DAR_BUENO', 0)
    //             ->whereIn('TIPO_SOLICITUD', [1, 3])
    //             ->orderBy('FECHA_SALIDA', 'desc')
    //             ->get()
    //             ->map(function ($n) use ($badgeVoBo) {
    //                 return [
    //                     'titulo'        => $this->textoTipoSolicitud($n->TIPO_SOLICITUD),
    //                     'detalle'       => $n->SOLICITANTE_SALIDA ?? 'Sin nombre',
    //                     'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SALIDA,
    //                     'estatus_badge' => $badgeVoBo,
    //                     'link'          => url('/solicitudesvobo')
    //                 ];
    //             });


    //         /**
    //          * 3️⃣ NOTIFICACIONES DE AUTORIZAR
    //          * Solo IDs 1,2,3
    //          */
    //         $autorizadores = [1, 2, 3];
    //         $notiAutorizar = collect([]);

    //         if (in_array($idUsuario, $autorizadores)) {

    //             $badgeAutorizar = "<span style='
    //             background-color:#3a87ad;
    //             color:white;
    //             padding:3px 8px;
    //             border-radius:6px;
    //             font-size:11px;
    //             font-weight:bold;
    //             display:inline-block;
    //         '>Aprobar</span>";

    //             $notiAutorizar = recemplaedosModel::where('DAR_BUENO', 1)
    //                 ->whereIn('TIPO_SOLICITUD', [1, 3])

    //                 ->where(function ($q) {
    //                     $q->whereNull('ESTADO_APROBACION')
    //                         ->orWhereNotIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
    //                 })

    //                 ->where(function ($q) use ($idUsuario, $autorizadores) {

    //                     $q->whereNull('JEFE_ID') 

    //                         ->orWhereNotIn('JEFE_ID', $autorizadores) 

    //                         ->orWhere('JEFE_ID', '!=', $idUsuario); 
    //                 })
    //                 ->orderBy('FECHA_SALIDA', 'desc')
    //                 ->get()
    //                 ->map(function ($n) use ($badgeAutorizar) {
    //                     return [
    //                         'titulo'        => $this->textoTipoSolicitud($n->TIPO_SOLICITUD),
    //                         'detalle'       => $n->SOLICITANTE_SALIDA ?? 'Sin nombre',
    //                         'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SALIDA,
    //                         'estatus_badge' => $badgeAutorizar,
    //                         'link'          => url('/solicitudesaprobaciones')
    //                     ];
    //                 });
    //         }


    //         /**
    //          * 4️⃣ UNIR NOTIFICACIONES
    //          */
    //         $resultado = $notiVoBo->merge($notiAutorizar)->values();

    //         return response()->json([
    //             'total' => $resultado->count(),
    //             'notificaciones' => $resultado
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }



    public function notificaciones()
    {
        try {
            $usuario = Auth::user();
            $idUsuario = $usuario->ID_USUARIO;
            $roles = $usuario->roles()->pluck('NOMBRE_ROL')->toArray();

            /**
             * 1 USUARIOS A CARGO (para Vo.Bo)
             */
            $categoriasLideradas = DB::table('lideres_categorias as lc')
                ->join('catalogo_categorias as cc', 'cc.ID_CATALOGO_CATEGORIA', '=', 'lc.LIDER_ID')
                ->whereIn('cc.NOMBRE_CATEGORIA', $roles)
                ->pluck('lc.CATEGORIA_ID')
                ->toArray();

            $usuariosACargo = DB::table('asignar_rol')
                ->whereIn('NOMBRE_ROL', function ($query) use ($categoriasLideradas) {
                    $query->select('NOMBRE_CATEGORIA')
                        ->from('catalogo_categorias')
                        ->whereIn('ID_CATALOGO_CATEGORIA', $categoriasLideradas);
                })
                ->pluck('USUARIO_ID')
                ->toArray();

            if (in_array('Director', $roles)) {

                $usuariosSinLider = DB::table('asignar_rol as ar')
                    ->leftJoin('catalogo_categorias as cc', 'cc.NOMBRE_CATEGORIA', '=', 'ar.NOMBRE_ROL')
                    ->leftJoin('lideres_categorias as lc', 'lc.CATEGORIA_ID', '=', 'cc.ID_CATALOGO_CATEGORIA')
                    ->whereNull('lc.LIDER_ID')
                    ->pluck('ar.USUARIO_ID')
                    ->toArray();

                $usuariosACargo = array_merge($usuariosACargo, $usuariosSinLider);
            }

            $usuariosACargo = array_unique($usuariosACargo);


            /**
             * 2 NOTIFICACIONES DE Vo.Bo RECURSOS EMPLEADOS (DAR_BUENO = 0)
             */

            $badgeVoBo = "<span style='
            background-color:#f4c542;
            color:black;
            padding:3px 8px;
            border-radius:6px;
            font-size:11px;
            font-weight:bold;
            display:inline-block;
            '>Vo.Bo</span>";

            $notiVoBo = recemplaedosModel::whereIn('USUARIO_ID', $usuariosACargo)
                ->where('DAR_BUENO', 0)
                ->whereIn('TIPO_SOLICITUD', [1, 3])
                ->orderBy('FECHA_SALIDA', 'desc')
                ->get()
                ->map(function ($n) use ($badgeVoBo) {
                    return [
                        'titulo'        => $this->textoTipoSolicitud($n->TIPO_SOLICITUD),
                        'detalle'       => $n->SOLICITANTE_SALIDA ?? 'Sin nombre',
                        'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SALIDA,
                        'estatus_badge' => $badgeVoBo,
                        'link'          => url('/solicitudesvobo')
                    ];
                });


            /**
             * 3 NOTIFICACIONES AUTORIZAR (TIPOS 1 y 3)
             */
            $autorizadores = [1, 2, 3];
            $notiAutorizar = collect([]);

            if (in_array($idUsuario, $autorizadores)) {

                $badgeAutorizar = "<span style='
                background-color:#3a87ad;
                color:white;
                padding:3px 8px;
                border-radius:6px;
                font-size:11px;
                font-weight:bold;
                display:inline-block;
                '>Aprobar</span>";

                $notiAutorizar = recemplaedosModel::where('DAR_BUENO', 1)
                    ->whereIn('TIPO_SOLICITUD', [1, 3])

                    ->where(function ($q) {
                        $q->whereNull('ESTADO_APROBACION')
                            ->orWhereNotIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
                    })

                    ->where(function ($q) use ($idUsuario, $autorizadores) {
                        $q->whereNull('JEFE_ID')
                            ->orWhereNotIn('JEFE_ID', $autorizadores)
                            ->orWhere('JEFE_ID', '!=', $idUsuario);
                    })

                    ->orderBy('FECHA_SALIDA', 'desc')
                    ->get()
                    ->map(function ($n) use ($badgeAutorizar) {

                        return [
                            'titulo'        => $this->textoTipoSolicitud($n->TIPO_SOLICITUD),
                            'detalle'       => $n->SOLICITANTE_SALIDA ?? 'Sin nombre',
                            'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SALIDA,
                            'estatus_badge' => $badgeAutorizar,
                            'link'          => url('/solicitudesaprobaciones')
                        ];
                    });
            }


            /**
             * 4 NOTIFICACIONES AUTORIZAR (TIPO 2 – SALIDA DE ALMACÉN)
             */
            $notiTipo2 = collect([]);

            if (in_array($idUsuario, $autorizadores)) {

                $badgeSalida = "<span style='
                background-color:#3a87ad;
                color:white;
                padding:3px 8px;
                border-radius:6px;
                font-size:11px;
                font-weight:bold;
                display:inline-block;
            '>Aprobar</span>";

                $notiTipo2 = recemplaedosModel::where('TIPO_SOLICITUD', 2)

                    ->where(function ($query) {
                        $query->whereNull('ESTADO_APROBACION')
                            ->orWhereNotIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
                    })

                    ->orderBy('FECHA_SALIDA', 'desc')
                    ->get()
                    ->map(function ($n) use ($badgeSalida) {
                        return [
                            'titulo'        => 'Autorizar salida de almacén',
                            'detalle'       => $n->SOLICITANTE_SALIDA ?? 'Sin nombre',
                            'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SALIDA,
                            'estatus_badge' => $badgeSalida,
                            'link'          => url('/aprobacionalmacen')
                        ];
                    });
            }


            /**
             * 5 NOTIFICACIONES – ENTREGA (Solo cuando solicitud tipo 2 aprobada)
             */
           

            $notiEntrega = collect([]);

            $usuariosQuePuedenEntregar = [1, 3, 52];

            if (in_array($idUsuario, $usuariosQuePuedenEntregar)) {

                $badgeEntrega = "<span style='
                    background-color:#ff9800;
                    color:white;
                    padding:3px 8px;
                    border-radius:6px;
                    font-size:11px;
                    font-weight:bold;
                    display:inline-block;
                '>Entregar</span>";

                $notiEntrega = recemplaedosModel::where('TIPO_SOLICITUD', 2)
                    ->where('ESTADO_APROBACION', 'Aprobada')

                    ->where(function ($q) {
                        $q->whereNull('FINALIZAR_SOLICITUD_ALMACEN')
                            ->orWhere('FINALIZAR_SOLICITUD_ALMACEN', '!=', 1);
                    })

                    ->where('USUARIO_ID', '!=', $idUsuario)

                    ->orderBy('FECHA_SALIDA', 'desc')
                    ->get()
                    ->map(function ($n) use ($badgeEntrega) {
                        return [
                            'titulo'        => 'Salida de almacén',
                            'detalle'       => $n->SOLICITANTE_SALIDA ?? 'Sin nombre',
                            'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SALIDA,
                            'estatus_badge' => $badgeEntrega,
                            'link'          => url('/salidaalmacen')
                        ];
                    });
            }


            /**
             * 6 NOTIFICACIONES DE Vo.Bo MR  (DAR_BUENO = 0)
             */

            $badgeVoBoMR = "<span style='
            background-color:#f4c542;
            color:black;
            padding:3px 8px;
            border-radius:6px;
            font-size:11px;
            font-weight:bold;
            display:inline-block;
            '>Vo.Bo</span>";

            $notiVoBoMR = mrModel::whereIn('USUARIO_ID', $usuariosACargo)
                ->where('DAR_BUENO', 0)
                ->orderBy('FECHA_SOLICITUD_MR', 'desc')
                ->get()
                ->map(function ($n) use ($badgeVoBoMR) {
                    return [
                        'titulo' => 'Vo.Bo MR: ' . $n->NO_MR,
                        'detalle'       => $n->SOLICITANTE_MR ?? 'Sin nombre',
                        'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SOLICITUD_MR,
                        'estatus_badge' => $badgeVoBoMR,
                        'link'          => url('/requisicionmaterialeslideres')
                    ];
                });





            /**
             * 7 NOTIFICACIONES DE AUTORIZAR MR  (DAR_BUENO = 0)
             */


            $autorizadores = [1, 2, 3];
            $notiAutorizarMR = collect([]);

            if (in_array($idUsuario, $autorizadores)) {

                $badgeAutorizarMR = "<span style='
                background-color:#3a87ad;
                color:white;
                padding:3px 8px;
                border-radius:6px;
                font-size:11px;
                font-weight:bold;
                display:inline-block;
                '>Aprobar</span>";

                $notiAutorizarMR = mrModel::where('DAR_BUENO', 1)
                    ->where(function ($q) {
                        $q->whereNull('ESTADO_APROBACION')
                            ->orWhereNotIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
                    })

                    ->where(function ($q) use ($idUsuario, $autorizadores) {
                        $q->whereNull('JEFEINMEDIATO_ID')
                            ->orWhereNotIn('JEFEINMEDIATO_ID', $autorizadores)
                            ->orWhere('JEFEINMEDIATO_ID', '!=', $idUsuario);
                    })

                    ->orderBy('FECHA_SOLICITUD_MR', 'desc')
                    ->get()
                    ->map(function ($n) use ($badgeAutorizarMR) {

                        return [
                            'titulo' => 'Aprobar MR: ' . $n->NO_MR,
                            'detalle'       => $n->SOLICITANTE_MR ?? 'Sin nombre',
                            'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SOLICITUD_MR,
                            'estatus_badge' => $badgeAutorizarMR,
                            'link'          => url('/requisicionmaterialesaprobacion')
                        ];
                    });
            }











            $resultado = collect($notiVoBo)
                ->merge(collect($notiAutorizar))
                ->merge(collect($notiTipo2))
                ->merge(collect($notiEntrega))
                ->merge(collect($notiVoBoMR))
                ->merge(collect($notiAutorizarMR))
                ->sortByDesc(function ($item) {

                    $fechaLimpia = trim(str_replace('Fecha solicitud:', '', $item['fecha']));

                    return strtotime($fechaLimpia); 
                })
                ->values();

         



            return response()->json([
                'total' => $resultado->count(),
                'notificaciones' => $resultado
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    private function textoTipoSolicitud($tipo)
    {
        if ($tipo == 1) return 'Aviso de ausencia y/o permiso';
        if ($tipo == 3) return 'Solicitud de Vacaciones';
        return 'Solicitud';
    }



}
