<?php

namespace App\Http\Controllers\requisicongr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\inventarioModel;
use App\Models\inventario\catalogotipoinventarioModel;



class grController extends Controller
{


    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();
        
        
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $inventario = inventarioModel::where('ACTIVO', 1)->get();



        return view('compras.recepciongr.recepcionbienesgr', compact('proveedoresOficiales', 'proveedoresTemporales', 'tipoinventario','inventario'));
    }




    public function Tablabitacoragr()
    {
        try {
            $poUltimo = DB::table('formulario_ordencompra as po')
                ->select(
                    'po.ID_FORMULARIO_PO',
                    'po.NO_PO',
                    'po.HOJA_ID',
                    'po.FECHA_APROBACION',
                    'po.FECHA_ENTREGA',
                    'po.PROVEEDOR_SELECCIONADO',
                    'po.MATERIALES_JSON',
                    'po.ESTADO_APROBACION'
                )
                ->join(
                    DB::raw('(
            SELECT 
                REPLACE(SUBSTRING_INDEX(NO_PO, "-Rev", 1), " ", "") AS PO_BASE,
                MAX(FECHA_APROBACION) AS max_fecha
            FROM formulario_ordencompra
            GROUP BY PO_BASE
        ) AS ult'),
                    function ($join) {
                        $join->on(
                            DB::raw('REPLACE(SUBSTRING_INDEX(po.NO_PO, "-Rev", 1), " ", "")'),
                            '=',
                            'ult.PO_BASE'
                        )
                            ->on('po.FECHA_APROBACION', '=', 'ult.max_fecha');
                    }
                );

            // === CONSULTA ORIGINAL PARA CASOS CON PO ===
            $rowsConPO = DB::table('hoja_trabajo as ht')
                ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
                ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 'mr.USUARIO_ID') 
                ->leftJoinSub($poUltimo, 'po', function ($join) {
                    $join->whereRaw("
            FIND_IN_SET(
                CAST(ht.id AS CHAR), 
                REPLACE(REPLACE(REPLACE(REPLACE(po.HOJA_ID, '[', ''), ']', ''), '\"', ''), ' ', '')
            )
        ");
                })
                ->leftJoin('formulario_altaproveedor as prov', function ($join) {
                    $join->on('prov.RFC_ALTA', '=', 'po.PROVEEDOR_SELECCIONADO');
                })
                ->leftJoin('formulario_proveedortemp as provtemp', function ($join) {
                    $join->on('provtemp.RAZON_PROVEEDORTEMP', '=', 'po.PROVEEDOR_SELECCIONADO');
                })
                ->whereNotNull('po.NO_PO')
                ->where('po.ESTADO_APROBACION', 'Aprobada')
                ->select([
                    DB::raw('COALESCE(po.NO_PO, CONCAT("HT-", ht.id)) as AGRUPADOR'),
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    DB::raw("CONCAT(u.EMPLEADO_NOMBRE, ' ', u.EMPLEADO_APELLIDOPATERNO, ' ', u.EMPLEADO_APELLIDOMATERNO) as USUARIO_NOMBRE"), // Nombre usuario
                    'po.NO_PO',
                    'po.FECHA_APROBACION as FECHA_APROBACION_PO',
                    'po.FECHA_ENTREGA as FECHA_ENTREGA_PO',
                    DB::raw("
            CASE 
                WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL 
                    THEN CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
                WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL 
                    THEN CONCAT(provtemp.RAZON_PROVEEDORTEMP, 
                        IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', 
                            CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
                ELSE NULL 
            END as PROVEEDOR
        "),
                    'po.MATERIALES_JSON',
                    DB::raw('NULL as HT_DESCRIPCION'),
                    DB::raw('NULL as MATERIALES_HOJA_JSON'),
                    DB::raw('po.PROVEEDOR_SELECCIONADO as PROVEEDOR_KEY'),
                    DB::raw('NULL as PROVEEDOR_Q1'),
                    DB::raw('NULL as PROVEEDOR_Q2'),
                    DB::raw('NULL as PROVEEDOR_Q3'),
                    DB::raw('NULL as CANTIDAD_REALQ1'),
                    DB::raw('NULL as CANTIDAD_REALQ2'),
                    DB::raw('NULL as CANTIDAD_REALQ3'),
                    DB::raw('NULL as PRECIO_UNITARIOQ1'),
                    DB::raw('NULL as PRECIO_UNITARIOQ2'),
                    DB::raw('NULL as PRECIO_UNITARIOQ3'),
                     DB::raw('NULL as UNIDAD_MEDIDA')


            ])
                ->groupBy(
                    'AGRUPADOR',
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    'u.EMPLEADO_NOMBRE',
                    'u.EMPLEADO_APELLIDOPATERNO',
                    'u.EMPLEADO_APELLIDOMATERNO',
                    'po.NO_PO',
                    'po.FECHA_APROBACION',
                    'po.FECHA_ENTREGA',
                    'prov.RAZON_SOCIAL_ALTA',
                    'prov.RFC_ALTA',
                    'po.MATERIALES_JSON',
                    'provtemp.RAZON_PROVEEDORTEMP',
                    'provtemp.RFC_PROVEEDORTEMP',
                    'po.PROVEEDOR_SELECCIONADO'
                );

            // === CONSULTA PARA CASOS SIN PO ===
            $rowsSinPO = DB::table('hoja_trabajo as ht')
                ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
                ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 'mr.USUARIO_ID') 
                ->leftJoinSub($poUltimo, 'po', function ($join) {
                    $join->whereRaw("
            FIND_IN_SET(
                CAST(ht.id AS CHAR), 
                REPLACE(REPLACE(REPLACE(REPLACE(po.HOJA_ID, '[', ''), ']', ''), '\"', ''), ' ', '')
            )
        ");
                })
                ->leftJoin('formulario_altaproveedor as prov', function ($join) {
                    $join->on('prov.RFC_ALTA', '=', 'ht.PROVEEDOR_SELECCIONADO');
                })
                ->leftJoin('formulario_proveedortemp as provtemp', function ($join) {
                    $join->on('provtemp.RAZON_PROVEEDORTEMP', '=', 'ht.PROVEEDOR_SELECCIONADO');
                })
                ->whereNull('po.NO_PO')
                ->where('ht.ESTADO_APROBACION', 'Aprobada')
                ->select([
                    DB::raw('CONCAT("HT-", ht.NO_MR, "-", ht.PROVEEDOR_SELECCIONADO) as AGRUPADOR'),
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    DB::raw("CONCAT(u.EMPLEADO_NOMBRE, ' ', u.EMPLEADO_APELLIDOPATERNO, ' ', u.EMPLEADO_APELLIDOMATERNO) as USUARIO_NOMBRE"), 
                    DB::raw('NULL as NO_PO'),
                    DB::raw('NULL as FECHA_APROBACION_PO'),
                    DB::raw('NULL as FECHA_ENTREGA_PO'),
                    DB::raw("
            CASE 
                WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL 
                    THEN CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
                WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL 
                    THEN CONCAT(provtemp.RAZON_PROVEEDORTEMP, 
                        IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', 
                            CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
                WHEN ht.PROVEEDOR_SELECCIONADO IS NOT NULL 
                    THEN ht.PROVEEDOR_SELECCIONADO
                ELSE NULL 
            END as PROVEEDOR
        "),
                    DB::raw('NULL as MATERIALES_JSON'),
                    'ht.DESCRIPCION as HT_DESCRIPCION',
                    'ht.MATERIALES_HOJA_JSON',
                    'ht.PROVEEDOR_SELECCIONADO as PROVEEDOR_KEY',
                    'ht.PROVEEDOR_Q1',
                    'ht.PROVEEDOR_Q2',
                    'ht.PROVEEDOR_Q3',
                    'ht.CANTIDAD_REALQ1',
                    'ht.CANTIDAD_REALQ2',
                    'ht.CANTIDAD_REALQ3',
                    'ht.PRECIO_UNITARIOQ1',
                    'ht.PRECIO_UNITARIOQ2',
                    'ht.PRECIO_UNITARIOQ3',
                    'ht.UNIDAD_MEDIDA'
                ]);

            // === UNIR CONSULTAS ===
            $union = $rowsConPO->unionAll($rowsSinPO);

            // === AGRUPACIÓN FINAL ===
            $rows = DB::query()
                ->fromSub($union, 't')
                ->orderBy('t.NO_MR', 'desc')
                ->get()
                ->groupBy('AGRUPADOR')
                ->map(function ($group) {
                    $first = $group->first();

                    $materialesArray = [];
                    $vistos = [];

                // foreach ($group as $row) {
                //     if (!empty($row->MATERIALES_JSON)) {
                //         $materiales = json_decode($row->MATERIALES_JSON, true);

                //         if (is_array($materiales)) {
                //             foreach ($materiales as $mat) {
                //                 $cantidad = $mat['CANTIDAD_'] ?? 0;
                //                 $precio   = $mat['PRECIO_UNITARIO'] ?? null;
                //                 $key      = $mat['DESCRIPCION'] . '-' . $cantidad . '-' . $precio;

                //                 if ($cantidad > 0 && !isset($vistos[$key])) {
                //                     $vistos[$key] = true;
                //                     $texto = "• {$mat['DESCRIPCION']} ({$cantidad})";
                //                     if ($precio !== null && $precio !== '') {
                //                         $texto .= " - $ {$precio}";
                //                     }
                //                     $materialesArray[] = $texto;
                //                 }
                //             }
                //         }
                //     } elseif (!empty($row->MATERIALES_HOJA_JSON)) {
                //         $materiales = json_decode($row->MATERIALES_HOJA_JSON, true);
                //         if (is_array($materiales)) {
                //             foreach ($materiales as $mat) {
                //                 $cantidad = $mat['CANTIDAD_REAL'] ?? ($mat['CANTIDAD'] ?? 0);
                //                 if ($cantidad <= 0) continue;

                //                 $precio = null;
                //                 if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
                //                     $precio = $mat['PRECIO_UNITARIO'] ?? null;
                //                 } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
                //                     $precio = $mat['PRECIO_UNITARIO_Q2'] ?? null;
                //                 } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
                //                     $precio = $mat['PRECIO_UNITARIO_Q3'] ?? null;
                //                 }

                //                 $key = $mat['DESCRIPCION'] . '-' . $cantidad . '-' . $precio;
                //                 if (!isset($vistos[$key])) {
                //                     $vistos[$key] = true;
                //                     $texto = "• {$mat['DESCRIPCION']} ({$cantidad})";
                //                     if ($precio !== null && $precio !== '') {
                //                         $texto .= " - $ {$precio}";
                //                     }
                //                     $materialesArray[] = $texto;
                //                 }
                //             }
                //         }
                //     } elseif (!empty($row->HT_DESCRIPCION)) {
                //         $cantidad = 0;
                //         $precio   = null;

                //         if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
                //             $cantidad = $row->CANTIDAD_REALQ1;
                //             $precio   = $row->PRECIO_UNITARIOQ1;
                //         } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
                //             $cantidad = $row->CANTIDAD_REALQ2;
                //             $precio   = $row->PRECIO_UNITARIOQ2;
                //         } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
                //             $cantidad = $row->CANTIDAD_REALQ3;
                //             $precio   = $row->PRECIO_UNITARIOQ3;
                //         }

                //         if ($cantidad > 0) {
                //             $key = $row->HT_DESCRIPCION . '-' . $cantidad . '-' . $precio;
                //             if (!isset($vistos[$key])) {
                //                 $vistos[$key] = true;
                //                 $texto = "• {$row->HT_DESCRIPCION} ({$cantidad})";
                //                 if ($precio !== null && $precio !== '') {
                //                     $texto .= " - $ {$precio}";
                //                 }
                //                 $materialesArray[] = $texto;
                //             }
                //         }
                //     }
                // }

                foreach ($group as $row) {
                    // === Caso 1: MATERIALES_JSON (cuando tiene PO) ===
                    if (!empty($row->MATERIALES_JSON)) {
                        $materiales = json_decode($row->MATERIALES_JSON, true);

                        if (is_array($materiales)) {
                            foreach ($materiales as $mat) {
                                $cantidad     = $mat['CANTIDAD_'] ?? 0;
                                $precio       = $mat['PRECIO_UNITARIO'] ?? null;
                                $unidad       = $mat['UNIDAD_MEDIDA'] ?? '';
                                $descripcion  = $mat['DESCRIPCION'] ?? '';

                                $key = $descripcion . '-' . $cantidad . '-' . $precio . '-' . $unidad;

                                if ($cantidad > 0 && !isset($vistos[$key])) {
                                    $vistos[$key] = true;
                                    $texto = "• {$descripcion} ({$cantidad} {$unidad})"; // 👈 unidad incluida
                                    if ($precio !== null && $precio !== '') {
                                        $texto .= " - $ {$precio}";
                                    }
                                    $materialesArray[] = $texto;
                                }
                            }
                        }
                    }

                    // === Caso 2: MATERIALES_HOJA_JSON (cuando no tiene PO pero sí JSON en hoja) ===
                    elseif (!empty($row->MATERIALES_HOJA_JSON)) {
                        $materiales = json_decode($row->MATERIALES_HOJA_JSON, true);
                        if (is_array($materiales)) {
                            foreach ($materiales as $mat) {
                                $cantidad     = $mat['CANTIDAD_REAL'] ?? ($mat['CANTIDAD'] ?? 0);
                                if ($cantidad <= 0) continue;

                                $unidad      = $mat['UNIDAD_MEDIDA'] ?? '';
                                $descripcion = $mat['DESCRIPCION'] ?? '';

                                $precio = null;
                                if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
                                    $precio = $mat['PRECIO_UNITARIO'] ?? null;
                                } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
                                    $precio = $mat['PRECIO_UNITARIO_Q2'] ?? null;
                                } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
                                    $precio = $mat['PRECIO_UNITARIO_Q3'] ?? null;
                                }

                                $key = $descripcion . '-' . $cantidad . '-' . $precio . '-' . $unidad;
                                if (!isset($vistos[$key])) {
                                    $vistos[$key] = true;
                                    $texto = "• {$descripcion} ({$cantidad} {$unidad})"; // 👈 unidad incluida
                                    if ($precio !== null && $precio !== '') {
                                        $texto .= " - $ {$precio}";
                                    }
                                    $materialesArray[] = $texto;
                                }
                            }
                        }
                    }

                    // === Caso 3: HT_DESCRIPCION (sin JSON, directo desde hoja_trabajo) ===
                    elseif (!empty($row->HT_DESCRIPCION)) {
                        $cantidad     = 0;
                        $precio       = null;
                        $unidad       = $row->UNIDAD_MEDIDA ?? ''; // 👈 asegúrate de traerlo en el SELECT
                        $descripcion  = $row->HT_DESCRIPCION;

                        if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
                            $cantidad = $row->CANTIDAD_REALQ1;
                            $precio   = $row->PRECIO_UNITARIOQ1;
                        } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
                            $cantidad = $row->CANTIDAD_REALQ2;
                            $precio   = $row->PRECIO_UNITARIOQ2;
                        } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
                            $cantidad = $row->CANTIDAD_REALQ3;
                            $precio   = $row->PRECIO_UNITARIOQ3;
                        }

                        if ($cantidad > 0) {
                            $key = $descripcion . '-' . $cantidad . '-' . $precio . '-' . $unidad;
                            if (!isset($vistos[$key])) {
                                $vistos[$key] = true;
                                $texto = "• {$descripcion} ({$cantidad} {$unidad})"; // 👈 unidad incluida
                                if ($precio !== null && $precio !== '') {
                                    $texto .= " - $ {$precio}";
                                }
                                $materialesArray[] = $texto;
                            }
                        }
                    }
                }



                $bienes = '';
                    if (!empty($materialesArray)) {
                        $mostrar = array_slice($materialesArray, 0, 3);
                        $ocultos = array_slice($materialesArray, 3);

                        foreach ($mostrar as $m) {
                            $bienes .= "<div>{$m}</div>";
                        }

                        if (!empty($ocultos)) {
                            $bienes .= '<div class="extra-materiales" style="display:none">';
                            foreach ($ocultos as $m) {
                                $bienes .= "<div>{$m}</div>";
                            }
                            $bienes .= '</div>';
                            $bienes .= '<button type="button" class="btn-ver-mas-materiales btn btn-link p-0">Ver más</button>';
                        }
                    } else {
                        $bienes = '-';
                    }

                    $first->BIEN_SERVICIO = $bienes;
                    unset($first->MATERIALES_JSON, $first->HT_DESCRIPCION, $first->MATERIALES_HOJA_JSON);

                    return $first;
                })
                ->values();

            return response()->json(['data' => $rows]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }




    // public function guardarGR(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $usuarioId = DB::table('formulario_requisiconmaterial')
    //             ->where('NO_MR', $request->modal_no_mr)
    //             ->value('USUARIO_ID');

    //         if ($request->ID_GR && $request->ID_GR > 0) {
    //             // ========================
    //             // MODO EDITAR
    //             // ========================
    //             $idGR = $request->ID_GR;

    //             DB::table('formulario_bitacoragr')
    //                 ->where('ID_GR', $idGR)
    //                 ->update([
    //                     'NO_GR'            => null, 
    //                     'NO_MR'            => $request->modal_no_mr,
    //                     'NO_PO'            => $request->modal_no_po,
    //                     'PROVEEDOR_KEY'    => $request->PROVEEDOR_EQUIPO,
    //                     'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
    //                     'USUARIO_ID'       => $usuarioId,
    //                     'FECHA_EMISION'    => $request->DESDE_ACREDITACION,
    //                     'NO_RECEPCION'     => $request->NO_RECEPCION,
    //                     'MANDAR_USUARIO_VOBO'     => $request->MANDAR_USUARIO_VOBO,
    //                     'VO_BO_USUARIO'     => $request->VO_BO_USUARIO,
    //                     'FECHA_VOUSUARIO'     => $request->FECHA_VOUSUARIO,



    //             ]);

    //             DB::table('formulario_bitacoragr_detalle')
    //                 ->where('ID_GR', $idGR)
    //                 ->delete();

    //             foreach ($request->DESCRIPCION as $i => $desc) {
    //                 $tipoEquipoId   = $request->TIPO_INVENTARIO[$i] ?? null;
    //                 $tipoEquipoDesc = null;

    //                 if ($tipoEquipoId) {
    //                     $tipoEquipoDesc = DB::table('catalogo_tipoinventario')
    //                         ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
    //                         ->value('DESCRIPCION_TIPO');
    //                 }

    //                 DB::table('formulario_bitacoragr_detalle')->insert([
    //                     'ID_GR'                 => $idGR,
    //                     'DESCRIPCION'           => $desc,
    //                     'CANTIDAD'              => $request->CANTIDAD[$i] ?? 0,
    //                     'CANTIDAD_RECHAZADA'    => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
    //                     'CANTIDAD_ACEPTADA'     => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
    //                     'PRECIO_UNITARIO'       => $request->PRECIO_UNITARIO[$i] ?? null,
    //                     'CUMPLE'                => $request->CUMPLE[$i] ?? null,
    //                     'COMENTARIO_CUMPLE'     => $request->COMENTARIO_CUMPLE[$i] ?? null,
    //                     'ESTADO_BS'             => $request->ESTADO_BS[$i] ?? null,
    //                     'COMENTARIO_ESTADO'     => $request->COMENTARIO_ESTADO[$i] ?? null,
    //                     'COMENTARIO_DIFERENCIA' => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
    //                     'PRECIO_TOTAL_MR'       => $request->PRECIO_TOTAL_MR[$i] ?? null,
    //                     'PRECIO_UNITARIO_GR'    => $request->PRECIO_UNITARIO_GR[$i] ?? null,
    //                     'PRECIO_TOTAL_GR'       => $request->PRECIO_TOTAL_GR[$i] ?? null,
    //                     'TIPO_BS'               => $request->TIPO_BS[$i] ?? null,
    //                     'TIPO_EQUIPO'           => $tipoEquipoDesc,
    //                     'INVENTARIO_ID'         => $request->INVENTARIO[$i] ?? null,
    //                     'EN_INVENTARIO'         => $request->EN_INVENTARIO[$i] ?? null,
    //                     'CANTIDAD_ACEPTADA_USUARIO'         => $request->CANTIDAD_ACEPTADA_USUARIO[$i] ?? null,
    //                     'CUMPLE_ESPECIFICADO_USUARIO'         => $request->CUMPLE_ESPECIFICADO_USUARIO[$i] ?? null,
    //                     'COMENTARIO_CUMPLE_USUARIO'         => $request->COMENTARIO_CUMPLE_USUARIO[$i] ?? null,
    //                     'ESTADO_BS_USUARIO'         => $request->ESTADO_BS_USUARIO[$i] ?? null,
    //                     'COMENTARIO_ESTADO_USUARIO'         => $request->COMENTARIO_ESTADO_USUARIO[$i] ?? null,





    //                 ]);
    //             }

    //             DB::commit();
    //             return response()->json([
    //                 'ok'   => true,
    //                 'edit' => true,
    //                 'msg'  => "GR actualizada correctamente",
    //             ]);
    //         } else {
    //             // ========================
    //             // MODO CREAR
    //             // ========================
    //             $noRecepcion = $this->generarNoRecepcion();

    //             $idGR = DB::table('formulario_bitacoragr')->insertGetId([
    //                 'NO_GR'            => null,
    //                 'NO_MR'            => $request->modal_no_mr,
    //                 'NO_PO'            => $request->modal_no_po,
    //                 'PROVEEDOR_KEY'    => $request->PROVEEDOR_EQUIPO,
    //                 'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
    //                 'USUARIO_ID'       => $usuarioId,
    //                 'FECHA_EMISION'    => $request->DESDE_ACREDITACION,
    //                 'NO_RECEPCION'     => $noRecepcion,
    //                 'MANDAR_USUARIO_VOBO'   => $request->MANDAR_USUARIO_VOBO,
    //                 'CREATED_AT'       => now(),
    //             ]);

    //             foreach ($request->DESCRIPCION as $i => $desc) {
    //                 $tipoEquipoId   = $request->TIPO_INVENTARIO[$i] ?? null;
    //                 $tipoEquipoDesc = null;

    //                 if ($tipoEquipoId) {
    //                     $tipoEquipoDesc = DB::table('catalogo_tipoinventario')
    //                         ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
    //                         ->value('DESCRIPCION_TIPO');
    //                 }

    //                 DB::table('formulario_bitacoragr_detalle')->insert([
    //                     'ID_GR'                 => $idGR,
    //                     'DESCRIPCION'           => $desc,
    //                     'CANTIDAD'              => $request->CANTIDAD[$i] ?? 0,
    //                     'CANTIDAD_RECHAZADA'    => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
    //                     'CANTIDAD_ACEPTADA'     => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
    //                     'PRECIO_UNITARIO'       => $request->PRECIO_UNITARIO[$i] ?? null,
    //                     'CUMPLE'                => $request->CUMPLE[$i] ?? null,
    //                     'COMENTARIO_CUMPLE'     => $request->COMENTARIO_CUMPLE[$i] ?? null,
    //                     'ESTADO_BS'             => $request->ESTADO_BS[$i] ?? null,
    //                     'COMENTARIO_ESTADO'     => $request->COMENTARIO_ESTADO[$i] ?? null,
    //                     'COMENTARIO_DIFERENCIA' => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
    //                     'TIPO_BS'               => $request->TIPO_BS[$i] ?? null,
    //                     'PRECIO_TOTAL_MR'       => $request->PRECIO_TOTAL_MR[$i] ?? null,
    //                     'PRECIO_UNITARIO_GR'    => $request->PRECIO_UNITARIO_GR[$i] ?? null,
    //                     'PRECIO_TOTAL_GR'       => $request->PRECIO_TOTAL_GR[$i] ?? null,
    //                     'TIPO_EQUIPO'           => $tipoEquipoDesc,
    //                     'INVENTARIO_ID'         => $request->INVENTARIO[$i] ?? null,
    //                     'EN_INVENTARIO'         => $request->EN_INVENTARIO[$i] ?? null,

    //                 ]);
    //             }

    //             DB::commit();
    //             return response()->json([
    //                 'ok'           => true,
    //                 'edit'         => false,
    //                 'no_recepcion' => $noRecepcion,
    //                 'msg'          => "GR creada correctamente",
    //             ]);
    //         }
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'error' => true,
    //             'msg'   => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ], 500);
    //     }
    // }




    // public function consultarGR(Request $request)
    // {
    //     $no_mr = $request->NO_MR;
    //     $no_po = $request->NO_PO;
    //     $proveedor = $request->PROVEEDOR;

    //     $query = DB::table('formulario_bitacoragr as gr')
    //         ->leftJoin('formulario_bitacoragr_detalle as d', 'd.ID_GR', '=', 'gr.ID_GR')
    //         ->select(
    //             'gr.*',
    //             'd.DESCRIPCION',
    //             'd.CANTIDAD',
    //             'd.CANTIDAD_RECHAZADA',
    //             'd.CANTIDAD_ACEPTADA',
    //             'd.PRECIO_UNITARIO',
    //             'd.CUMPLE',
    //             'd.COMENTARIO_CUMPLE',
    //             'd.ESTADO_BS',
    //             'd.COMENTARIO_ESTADO',
    //             'd.COMENTARIO_DIFERENCIA',
    //             'd.PRECIO_TOTAL_MR',
    //             'd.PRECIO_UNITARIO_GR',
    //             'd.PRECIO_TOTAL_GR',
    //             'd.TIPO_BS',
    //             'd.TIPO_EQUIPO',
    //             'd.INVENTARIO_ID',
    //             'd.EN_INVENTARIO',
    //             'd.CANTIDAD_ACEPTADA_USUARIO',
    //             'd.CUMPLE_ESPECIFICADO_USUARIO',
    //             'd.COMENTARIO_CUMPLE_USUARIO',
    //             'd.ESTADO_BS_USUARIO',
    //             'd.COMENTARIO_ESTADO_USUARIO',


    //     )
    //         ->where('gr.NO_MR', $no_mr);

    //     if ($no_po) {
    //         $query->where('gr.NO_PO', $no_po);
    //     } else {
    //         $query->where('gr.PROVEEDOR_KEY', $proveedor);
    //     }

    //     $registros = $query->get();

    //     $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
    //     $inventario = inventarioModel::where('ACTIVO', 1)->get();

    //     if ($registros->isEmpty()) {
    //         return response()->json([
    //             'existe' => false,
    //             'tipoinventario' => $tipoinventario,
    //             'inventario' => $inventario
    //         ]);
    //     }

    //     $cabecera = $registros->first();
    //     $detalle = $registros->map(function ($row) {
    //         return [
    //             'DESCRIPCION' => $row->DESCRIPCION,
    //             'CANTIDAD' => $row->CANTIDAD,
    //             'CANTIDAD_RECHAZADA' => $row->CANTIDAD_RECHAZADA,
    //             'CANTIDAD_ACEPTADA' => $row->CANTIDAD_ACEPTADA,
    //             'PRECIO_UNITARIO' => $row->PRECIO_UNITARIO,
    //             'CUMPLE' => $row->CUMPLE,
    //             'COMENTARIO_CUMPLE' => $row->COMENTARIO_CUMPLE,
    //             'ESTADO_BS' => $row->ESTADO_BS,
    //             'COMENTARIO_ESTADO' => $row->COMENTARIO_ESTADO,
    //             'COMENTARIO_DIFERENCIA' => $row->COMENTARIO_DIFERENCIA,
    //             'TIPO_BS' => $row->TIPO_BS,
    //             'PRECIO_TOTAL_MR' => $row->PRECIO_TOTAL_MR,
    //             'PRECIO_UNITARIO_GR' => $row->PRECIO_UNITARIO_GR,
    //             'PRECIO_TOTAL_GR' => $row->PRECIO_TOTAL_GR,
    //             'TIPO_EQUIPO' => $row->TIPO_EQUIPO,
    //             'INVENTARIO_ID' => $row->INVENTARIO_ID,
    //             'EN_INVENTARIO' => $row->EN_INVENTARIO,
    //             'CANTIDAD_ACEPTADA_USUARIO' => $row->CANTIDAD_ACEPTADA_USUARIO,
    //             'CUMPLE_ESPECIFICADO_USUARIO' => $row->CUMPLE_ESPECIFICADO_USUARIO,
    //             'COMENTARIO_CUMPLE_USUARIO' => $row->COMENTARIO_CUMPLE_USUARIO,
    //             'ESTADO_BS_USUARIO' => $row->ESTADO_BS_USUARIO,
    //             'COMENTARIO_ESTADO_USUARIO' => $row->COMENTARIO_ESTADO_USUARIO,
    //         ];
    //     });

    //     return response()->json([
    //         'existe' => true,
    //         'cabecera' => $cabecera,
    //         'detalle' => $detalle,
    //         'tipoinventario' => $tipoinventario,
    //         'inventario' => $inventario
    //     ]);
    // }




    private function generarNoGR()
    {
        $anio = date('y'); 
        $prefijo = "RES-GR{$anio}-";

        $ultimo = DB::table('formulario_bitacoragr')
            ->where('NO_GR', 'like', $prefijo . '%')
            ->orderBy('NO_GR', 'desc')
            ->value('NO_GR');

        if ($ultimo) {
            $num = (int) substr($ultimo, -3); 
            $nuevo = str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nuevo = "001";
        }

        return $prefijo . $nuevo;
    }


    private function generarNoRecepcion()
    {
        $anio = date('y'); 
        $prefijo = "RES-GR{$anio}-";

        $ultimo = DB::table('formulario_bitacoragr')
            ->where('NO_RECEPCION', 'like', $prefijo . '%')
            ->orderBy('NO_RECEPCION', 'desc')
            ->value('NO_RECEPCION');

        if ($ultimo) {
            $num = (int) substr($ultimo, -3); 
            $nuevo = str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nuevo = "001";
        }

        return $prefijo . $nuevo;
    }

