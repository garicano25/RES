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

            $autorizadores = [1,2,3];
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
                            'titulo'        => 'Aprobar salida de almacén',
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

            $usuariosQuePuedenEntregar = [1,3,52];

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

            $autorizadores = [1,2, 3];
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
                            'titulo' => 'Aprobar MR:<br> ' . $n->NO_MR,
                            'detalle'       => $n->SOLICITANTE_MR ?? 'Sin nombre',
                            'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SOLICITUD_MR,
                            'estatus_badge' => $badgeAutorizarMR,
                            'link'          => url('/requisicionmaterialesaprobacion')
                        ];
                    });
            }


            /**
             * 8 NOTIFICACIONES – MR PENDIENTE EN BITÁCORA (solo usuarios 1 y 3)
             */

            $notiBitacoraMR = collect([]);

            $usuariosMR = [1,3];

            if (in_array($idUsuario, $usuariosMR)) {

                $badgeMR = "<span style='
                    background-color:#ff9800;
                    color:white;
                    padding:3px 8px;
                    border-radius:6px;
                    font-size:11px;
                    font-weight:bold;
                    display:inline-block;
                    '>Pendiente</span>";

                $notiBitacoraMR = mrModel::where('ESTADO_APROBACION', 'Aprobada')

                    ->whereNotIn('NO_MR', function ($q) {
                        $q->select('NO_MR')->from('hoja_trabajo');
                    })

                    ->orderBy('FECHA_SOLICITUD_MR', 'desc')
                    ->get()
                    ->map(function ($n) use ($badgeMR) {

                        return [
                            'titulo'        => 'Tienes una MR en la Bitácora:' . $n->NO_MR,
                            'detalle'       => $n->SOLICITANTE_MR ?? 'Sin nombre',
                            'fecha'         => 'Fecha solicitud: ' . $n->FECHA_SOLICITUD_MR,
                            'estatus_badge' => $badgeMR,
                            'link'          => url('/bitacora')
                        ];
                    });
            }



            /**
             * 9 NOTIFICACIONES – VERIFICACIÓN DE MR (HojaTrabajo) – Usuarios  y 2
             */
        
            $notiVerificacionMR = collect([]);

            $usuariosVerificacion = [1,2];

            if (in_array($idUsuario, $usuariosVerificacion)) {

                $badgeVerif = "<span style='
                    background-color:#3a87ad;
                    color:white;
                    padding:3px 8px;
                    border-radius:6px;
                    font-size:11px;
                    font-weight:bold;
                    display:inline-block;
                '>Aprobar</span>";

                $listaMR = HojaTrabajo::select('NO_MR')
                    ->where('SOLICITAR_VERIFICACION', 'Sí')
                    ->groupBy('NO_MR')
                    ->get();

                $notiVerificacionMR = $listaMR->filter(function ($mr) {

                    $registros = HojaTrabajo::where('NO_MR', $mr->NO_MR)->get();

                 
                    $todosRequierenMatriz = $registros->every(function ($item) {
                        return $item->REQUIERE_MATRIZ === "Sí";
                    });
                    if ($todosRequierenMatriz) return false;

                  
                    $todosFinalizados = $registros->every(function ($item) {
                        return in_array($item->ESTADO_APROBACION, ['Aprobada', 'Rechazada']);
                    });
                    if ($todosFinalizados) return false;


                    $pendienteSinMatriz = $registros->contains(function ($item) {
                        return
                            $item->SOLICITAR_VERIFICACION === "Sí" &&
                            ($item->REQUIERE_MATRIZ !== "Sí" || $item->REQUIERE_MATRIZ === null) &&
                            !in_array($item->ESTADO_APROBACION, ['Aprobada', 'Rechazada']);
                    });

                    if ($pendienteSinMatriz) {
                        return true;
                    }

                
                    $regSinMatriz = $registros->filter(function ($item) {
                        return $item->REQUIERE_MATRIZ !== "Sí" || $item->REQUIERE_MATRIZ === null;
                    });

                    if ($regSinMatriz->count() > 0) {
                        $sinMatrizFinalizados = $regSinMatriz->every(function ($item) {
                            return in_array($item->ESTADO_APROBACION, ['Aprobada', 'Rechazada']);
                        });

                        if ($sinMatrizFinalizados) return false;
                    }

                    return false; 
                })

                    ->map(function ($mr) use ($badgeVerif) {

                        $registro = HojaTrabajo::where('NO_MR', $mr->NO_MR)->first();

                        return [
                            'titulo'        => 'Aprobar bitácora MR:<br> ' . $mr->NO_MR,
                            'detalle'       => 'Solicitud de aprobación',
                            'fecha'         => 'Fecha solicitud: ' . ($registro->FECHA_VERIFICACION ?? ''),
                            'estatus_badge' => $badgeVerif,
                            'link'          => url('/bitacora')
                        ];
                    });
            }


            /**
             * 10  NOTIFICACIONES DE MATRIZ COMPARATIVA 
             */
          
            $notiMatrizComparativa = collect([]);

            $usuariosMatriz = [1, 3];

            if (in_array($idUsuario, $usuariosMatriz)) {

                $badgeMatriz = "<span style='
                    background-color:#ff9800;
                    color:white;
                    padding:3px 8px;
                    border-radius:6px;
                    font-size:11px;
                    font-weight:bold;
                    display:inline-block;
                '>Pendiente</span>";

                $registros = DB::table('formulario_matrizcomparativa')
                    ->select('NO_MR', 'SOLICITAR_VERIFICACION', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy('NO_MR'); 

                $notiMatrizComparativa = collect($registros)->filter(function ($group) {

                    $yaSolicitada = collect($group)->contains(function ($item) {
                        return $item->SOLICITAR_VERIFICACION === "Sí";
                    });

                    return !$yaSolicitada;
                })->map(function ($group) use ($badgeMatriz) {

                    $mr = $group->first();

                    return [
                        'titulo'        => 'Matriz comparativa: <br>' . $mr->NO_MR,
                        'detalle'       => 'Pendiente por realizar',
                        'fecha'         => date('Y-m-d', strtotime($mr->created_at)),
                        'fecha_sort'    => date('Y-m-d H:i:s', strtotime($mr->created_at)),
                        'estatus_badge' => $badgeMatriz,
                        'link'          => url('/matrizcomparativa')
                    ];
                });
            }

            /**
             * 11 NOTIFICACIONES – PARA APROBAR MATRIZ
             * 
             */
          
            $notiAprobarMatriz = collect([]);

            $usuariosAprobadoresVerif = [1, 2];

            if (in_array($idUsuario, $usuariosAprobadoresVerif)) {

                $badgeVerificacion = "<span style='
                    background-color:#3a87ad;
                    color:white;
                    padding:3px 8px;
                    border-radius:6px;
                    font-size:11px;
                    font-weight:bold;
                    display:inline-block;
                '>Aprobar</span>";

                $registros = DB::table('formulario_matrizcomparativa')
                    ->select('NO_MR', 'SOLICITAR_VERIFICACION', 'ESTADO_APROBACION', 'FECHA_SOLCITIUD')
                    ->orderBy('FECHA_SOLCITIUD', 'desc')
                    ->get()
                    ->groupBy('NO_MR');

                $notiAprobarMatriz = collect($registros)->filter(function ($group) {

                    $solicitoVerificacion = collect($group)->contains(function ($item) {
                        return $item->SOLICITAR_VERIFICACION === "Sí";
                    });

                    if (!$solicitoVerificacion) return false;

                    $finalizados = collect($group)->every(function ($item) {
                        return in_array($item->ESTADO_APROBACION, ['Aprobada', 'Rechazada']);
                    });

                    if ($finalizados) return false;

                    return true;
                })->map(function ($group) use ($badgeVerificacion) {

                    $mr = $group->first();

                    return [
                        'titulo'        => 'Aprobar de matriz comparativa:' . $mr->NO_MR,
                        'detalle'       => 'Solicitud de aprobación',
                        'fecha'         => 'Fecha solicitud: ' . ($mr->FECHA_SOLCITIUD ?? ''),
                        'estatus_badge' => $badgeVerificacion,
                        'link'          => url('/matrizaprobacion')
                    ];
                });
            }


            /**
             * 12 NOTIFICACIONES – PARA ORDEN DE COMPRA
             * 
             */

            $notiOrdencompra = collect([]);

            $usuariosPO = [1, 3];

            if (in_array($idUsuario, $usuariosPO)) {

                $badgePO = "<span style='
                    background-color:#ff9800;
                    color:white;
                    padding:3px 8px;
                    border-radius:6px;
                    font-size:11px;
                    font-weight:bold;
                    display:inline-block;
                    '>Pendiente</span>";

                $registros = DB::table('formulario_ordencompra')
                    ->select('NO_PO', 'SOLICITAR_AUTORIZACION', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy('NO_PO');

                $notiOrdencompra = collect($registros)->filter(function ($group) {

                    $yaSolicitadapo = collect($group)->contains(function ($item) {
                        return $item->SOLICITAR_AUTORIZACION === "Sí";
                    });

                    return !$yaSolicitadapo;
                })->map(function ($group) use ($badgePO) {

                    $mr = $group->first();

                    return [
                        'titulo'        => 'Orden de compra:<br>' . $mr->NO_PO,
                        'detalle'       => 'Pendiente por realizar',
                        'fecha'         => date('Y-m-d', strtotime($mr->created_at)),
                        'fecha_sort'    => date('Y-m-d H:i:s', strtotime($mr->created_at)),
                        'estatus_badge' => $badgePO,
                        'link'          => url('/ordencompra')
                    ];
                });
            }





            /**
             * 13 NOTIFICACIONES – PARA APROBAR PO
             * 
             */

            $notiAprobarPO = collect([]);

            $usuariosAprobadoresPO = [1, 2];

            if (in_array($idUsuario, $usuariosAprobadoresPO)) {

                $badgeVerificacionPo = "<span style='
                    background-color:#3a87ad;
                    color:white;
                    padding:3px 8px;
                    border-radius:6px;
                    font-size:11px;
                    font-weight:bold;
                    display:inline-block;
                    '>Aprobar</span>";

                $registros = DB::table('formulario_ordencompra')
                    ->select('NO_PO', 'SOLICITAR_AUTORIZACION', 'ESTADO_APROBACION', 'FECHA_SOLCITIUD')
                    ->orderBy('FECHA_SOLCITIUD', 'desc')
                    ->get()
                    ->groupBy('NO_PO');

                $notiAprobarPO = collect($registros)->filter(function ($group) {

                    $solicitoVerificacionPo = collect($group)->contains(function ($item) {
                        return $item->SOLICITAR_AUTORIZACION === "Sí";
                    });

                    if (!$solicitoVerificacionPo) return false;

                    $finalizados = collect($group)->every(function ($item) {
                        return in_array($item->ESTADO_APROBACION, ['Aprobada', 'Rechazada']);
                    });

                    if ($finalizados) return false;

                    return true;
                })->map(function ($group) use ($badgeVerificacionPo) {

                    $mr = $group->first();

                    return [
                        'titulo'        => 'Aprobar PO:<br>' . $mr->NO_PO,
                        'detalle'       => 'Solicitud de aprobación',
                        'fecha'         => 'Fecha solicitud: ' . ($mr->FECHA_SOLCITIUD ?? ''),
                        'estatus_badge' => $badgeVerificacionPo,
                        'link'          => url('/ordencompraaprobacion')
                    ];
                });
            }



            $resultado = collect($notiVoBo)
                ->merge(collect($notiAutorizar))
                ->merge(collect($notiTipo2))
                ->merge(collect($notiEntrega))
                ->merge(collect($notiVoBoMR))
                ->merge(collect($notiAutorizarMR))
                ->merge(collect($notiBitacoraMR))
                ->merge(collect($notiVerificacionMR))
                ->merge(collect($notiMatrizComparativa))
                ->merge(collect($notiAprobarMatriz))
                ->merge(collect($notiOrdencompra))
                ->merge(collect($notiAprobarPO))



                ->sortByDesc(function ($item) {

                if (isset($item['fecha_sort'])) {
                    return strtotime($item['fecha_sort']);
                }

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