////  PRIMERAS FUNCIONES


    // public function guardarGR(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $usuarioId = DB::table('formulario_requisiconmaterial')
    //             ->where('NO_MR', $request->modal_no_mr)
    //             ->value('USUARIO_ID');

    //         // ========================
    //         // MODO EDITAR
    //         // ========================
    //         if ($request->ID_GR && $request->ID_GR > 0) {
    //             $idGR = $request->ID_GR;

    //             DB::table('formulario_bitacoragr')
    //                 ->where('ID_GR', $idGR)
    //                 ->update([
    //                     'NO_GR'             => null,
    //                     'NO_MR'             => $request->modal_no_mr,
    //                     'NO_PO'             => $request->modal_no_po,
    //                     'PROVEEDOR_KEY'     => $request->PROVEEDOR_EQUIPO,
    //                     'USUARIO_SOLICITO'  => $request->modal_usuario_nombre,
    //                     'USUARIO_ID'        => $usuarioId,
    //                     'FECHA_EMISION'     => $request->DESDE_ACREDITACION,
    //                     'NO_RECEPCION'      => $request->NO_RECEPCION,
    //                     'MANDAR_USUARIO_VOBO' => $request->MANDAR_USUARIO_VOBO,
    //                     'VO_BO_USUARIO'     => $request->VO_BO_USUARIO,
    //                     'FECHA_VOUSUARIO'   => $request->FECHA_VOUSUARIO,
    //                     'GR_PARCIAL'        => $request->GR_PARCIAL,
    //                     'UPDATED_AT'        => now(),
    //                 ]);

    //             DB::table('formulario_bitacoragr_detalle')
    //                 ->where('ID_GR', $idGR)
    //                 ->delete();

    //             foreach ($request->DESCRIPCION as $i => $desc) {
    //                 $tipoEquipoId   = $request->TIPO_INVENTARIO[$i] ?? null;
    //                 $tipoEquipoDesc = null;

    //                 if ($tipoEquipoId) {
    //                     $tipoEquipoDesc = DB::table('catalogo_tipoinventario')
    //                         ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
    //                         ->value('DESCRIPCION_TIPO');
    //                 }

    //                 DB::table('formulario_bitacoragr_detalle')->insert([
    //                     'ID_GR'                     => $idGR,
    //                     'DESCRIPCION'               => $desc,
    //                     'CANTIDAD'                  => $request->CANTIDAD[$i] ?? 0,
    //                     'CANTIDAD_RECHAZADA'        => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
    //                     'CANTIDAD_ACEPTADA'         => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
    //                     'PRECIO_UNITARIO'           => $request->PRECIO_UNITARIO[$i] ?? null,
    //                     'CUMPLE'                    => $request->CUMPLE[$i] ?? null,
    //                     'COMENTARIO_CUMPLE'         => $request->COMENTARIO_CUMPLE[$i] ?? null,
    //                     'ESTADO_BS'                 => $request->ESTADO_BS[$i] ?? null,
    //                     'COMENTARIO_ESTADO'         => $request->COMENTARIO_ESTADO[$i] ?? null,
    //                     'COMENTARIO_DIFERENCIA'     => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
    //                     'PRECIO_TOTAL_MR'           => $request->PRECIO_TOTAL_MR[$i] ?? null,
    //                     'PRECIO_UNITARIO_GR'        => $request->PRECIO_UNITARIO_GR[$i] ?? null,
    //                     'PRECIO_TOTAL_GR'           => $request->PRECIO_TOTAL_GR[$i] ?? null,
    //                     'TIPO_BS'                   => $request->TIPO_BS[$i] ?? null,
    //                     'TIPO_EQUIPO'               => $tipoEquipoDesc,
    //                     'INVENTARIO_ID'             => $request->INVENTARIO[$i] ?? null,
    //                     'EN_INVENTARIO'             => $request->EN_INVENTARIO[$i] ?? null,
    //                     'CANTIDAD_ACEPTADA_USUARIO' => $request->CANTIDAD_ACEPTADA_USUARIO[$i] ?? null,
    //                     'CUMPLE_ESPECIFICADO_USUARIO' => $request->CUMPLE_ESPECIFICADO_USUARIO[$i] ?? null,
    //                     'COMENTARIO_CUMPLE_USUARIO' => $request->COMENTARIO_CUMPLE_USUARIO[$i] ?? null,
    //                     'ESTADO_BS_USUARIO'         => $request->ESTADO_BS_USUARIO[$i] ?? null,
    //                     'COMENTARIO_ESTADO_USUARIO' => $request->COMENTARIO_ESTADO_USUARIO[$i] ?? null,
    //                 ]);
    //             }

    //             // Crear GR Parcial (remanente) si aplica
    //             if ($request->GR_PARCIAL === "Sí") {
    //                 $this->crearGRParcial($request, $usuarioId);
    //             }

    //             DB::commit();
    //             return response()->json([
    //                 'ok'   => true,
    //                 'edit' => true,
    //                 'msg'  => "GR actualizada correctamente",
    //             ]);
    //         }

    //         // ========================
    //         // MODO CREAR
    //         // ========================
    //         $noRecepcion = $this->generarNoRecepcion();

    //         $idGR = DB::table('formulario_bitacoragr')->insertGetId([
    //             'NO_GR'            => null,
    //             'NO_MR'            => $request->modal_no_mr,
    //             'NO_PO'            => $request->modal_no_po,
    //             'PROVEEDOR_KEY'    => $request->PROVEEDOR_EQUIPO,
    //             'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
    //             'USUARIO_ID'       => $usuarioId,
    //             'FECHA_EMISION'    => $request->DESDE_ACREDITACION,
    //             'NO_RECEPCION'     => $noRecepcion,
    //             'MANDAR_USUARIO_VOBO' => $request->MANDAR_USUARIO_VOBO,
    //             'GR_PARCIAL'       => $request->GR_PARCIAL,
    //             'CREATED_AT'       => now(),
    //         ]);

    //         foreach ($request->DESCRIPCION as $i => $desc) {
    //             $tipoEquipoId   = $request->TIPO_INVENTARIO[$i] ?? null;
    //             $tipoEquipoDesc = null;

    //             if ($tipoEquipoId) {
    //                 $tipoEquipoDesc = DB::table('catalogo_tipoinventario')
    //                     ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
    //                     ->value('DESCRIPCION_TIPO');
    //             }

    //             DB::table('formulario_bitacoragr_detalle')->insert([
    //                 'ID_GR'                 => $idGR,
    //                 'DESCRIPCION'           => $desc,
    //                 'CANTIDAD'              => $request->CANTIDAD[$i] ?? 0,
    //                 'CANTIDAD_RECHAZADA'    => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
    //                 'CANTIDAD_ACEPTADA'     => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
    //                 'PRECIO_UNITARIO'       => $request->PRECIO_UNITARIO[$i] ?? null,
    //                 'CUMPLE'                => $request->CUMPLE[$i] ?? null,
    //                 'COMENTARIO_CUMPLE'     => $request->COMENTARIO_CUMPLE[$i] ?? null,
    //                 'ESTADO_BS'             => $request->ESTADO_BS[$i] ?? null,
    //                 'COMENTARIO_ESTADO'     => $request->COMENTARIO_ESTADO[$i] ?? null,
    //                 'COMENTARIO_DIFERENCIA' => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
    //                 'TIPO_BS'               => $request->TIPO_BS[$i] ?? null,
    //                 'PRECIO_TOTAL_MR'       => $request->PRECIO_TOTAL_MR[$i] ?? null,
    //                 'PRECIO_UNITARIO_GR'    => $request->PRECIO_UNITARIO_GR[$i] ?? null,
    //                 'PRECIO_TOTAL_GR'       => $request->PRECIO_TOTAL_GR[$i] ?? null,
    //                 'TIPO_EQUIPO'           => $tipoEquipoDesc,
    //                 'INVENTARIO_ID'         => $request->INVENTARIO[$i] ?? null,
    //                 'EN_INVENTARIO'         => $request->EN_INVENTARIO[$i] ?? null,
    //             ]);
    //         }

    //         // Crear GR Parcial (remanente) si aplica
    //         if ($request->GR_PARCIAL === "Sí") {
    //             $this->crearGRParcial($request, $usuarioId);
    //         }

    //         DB::commit();
    //         return response()->json([
    //             'ok'           => true,
    //             'edit'         => false,
    //             'no_recepcion' => $noRecepcion,
    //             'msg'          => "GR creada correctamente",
    //         ]);
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'error' => true,
    //             'msg'   => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ], 500);
    //     }
    // }

    /**
     * Crear GR Parcial con cantidades remanentes
     */
    // private function crearGRParcial(Request $request, $usuarioId)
    // {
    //     $noRecepcion = $this->generarNoRecepcion();

    //     $idGRParcial = DB::table('formulario_bitacoragr')->insertGetId([
    //         'NO_GR'            => null,
    //         'NO_MR'            => $request->modal_no_mr,
    //         'NO_PO'            => $request->modal_no_po,
    //         'PROVEEDOR_KEY'    => $request->PROVEEDOR_EQUIPO,
    //         'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
    //         'USUARIO_ID'       => $usuarioId,
    //         'FECHA_EMISION'    => now(),
    //         'NO_RECEPCION'     => $noRecepcion,
    //         'MANDAR_USUARIO_VOBO' => $request->MANDAR_USUARIO_VOBO,
    //         'GR_PARCIAL'       => 'Sí',
    //         'CREATED_AT'       => now(),
    //     ]);

    //     foreach ($request->DESCRIPCION as $i => $desc) {
    //         $cantidad  = $request->CANTIDAD[$i] ?? 0;
    //         $aceptada  = $request->CANTIDAD_ACEPTADA[$i] ?? 0;
    //         $restante  = $cantidad - $aceptada;

    //         if ($restante > 0) {
    //             DB::table('formulario_bitacoragr_detalle')->insert([
    //                 'ID_GR'       => $idGRParcial,
    //                 'DESCRIPCION' => $desc,
    //                 'CANTIDAD'    => $restante,
    //                 'PRECIO_UNITARIO' => $request->PRECIO_UNITARIO[$i] ?? null,
    //                 'TIPO_BS'     => $request->TIPO_BS[$i] ?? null,
    //                 'EN_INVENTARIO' => $request->EN_INVENTARIO[$i] ?? null,
    //                 'TIPO_EQUIPO'   => $request->TIPO_INVENTARIO[$i] ?? null,
    //             ]);
    //         }
    //     }
    // }


    // public function consultarGR(Request $request)
    // {
    //     $no_mr     = $request->NO_MR;
    //     $no_po     = $request->NO_PO;
    //     $proveedor = $request->PROVEEDOR;

    //     $query = DB::table('formulario_bitacoragr as gr')
    //         ->leftJoin('formulario_bitacoragr_detalle as d', 'd.ID_GR', '=', 'gr.ID_GR')
    //         ->select(
    //             'gr.*',
    //             'd.DESCRIPCION',
    //             'd.CANTIDAD',
    //             'd.CANTIDAD_RECHAZADA',
    //             'd.CANTIDAD_ACEPTADA',
    //             'd.PRECIO_UNITARIO',
    //             'd.CUMPLE',
    //             'd.COMENTARIO_CUMPLE',
    //             'd.ESTADO_BS',
    //             'd.COMENTARIO_ESTADO',
    //             'd.COMENTARIO_DIFERENCIA',
    //             'd.PRECIO_TOTAL_MR',
    //             'd.PRECIO_UNITARIO_GR',
    //             'd.PRECIO_TOTAL_GR',
    //             'd.TIPO_BS',
    //             'd.TIPO_EQUIPO',
    //             'd.INVENTARIO_ID',
    //             'd.EN_INVENTARIO',
    //             'd.CANTIDAD_ACEPTADA_USUARIO',
    //             'd.CUMPLE_ESPECIFICADO_USUARIO',
    //             'd.COMENTARIO_CUMPLE_USUARIO',
    //             'd.ESTADO_BS_USUARIO',
    //             'd.COMENTARIO_ESTADO_USUARIO'
    //         )
    //         ->where('gr.NO_MR', $no_mr);

    //     if ($no_po) {
    //         $query->where('gr.NO_PO', $no_po);
    //     } else {
    //         $query->where('gr.PROVEEDOR_KEY', $proveedor);
    //     }

    //     $registros = $query->orderBy('gr.ID_GR')->get();

    //     $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
    //     $inventario     = inventarioModel::where('ACTIVO', 1)->get();

    //     if ($registros->isEmpty()) {
    //         return response()->json([
    //             'existe'         => false,
    //             'tipoinventario' => $tipoinventario,
    //             'inventario'     => $inventario
    //         ]);
    //     }

    //     // Agrupar por ID_GR para soportar múltiples GR (parciales)
    //     $grs = $registros->groupBy('ID_GR')->map(function ($rows) {
    //         $cabecera = $rows->first();
    //         $detalle  = $rows->map(function ($row) {
    //             return [
    //                 'DESCRIPCION' => $row->DESCRIPCION,
    //                 'CANTIDAD' => $row->CANTIDAD,
    //                 'CANTIDAD_RECHAZADA' => $row->CANTIDAD_RECHAZADA,
    //                 'CANTIDAD_ACEPTADA' => $row->CANTIDAD_ACEPTADA,
    //                 'PRECIO_UNITARIO' => $row->PRECIO_UNITARIO,
    //                 'CUMPLE' => $row->CUMPLE,
    //                 'COMENTARIO_CUMPLE' => $row->COMENTARIO_CUMPLE,
    //                 'ESTADO_BS' => $row->ESTADO_BS,
    //                 'COMENTARIO_ESTADO' => $row->COMENTARIO_ESTADO,
    //                 'COMENTARIO_DIFERENCIA' => $row->COMENTARIO_DIFERENCIA,
    //                 'TIPO_BS' => $row->TIPO_BS,
    //                 'PRECIO_TOTAL_MR' => $row->PRECIO_TOTAL_MR,
    //                 'PRECIO_UNITARIO_GR' => $row->PRECIO_UNITARIO_GR,
    //                 'PRECIO_TOTAL_GR' => $row->PRECIO_TOTAL_GR,
    //                 'TIPO_EQUIPO' => $row->TIPO_EQUIPO,
    //                 'INVENTARIO_ID' => $row->INVENTARIO_ID,
    //                 'EN_INVENTARIO' => $row->EN_INVENTARIO,
    //                 'CANTIDAD_ACEPTADA_USUARIO' => $row->CANTIDAD_ACEPTADA_USUARIO,
    //                 'CUMPLE_ESPECIFICADO_USUARIO' => $row->CUMPLE_ESPECIFICADO_USUARIO,
    //                 'COMENTARIO_CUMPLE_USUARIO' => $row->COMENTARIO_CUMPLE_USUARIO,
    //                 'ESTADO_BS_USUARIO' => $row->ESTADO_BS_USUARIO,
    //                 'COMENTARIO_ESTADO_USUARIO' => $row->COMENTARIO_ESTADO_USUARIO,
    //             ];
    //         });

    //         return [
    //             'cabecera' => $cabecera,
    //             'detalle'  => $detalle
    //         ];
    //     });

    //     // Si solo hay 1 GR, devolver también la estructura vieja (cabecera/detalle)
    //     if ($grs->count() === 1) {
    //         $unico = $grs->first();
    //         return response()->json([
    //             'existe'         => true,
    //             'cabecera'       => $unico['cabecera'],
    //             'detalle'        => $unico['detalle'],
    //             'grs'            => $grs,
    //             'tipoinventario' => $tipoinventario,
    //             'inventario'     => $inventario
    //         ]);
    //     }

    //     // Si hay varias GR (parciales), solo devolver la estructura múltiple
    //     return response()->json([
    //         'existe'         => true,
    //         'grs'            => $grs,
    //         'tipoinventario' => $tipoinventario,
    //         'inventario'     => $inventario
    //     ]);
    // }



    // public function guardarGR(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $usuarioId = DB::table('formulario_requisiconmaterial')
    //             ->where('NO_MR', $request->modal_no_mr)
    //             ->value('USUARIO_ID');

    //         // ========================
    //         // MODO EDITAR
    //         // ========================
    //         if ($request->ID_GR && $request->ID_GR > 0) {
    //             $idGR = $request->ID_GR;

    //             DB::table('formulario_bitacoragr')
    //                 ->where('ID_GR', $idGR)
    //                 ->update([
    //                     'NO_GR'             => null,
    //                     'NO_MR'             => $request->modal_no_mr,
    //                     'NO_PO'             => $request->modal_no_po,
    //                     'PROVEEDOR_KEY'     => $request->PROVEEDOR_EQUIPO,
    //                     'USUARIO_SOLICITO'  => $request->modal_usuario_nombre,
    //                     'USUARIO_ID'        => $usuarioId,
    //                     'FECHA_EMISION'     => $request->DESDE_ACREDITACION,
    //                     'NO_RECEPCION'      => $request->NO_RECEPCION,
    //                     'MANDAR_USUARIO_VOBO' => $request->MANDAR_USUARIO_VOBO,
    //                     'VO_BO_USUARIO'     => $request->VO_BO_USUARIO,
    //                     'FECHA_VOUSUARIO'   => $request->FECHA_VOUSUARIO,
    //                     'GR_PARCIAL'        => $request->GR_PARCIAL,
    //                     'UPDATED_AT'        => now(),
    //                 ]);

    //             DB::table('formulario_bitacoragr_detalle')
    //                 ->where('ID_GR', $idGR)
    //                 ->delete();

    //             foreach ($request->DESCRIPCION as $i => $desc) {
    //                 $tipoEquipoId   = $request->TIPO_INVENTARIO[$i] ?? null;
    //                 $tipoEquipoDesc = null;

    //                 if ($tipoEquipoId) {
    //                     $tipoEquipoDesc = DB::table('catalogo_tipoinventario')
    //                         ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
    //                         ->value('DESCRIPCION_TIPO');
    //                 }

    //                 DB::table('formulario_bitacoragr_detalle')->insert([
    //                     'ID_GR'                     => $idGR,
    //                     'DESCRIPCION'               => $desc,
    //                     'CANTIDAD'                  => $request->CANTIDAD[$i] ?? 0,
    //                     'CANTIDAD_RECHAZADA'        => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
    //                     'CANTIDAD_ACEPTADA'         => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
    //                     'PRECIO_UNITARIO'           => $request->PRECIO_UNITARIO[$i] ?? null,
    //                     'CUMPLE'                    => $request->CUMPLE[$i] ?? null,
    //                     'COMENTARIO_CUMPLE'         => $request->COMENTARIO_CUMPLE[$i] ?? null,
    //                     'ESTADO_BS'                 => $request->ESTADO_BS[$i] ?? null,
    //                     'COMENTARIO_ESTADO'         => $request->COMENTARIO_ESTADO[$i] ?? null,
    //                     'COMENTARIO_DIFERENCIA'     => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
    //                     'PRECIO_TOTAL_MR'           => $request->PRECIO_TOTAL_MR[$i] ?? null,
    //                     'PRECIO_UNITARIO_GR'        => $request->PRECIO_UNITARIO_GR[$i] ?? null,
    //                     'PRECIO_TOTAL_GR'           => $request->PRECIO_TOTAL_GR[$i] ?? null,
    //                     'TIPO_BS'                   => $request->TIPO_BS[$i] ?? null,
    //                     'TIPO_EQUIPO'               => $tipoEquipoDesc,
    //                     'INVENTARIO_ID'             => $request->INVENTARIO[$i] ?? null,
    //                     'EN_INVENTARIO'             => $request->EN_INVENTARIO[$i] ?? null,
    //                     'CANTIDAD_ACEPTADA_USUARIO' => $request->CANTIDAD_ACEPTADA_USUARIO[$i] ?? null,
    //                     'CUMPLE_ESPECIFICADO_USUARIO' => $request->CUMPLE_ESPECIFICADO_USUARIO[$i] ?? null,
    //                     'COMENTARIO_CUMPLE_USUARIO' => $request->COMENTARIO_CUMPLE_USUARIO[$i] ?? null,
    //                     'ESTADO_BS_USUARIO'         => $request->ESTADO_BS_USUARIO[$i] ?? null,
    //                     'COMENTARIO_ESTADO_USUARIO' => $request->COMENTARIO_ESTADO_USUARIO[$i] ?? null,
    //                 ]);
    //             }

    //             // Crear GR Parcial (remanente) si aplica
    //             if ($request->GR_PARCIAL === "Sí") {
    //                 $this->crearGRParcial($request, $usuarioId);
    //             }

    //             DB::commit();
    //             return response()->json([
    //                 'ok'   => true,
    //                 'edit' => true,
    //                 'msg'  => "GR actualizada correctamente",
    //             ]);
    //         }

    //         // ========================
    //         // MODO CREAR
    //         // ========================
    //         $noRecepcion = $this->generarNoRecepcion();

    //         $idGR = DB::table('formulario_bitacoragr')->insertGetId([
    //             'NO_GR'            => null,
    //             'NO_MR'            => $request->modal_no_mr,
    //             'NO_PO'            => $request->modal_no_po,
    //             'PROVEEDOR_KEY'    => $request->PROVEEDOR_EQUIPO,
    //             'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
    //             'USUARIO_ID'       => $usuarioId,
    //             'FECHA_EMISION'    => $request->DESDE_ACREDITACION,
    //             'NO_RECEPCION'     => $noRecepcion,
    //             'MANDAR_USUARIO_VOBO' => $request->MANDAR_USUARIO_VOBO,
    //             'GR_PARCIAL'       => $request->GR_PARCIAL,
    //             'CREATED_AT'       => now(),
    //         ]);

    //         foreach ($request->DESCRIPCION as $i => $desc) {
    //             $tipoEquipoId   = $request->TIPO_INVENTARIO[$i] ?? null;
    //             $tipoEquipoDesc = null;

    //             if ($tipoEquipoId) {
    //                 $tipoEquipoDesc = DB::table('catalogo_tipoinventario')
    //                     ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
    //                     ->value('DESCRIPCION_TIPO');
    //             }

    //             DB::table('formulario_bitacoragr_detalle')->insert([
    //                 'ID_GR'                 => $idGR,
    //                 'DESCRIPCION'           => $desc,
    //                 'CANTIDAD'              => $request->CANTIDAD[$i] ?? 0,
    //                 'CANTIDAD_RECHAZADA'    => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
    //                 'CANTIDAD_ACEPTADA'     => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
    //                 'PRECIO_UNITARIO'       => $request->PRECIO_UNITARIO[$i] ?? null,
    //                 'CUMPLE'                => $request->CUMPLE[$i] ?? null,
    //                 'COMENTARIO_CUMPLE'     => $request->COMENTARIO_CUMPLE[$i] ?? null,
    //                 'ESTADO_BS'             => $request->ESTADO_BS[$i] ?? null,
    //                 'COMENTARIO_ESTADO'     => $request->COMENTARIO_ESTADO[$i] ?? null,
    //                 'COMENTARIO_DIFERENCIA' => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
    //                 'TIPO_BS'               => $request->TIPO_BS[$i] ?? null,
    //                 'PRECIO_TOTAL_MR'       => $request->PRECIO_TOTAL_MR[$i] ?? null,
    //                 'PRECIO_UNITARIO_GR'    => $request->PRECIO_UNITARIO_GR[$i] ?? null,
    //                 'PRECIO_TOTAL_GR'       => $request->PRECIO_TOTAL_GR[$i] ?? null,
    //                 'TIPO_EQUIPO'           => $tipoEquipoDesc,
    //                 'INVENTARIO_ID'         => $request->INVENTARIO[$i] ?? null,
    //                 'EN_INVENTARIO'         => $request->EN_INVENTARIO[$i] ?? null,
    //             ]);
    //         }

    //         // Crear GR Parcial (remanente) si aplica
    //         if ($request->GR_PARCIAL === "Sí") {
    //             $this->crearGRParcial($request, $usuarioId);
    //         }

    //         DB::commit();
    //         return response()->json([
    //             'ok'           => true,
    //             'edit'         => false,
    //             'no_recepcion' => $noRecepcion,
    //             'msg'          => "GR creada correctamente",
    //         ]);
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'error' => true,
    //             'msg'   => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ], 500);
    //     }
    // }









    // public function guardarGR(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $grs = $request->input('grs', []);

    //         foreach ($grs as $form) {
    //             // Convertir serializeArray (name,value) → key=>value
    //             $data = collect($form)->pluck('value', 'name');

    //             // 🔹 Normalizar campos que deben ser arrays (por si solo traen 1 valor string)
    //             $camposArray = [
    //                 'DESCRIPCION',
    //                 'EN_INVENTARIO',
    //                 'TIPO_INVENTARIO',
    //                 'INVENTARIO',
    //                 'CANTIDAD',
    //                 'PRECIO_UNITARIO',
    //                 'PRECIO_TOTAL_MR',
    //                 'CANTIDAD_RECHAZADA',
    //                 'CANTIDAD_ACEPTADA',
    //                 'PRECIO_UNITARIO_GR',
    //                 'PRECIO_TOTAL_GR',
    //                 'COMENTARIO_DIFERENCIA',
    //                 'CUMPLE',
    //                 'COMENTARIO_CUMPLE',
    //                 'ESTADO_BS',
    //                 'COMENTARIO_ESTADO',
    //                 'CANTIDAD_ACEPTADA_USUARIO',
    //                 'CUMPLE_ESPECIFICADO_USUARIO',
    //                 'COMENTARIO_CUMPLE_USUARIO',
    //                 'ESTADO_BS_USUARIO',
    //                 'COMENTARIO_ESTADO_USUARIO',
    //                 'TIPO_BS'
    //             ];

    //             foreach ($camposArray as $campo) {
    //                 if (!isset($data[$campo])) {
    //                     $data[$campo] = [];
    //                 } elseif (!is_array($data[$campo])) {
    //                     $data[$campo] = [$data[$campo]];
    //                 }
    //             }

    //             $usuarioId = DB::table('formulario_requisiconmaterial')
    //                 ->where('NO_MR', $data['modal_no_mr'])
    //                 ->value('USUARIO_ID');

    //             $idGR = $data['ID_GR'] ?? null;

    //             if ($idGR && $idGR > 0) {
    //                 // ========================
    //                 // EDITAR
    //                 // ========================
    //                 DB::table('formulario_bitacoragr')
    //                     ->where('ID_GR', $idGR)
    //                     ->update([
    //                         'NO_GR'               => null,
    //                         'NO_MR'               => $data['modal_no_mr'],
    //                         'NO_PO'               => $data['modal_no_po'],
    //                         'PROVEEDOR_KEY'       => $data['PROVEEDOR_EQUIPO'],
    //                         'USUARIO_SOLICITO'    => $data['modal_usuario_nombre'],
    //                         'USUARIO_ID'          => $usuarioId,
    //                         'FECHA_EMISION'       => $data['DESDE_ACREDITACION'],
    //                         'NO_RECEPCION'        => $data['NO_RECEPCION'],
    //                         'MANDAR_USUARIO_VOBO' => $data['MANDAR_USUARIO_VOBO'],
    //                         'VO_BO_USUARIO'       => $data['VO_BO_USUARIO'],
    //                         'FECHA_VOUSUARIO'     => $data['FECHA_VOUSUARIO'],
    //                         'GR_PARCIAL'          => $data['GR_PARCIAL'],
    //                         'UPDATED_AT'          => now(),
    //                     ]);

    //                 DB::table('formulario_bitacoragr_detalle')
    //                     ->where('ID_GR', $idGR)
    //                     ->delete();

    //                 foreach ($data['DESCRIPCION'] as $i => $desc) {
    //                     $tipoEquipoId   = $data['TIPO_INVENTARIO'][$i] ?? null;
    //                     $tipoEquipoDesc = null;

    //                     if ($tipoEquipoId) {
    //                         $tipoEquipoDesc = DB::table('catalogo_tipoinventario')
    //                             ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
    //                             ->value('DESCRIPCION_TIPO');
    //                     }

    //                     DB::table('formulario_bitacoragr_detalle')->insert([
    //                         'ID_GR'                     => $idGR,
    //                         'DESCRIPCION'               => $desc,
    //                         'CANTIDAD'                  => $data['CANTIDAD'][$i] ?? 0,
    //                         'CANTIDAD_RECHAZADA'        => $data['CANTIDAD_RECHAZADA'][$i] ?? 0,
    //                         'CANTIDAD_ACEPTADA'         => $data['CANTIDAD_ACEPTADA'][$i] ?? 0,
    //                         'PRECIO_UNITARIO'           => $data['PRECIO_UNITARIO'][$i] ?? null,
    //                         'CUMPLE'                    => $data['CUMPLE'][$i] ?? null,
    //                         'COMENTARIO_CUMPLE'         => $data['COMENTARIO_CUMPLE'][$i] ?? null,
    //                         'ESTADO_BS'                 => $data['ESTADO_BS'][$i] ?? null,
    //                         'COMENTARIO_ESTADO'         => $data['COMENTARIO_ESTADO'][$i] ?? null,
    //                         'COMENTARIO_DIFERENCIA'     => $data['COMENTARIO_DIFERENCIA'][$i] ?? null,
    //                         'PRECIO_TOTAL_MR'           => $data['PRECIO_TOTAL_MR'][$i] ?? null,
    //                         'PRECIO_UNITARIO_GR'        => $data['PRECIO_UNITARIO_GR'][$i] ?? null,
    //                         'PRECIO_TOTAL_GR'           => $data['PRECIO_TOTAL_GR'][$i] ?? null,
    //                         'TIPO_BS'                   => $data['TIPO_BS'][$i] ?? null,
    //                         'TIPO_EQUIPO'               => $tipoEquipoDesc,
    //                         'INVENTARIO_ID'             => $data['INVENTARIO'][$i] ?? null,
    //                         'EN_INVENTARIO'             => $data['EN_INVENTARIO'][$i] ?? null,
    //                         'CANTIDAD_ACEPTADA_USUARIO' => $data['CANTIDAD_ACEPTADA_USUARIO'][$i] ?? null,
    //                         'CUMPLE_ESPECIFICADO_USUARIO' => $data['CUMPLE_ESPECIFICADO_USUARIO'][$i] ?? null,
    //                         'COMENTARIO_CUMPLE_USUARIO' => $data['COMENTARIO_CUMPLE_USUARIO'][$i] ?? null,
    //                         'ESTADO_BS_USUARIO'         => $data['ESTADO_BS_USUARIO'][$i] ?? null,
    //                         'COMENTARIO_ESTADO_USUARIO' => $data['COMENTARIO_ESTADO_USUARIO'][$i] ?? null,
    //                     ]);
    //                 }

    //                 if ($data['GR_PARCIAL'] === "Sí") {
    //                     $this->crearGRParcial(new Request($data->toArray()), $usuarioId);
    //                 }
    //             } else {
    //                 // ========================
    //                 // CREAR
    //                 // ========================
    //                 $noRecepcion = $this->generarNoRecepcion();

    //                 $idGRNuevo = DB::table('formulario_bitacoragr')->insertGetId([
    //                     'NO_GR'            => null,
    //                     'NO_MR'            => $data['modal_no_mr'],
    //                     'NO_PO'            => $data['modal_no_po'],
    //                     'PROVEEDOR_KEY'    => $data['PROVEEDOR_EQUIPO'],
    //                     'USUARIO_SOLICITO' => $data['modal_usuario_nombre'],
    //                     'USUARIO_ID'       => $usuarioId,
    //                     'FECHA_EMISION'    => $data['DESDE_ACREDITACION'],
    //                     'NO_RECEPCION'     => $noRecepcion,
    //                     'MANDAR_USUARIO_VOBO' => $data['MANDAR_USUARIO_VOBO'],
    //                     'GR_PARCIAL'       => $data['GR_PARCIAL'],
    //                     'CREATED_AT'       => now(),
    //                 ]);

    //                 foreach ($data['DESCRIPCION'] as $i => $desc) {
    //                     $tipoEquipoId   = $data['TIPO_INVENTARIO'][$i] ?? null;
    //                     $tipoEquipoDesc = null;

    //                     if ($tipoEquipoId) {
    //                         $tipoEquipoDesc = DB::table('catalogo_tipoinventario')
    //                             ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
    //                             ->value('DESCRIPCION_TIPO');
    //                     }

    //                     DB::table('formulario_bitacoragr_detalle')->insert([
    //                         'ID_GR'                 => $idGRNuevo,
    //                         'DESCRIPCION'           => $desc,
    //                         'CANTIDAD'              => $data['CANTIDAD'][$i] ?? 0,
    //                         'CANTIDAD_RECHAZADA'    => $data['CANTIDAD_RECHAZADA'][$i] ?? 0,
    //                         'CANTIDAD_ACEPTADA'     => $data['CANTIDAD_ACEPTADA'][$i] ?? 0,
    //                         'PRECIO_UNITARIO'       => $data['PRECIO_UNITARIO'][$i] ?? null,
    //                         'CUMPLE'                => $data['CUMPLE'][$i] ?? null,
    //                         'COMENTARIO_CUMPLE'     => $data['COMENTARIO_CUMPLE'][$i] ?? null,
    //                         'ESTADO_BS'             => $data['ESTADO_BS'][$i] ?? null,
    //                         'COMENTARIO_ESTADO'     => $data['COMENTARIO_ESTADO'][$i] ?? null,
    //                         'COMENTARIO_DIFERENCIA' => $data['COMENTARIO_DIFERENCIA'][$i] ?? null,
    //                         'TIPO_BS'               => $data['TIPO_BS'][$i] ?? null,
    //                         'PRECIO_TOTAL_MR'       => $data['PRECIO_TOTAL_MR'][$i] ?? null,
    //                         'PRECIO_UNITARIO_GR'    => $data['PRECIO_UNITARIO_GR'][$i] ?? null,
    //                         'PRECIO_TOTAL_GR'       => $data['PRECIO_TOTAL_GR'][$i] ?? null,
    //                         'TIPO_EQUIPO'           => $tipoEquipoDesc,
    //                         'INVENTARIO_ID'         => $data['INVENTARIO'][$i] ?? null,
    //                         'EN_INVENTARIO'         => $data['EN_INVENTARIO'][$i] ?? null,
    //                     ]);
    //                 }

    //                 if ($data['GR_PARCIAL'] === "Sí") {
    //                     $this->crearGRParcial(new Request($data->toArray()), $usuarioId);
    //                 }
    //             }
    //         }

    //         DB::commit();
    //         return response()->json([
    //             'ok'  => true,
    //             'msg' => "GR(s) procesada(s) correctamente",
    //         ]);
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'error' => true,
    //             'msg'   => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ], 500);
    //     }
    // }





    public function guardarGR(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuarioId = DB::table('formulario_requisiconmaterial')
                ->where('NO_MR', $request->modal_no_mr)
                ->value('USUARIO_ID');

            $idsGR = is_array($request->ID_GR) ? $request->ID_GR : [$request->ID_GR];

            foreach ($idsGR as $idGR) {

                if ($idGR && $idGR > 0) {
                    // ======================== EDITAR ========================
                    DB::table('formulario_bitacoragr')
                        ->where('ID_GR', $idGR)
                        ->update([
                            'NO_GR'               => null,
                            'NO_MR'               => $request->modal_no_mr,
                            'NO_PO'               => $request->modal_no_po,
                            'PROVEEDOR_KEY'       => $request->PROVEEDOR_EQUIPO,
                            'USUARIO_SOLICITO'    => $request->modal_usuario_nombre,
                            'USUARIO_ID'          => $usuarioId,
                            'FECHA_EMISION'       => $request->DESDE_ACREDITACION,
                            'NO_RECEPCION'        => $request->NO_RECEPCION,
                            'MANDAR_USUARIO_VOBO' => $request->MANDAR_USUARIO_VOBO,
                            'VO_BO_USUARIO'       => $request->VO_BO_USUARIO,
                            'FECHA_VOUSUARIO'     => $request->FECHA_VOUSUARIO,
                            'GR_PARCIAL'          => $request->GR_PARCIAL,
                            'FECHA_ENTREGA_GR'          => $request->FECHA_ENTREGA_GR,

                        'UPDATED_AT'          => now(),
                        ]);

                    DB::table('formulario_bitacoragr_detalle')
                        ->where('ID_GR', $idGR)
                        ->delete();

                    foreach ($request->DESCRIPCION as $i => $desc) {
                        $tipoEquipoId   = $request->TIPO_INVENTARIO[$i] ?? null;
                        $tipoEquipoDesc = $tipoEquipoId
                            ? DB::table('catalogo_tipoinventario')
                            ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
                            ->value('DESCRIPCION_TIPO')
                            : null;

                        DB::table('formulario_bitacoragr_detalle')->insert([
                            'ID_GR'                     => $idGR,
                            'DESCRIPCION'               => $desc,
                            'CANTIDAD'                  => $request->CANTIDAD[$i] ?? 0,
                            'CANTIDAD_RECHAZADA'        => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
                            'CANTIDAD_ACEPTADA'         => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
                            'PRECIO_UNITARIO'           => $request->PRECIO_UNITARIO[$i] ?? null,
                            'CUMPLE'                    => $request->CUMPLE[$i] ?? null,
                            'COMENTARIO_CUMPLE'         => $request->COMENTARIO_CUMPLE[$i] ?? null,
                            'ESTADO_BS'                 => $request->ESTADO_BS[$i] ?? null,
                            'COMENTARIO_ESTADO'         => $request->COMENTARIO_ESTADO[$i] ?? null,
                            'COMENTARIO_DIFERENCIA'     => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
                            'PRECIO_TOTAL_MR'           => $request->PRECIO_TOTAL_MR[$i] ?? null,
                            'PRECIO_UNITARIO_GR'        => $request->PRECIO_UNITARIO_GR[$i] ?? null,
                            'PRECIO_TOTAL_GR'           => $request->PRECIO_TOTAL_GR[$i] ?? null,
                            'TIPO_BS'                   => $request->TIPO_BS[$i] ?? null,
                            'TIPO_EQUIPO'               => $tipoEquipoDesc,
                            'INVENTARIO_ID'             => $request->INVENTARIO[$i] ?? null,
                            'EN_INVENTARIO'             => $request->EN_INVENTARIO[$i] ?? null,
                            'CANTIDAD_ACEPTADA_USUARIO' => $request->CANTIDAD_ACEPTADA_USUARIO[$i] ?? null,
                            'CUMPLE_ESPECIFICADO_USUARIO' => $request->CUMPLE_ESPECIFICADO_USUARIO[$i] ?? null,
                            'COMENTARIO_CUMPLE_USUARIO' => $request->COMENTARIO_CUMPLE_USUARIO[$i] ?? null,
                            'ESTADO_BS_USUARIO'         => $request->ESTADO_BS_USUARIO[$i] ?? null,
                            'COMENTARIO_ESTADO_USUARIO' => $request->COMENTARIO_ESTADO_USUARIO[$i] ?? null,
                        ]);
                    }

                    // 🔹 Crear parcial solo si aún no tiene uno
                    if ($request->GR_PARCIAL === "Sí") {
                        $yaTieneParcial = DB::table('formulario_bitacoragr')
                            ->where('ID_GR', $idGR)
                            ->value('TIENE_PARCIAL');

                        if (!$yaTieneParcial) {
                            $this->crearGRParcial($request, $usuarioId);

                            DB::table('formulario_bitacoragr')
                                ->where('ID_GR', $idGR)
                                ->update(['TIENE_PARCIAL' => 1]);
                        }
                    }
                

                } else {
                    // ======================== CREAR ========================
                    $noRecepcion = $this->generarNoRecepcion();

                    $idGRNuevo = DB::table('formulario_bitacoragr')->insertGetId([
                        'NO_GR'            => null,
                        'NO_MR'            => $request->modal_no_mr,
                        'NO_PO'            => $request->modal_no_po,
                        'PROVEEDOR_KEY'    => $request->PROVEEDOR_EQUIPO,
                        'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
                        'USUARIO_ID'       => $usuarioId,
                        'FECHA_EMISION'    => $request->DESDE_ACREDITACION,
                        'NO_RECEPCION'     => $noRecepcion,
                        'MANDAR_USUARIO_VOBO' => $request->MANDAR_USUARIO_VOBO,
                        'GR_PARCIAL'       => $request->GR_PARCIAL,
                        'FECHA_ENTREGA_GR'       => $request->FECHA_ENTREGA_GR,

                        'CREATED_AT'       => now(),
                    ]);

                    foreach ($request->DESCRIPCION as $i => $desc) {
                        $tipoEquipoId   = $request->TIPO_INVENTARIO[$i] ?? null;
                        $tipoEquipoDesc = $tipoEquipoId
                            ? DB::table('catalogo_tipoinventario')
                            ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
                            ->value('DESCRIPCION_TIPO')
                            : null;

                        DB::table('formulario_bitacoragr_detalle')->insert([
                            'ID_GR'                 => $idGRNuevo,
                            'DESCRIPCION'           => $desc,
                            'CANTIDAD'              => $request->CANTIDAD[$i] ?? 0,
                            'CANTIDAD_RECHAZADA'    => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
                            'CANTIDAD_ACEPTADA'     => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
                            'PRECIO_UNITARIO'       => $request->PRECIO_UNITARIO[$i] ?? null,
                            'CUMPLE'                => $request->CUMPLE[$i] ?? null,
                            'COMENTARIO_CUMPLE'     => $request->COMENTARIO_CUMPLE[$i] ?? null,
                            'ESTADO_BS'             => $request->ESTADO_BS[$i] ?? null,
                            'COMENTARIO_ESTADO'     => $request->COMENTARIO_ESTADO[$i] ?? null,
                            'COMENTARIO_DIFERENCIA' => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
                            'TIPO_BS'               => $request->TIPO_BS[$i] ?? null,
                            'PRECIO_TOTAL_MR'       => $request->PRECIO_TOTAL_MR[$i] ?? null,
                            'PRECIO_UNITARIO_GR'    => $request->PRECIO_UNITARIO_GR[$i] ?? null,
                            'PRECIO_TOTAL_GR'       => $request->PRECIO_TOTAL_GR[$i] ?? null,
                            'TIPO_EQUIPO'           => $tipoEquipoDesc,
                            'INVENTARIO_ID'         => $request->INVENTARIO[$i] ?? null,
                            'EN_INVENTARIO'         => $request->EN_INVENTARIO[$i] ?? null,
                        ]);
                    }

                    if ($request->GR_PARCIAL === "Sí") {
                        $this->crearGRParcial($request, $usuarioId);
                    }

                }
            }

            DB::commit();
            return response()->json([
                'ok'  => true,
                'msg' => "GR procesada correctamente",
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'msg'   => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }




    /**
     * Crear GR Parcial con cantidades remanentes
     */
    private function crearGRParcial(Request $request, $usuarioId)
    {
        $noRecepcion = $this->generarNoRecepcion();

        $idGRParcial = DB::table('formulario_bitacoragr')->insertGetId([
            'NO_GR'              => null,
            'NO_MR'              => $request->modal_no_mr,
            'NO_PO'              => $request->modal_no_po,
            'PROVEEDOR_KEY'      => $request->PROVEEDOR_EQUIPO,
            'USUARIO_SOLICITO'   => $request->modal_usuario_nombre,
            'USUARIO_ID'         => $usuarioId,
            'NO_RECEPCION'       => $noRecepcion,
            'CREATED_AT'         => now(),
        ]);

        foreach ($request->DESCRIPCION as $i => $desc) {
            $aceptada = $request->CANTIDAD_ACEPTADA[$i] ?? 0;

            if ($aceptada > 0) {
                $tipoEquipoId   = $request->TIPO_INVENTARIO[$i] ?? null;
                $tipoEquipoDesc = null;

                if ($tipoEquipoId) {
                    $tipoEquipoDesc = DB::table('catalogo_tipoinventario')
                        ->where('ID_CATALOGO_TIPOINVENTARIO', $tipoEquipoId)
                        ->value('DESCRIPCION_TIPO');
                }

                DB::table('formulario_bitacoragr_detalle')->insert([
                    'ID_GR'                 => $idGRParcial,
                    'DESCRIPCION'           => $desc,
                    'CANTIDAD'              => $aceptada, 
                    'CANTIDAD_RECHAZADA'    => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
                    'PRECIO_UNITARIO'       => $request->PRECIO_UNITARIO[$i] ?? null,
                    'PRECIO_TOTAL_MR'       => $request->PRECIO_TOTAL_MR[$i] ?? null,
                    'TIPO_BS'               => $request->TIPO_BS[$i] ?? null,
                    'TIPO_EQUIPO'           => $tipoEquipoDesc,
                    'INVENTARIO_ID'         => $request->INVENTARIO[$i] ?? null,
                    'EN_INVENTARIO'         => $request->EN_INVENTARIO[$i] ?? null,
                ]);
            }
        }
    }

    public function consultarGR(Request $request)
    {
        $no_mr     = $request->NO_MR;
        $no_po     = $request->NO_PO;
        $proveedor = $request->PROVEEDOR;

        $query = DB::table('formulario_bitacoragr as gr')
            ->leftJoin('formulario_bitacoragr_detalle as d', 'd.ID_GR', '=', 'gr.ID_GR')
            ->select(
                'gr.*',
                'd.DESCRIPCION',
                'd.CANTIDAD',
                'd.CANTIDAD_RECHAZADA',
                'd.CANTIDAD_ACEPTADA',
                'd.PRECIO_UNITARIO',
                'd.CUMPLE',
                'd.COMENTARIO_CUMPLE',
                'd.ESTADO_BS',
                'd.COMENTARIO_ESTADO',
                'd.COMENTARIO_DIFERENCIA',
                'd.PRECIO_TOTAL_MR',
                'd.PRECIO_UNITARIO_GR',
                'd.PRECIO_TOTAL_GR',
                'd.TIPO_BS',
                'd.TIPO_EQUIPO',
                'd.INVENTARIO_ID',
                'd.EN_INVENTARIO',
                'd.CANTIDAD_ACEPTADA_USUARIO',
                'd.CUMPLE_ESPECIFICADO_USUARIO',
                'd.COMENTARIO_CUMPLE_USUARIO',
                'd.ESTADO_BS_USUARIO',
                'd.COMENTARIO_ESTADO_USUARIO'
            )
            ->where('gr.NO_MR', $no_mr);

        if ($no_po) {
            $query->where('gr.NO_PO', $no_po);
        } else {
            $query->where('gr.PROVEEDOR_KEY', $proveedor);
        }

        $registros = $query->orderBy('gr.ID_GR')->get();

        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $inventario     = inventarioModel::where('ACTIVO', 1)->get();

        if ($registros->isEmpty()) {
            return response()->json([
                'existe'         => false,
                'tipoinventario' => $tipoinventario,
                'inventario'     => $inventario
            ]);
        }

        // Agrupar por ID_GR
        $grs = $registros->groupBy('ID_GR')->map(function ($rows) {
            $cabecera = $rows->first();
            $detalle  = $rows->map(function ($row) {
                return [
                    'DESCRIPCION' => $row->DESCRIPCION,
                    'CANTIDAD' => $row->CANTIDAD,
                    'CANTIDAD_RECHAZADA' => $row->CANTIDAD_RECHAZADA,
                    'CANTIDAD_ACEPTADA' => $row->CANTIDAD_ACEPTADA,
                    'PRECIO_UNITARIO' => $row->PRECIO_UNITARIO,
                    'CUMPLE' => $row->CUMPLE,
                    'COMENTARIO_CUMPLE' => $row->COMENTARIO_CUMPLE,
                    'ESTADO_BS' => $row->ESTADO_BS,
                    'COMENTARIO_ESTADO' => $row->COMENTARIO_ESTADO,
                    'COMENTARIO_DIFERENCIA' => $row->COMENTARIO_DIFERENCIA,
                    'TIPO_BS' => $row->TIPO_BS,
                    'PRECIO_TOTAL_MR' => $row->PRECIO_TOTAL_MR,
                    'PRECIO_UNITARIO_GR' => $row->PRECIO_UNITARIO_GR,
                    'PRECIO_TOTAL_GR' => $row->PRECIO_TOTAL_GR,
                    'TIPO_EQUIPO' => $row->TIPO_EQUIPO,
                    'INVENTARIO_ID' => $row->INVENTARIO_ID,
                    'EN_INVENTARIO' => $row->EN_INVENTARIO,
                    'CANTIDAD_ACEPTADA_USUARIO' => $row->CANTIDAD_ACEPTADA_USUARIO,
                    'CUMPLE_ESPECIFICADO_USUARIO' => $row->CUMPLE_ESPECIFICADO_USUARIO,
                    'COMENTARIO_CUMPLE_USUARIO' => $row->COMENTARIO_CUMPLE_USUARIO,
                    'ESTADO_BS_USUARIO' => $row->ESTADO_BS_USUARIO,
                    'COMENTARIO_ESTADO_USUARIO' => $row->COMENTARIO_ESTADO_USUARIO,
                ];
            });

            return [
                'cabecera' => $cabecera,
                'detalle'  => $detalle
            ];
        });

        // Si solo hay 1 GR → compatibilidad vieja
        if ($grs->count() === 1) {
            $unico = $grs->first();
            return response()->json([
                'existe'         => true,
                'cabecera'       => $unico['cabecera'],
                'detalle'        => $unico['detalle'],
                'grs'            => $grs,
                'tipoinventario' => $tipoinventario,
                'inventario'     => $inventario
            ]);
        }

        // Varias GR → múltiples tabs
        return response()->json([
            'existe'         => true,
            'grs'            => $grs,
            'tipoinventario' => $tipoinventario,
            'inventario'     => $inventario
        ]);
    }
}