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



class grController extends Controller
{


    // public function Tablabitacoragr()
    // {
    //     try {
    //         $poUltimo = DB::table('formulario_ordencompra as po')
    //             ->select(
    //                 'po.ID_FORMULARIO_PO',
    //                 'po.NO_PO',
    //                 'po.HOJA_ID',
    //                 'po.FECHA_APROBACION',
    //                 'po.FECHA_ENTREGA',
    //                 'po.PROVEEDOR_SELECCIONADO',
    //                 'po.MATERIALES_JSON'
    //             )
    //             ->join(
    //                 DB::raw('(
    //             SELECT 
    //                 REPLACE(SUBSTRING_INDEX(NO_PO, "-Rev", 1), " ", "") AS PO_BASE,
    //                 MAX(FECHA_APROBACION) AS max_fecha
    //             FROM formulario_ordencompra
    //             GROUP BY PO_BASE
    //         ) AS ult'),
    //                 function ($join) {
    //                     $join->on(
    //                         DB::raw('REPLACE(SUBSTRING_INDEX(po.NO_PO, "-Rev", 1), " ", "")'),
    //                         '=',
    //                         'ult.PO_BASE'
    //                     )
    //                         ->on('po.FECHA_APROBACION', '=', 'ult.max_fecha');
    //                 }
    //             );

    //         $rows = DB::table('hoja_trabajo as ht')
    //             ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
    //             ->leftJoinSub($poUltimo, 'po', function ($join) {
    //                 $join->whereRaw("
    //                 FIND_IN_SET(
    //                     CAST(ht.id AS CHAR),
    //                     REPLACE(REPLACE(REPLACE(REPLACE(po.HOJA_ID, '[', ''), ']', ''), '\"', ''), ' ', '')
    //                 )
    //             ");
    //             })
    //             ->leftJoin('formulario_altaproveedor as prov', function ($join) {
    //                 $join->on('prov.RFC_ALTA', '=', 'po.PROVEEDOR_SELECCIONADO');
    //             })
    //             ->select([
    //                 DB::raw('COALESCE(po.NO_PO, CONCAT("HT-", ht.id)) as AGRUPADOR'),
    //                 'mr.NO_MR',
    //                 'mr.FECHA_APRUEBA_MR',
    //                 'po.NO_PO',
    //                 'po.FECHA_APROBACION as FECHA_APROBACION_PO',
    //                 'po.FECHA_ENTREGA as FECHA_ENTREGA_PO',
    //                 DB::raw("IF(po.NO_PO IS NOT NULL, CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')'), NULL) as PROVEEDOR"),
    //                 'po.MATERIALES_JSON'
    //             ])
    //             ->groupBy(
    //                 'AGRUPADOR',
    //                 'mr.NO_MR',
    //                 'mr.FECHA_APRUEBA_MR',
    //                 'po.NO_PO',
    //                 'po.FECHA_APROBACION',
    //                 'po.FECHA_ENTREGA',
    //                 'prov.RAZON_SOCIAL_ALTA',
    //                 'prov.RFC_ALTA',
    //                 'po.MATERIALES_JSON'
    //             )
    //             ->orderBy('mr.NO_MR', 'desc')
    //             ->get()
    //             ->map(function ($row) {
    //                 $bienes = '';
    //                 if (!empty($row->MATERIALES_JSON)) {
    //                     $materiales = json_decode($row->MATERIALES_JSON, true);
    //                     if (is_array($materiales)) {
    //                         $total = count($materiales);
    //                         foreach ($materiales as $index => $mat) {
    //                             if ($index < 3) {
    //                                 $bienes .= "<div>• {$mat['DESCRIPCION']} ({$mat['CANTIDAD_']})</div>";
    //                             }
    //                         }
    //                         if ($total > 3) {
    //                             $extra = '';
    //                             for ($i = 3; $i < $total; $i++) {
    //                                 $extra .= "<div>• {$materiales[$i]['DESCRIPCION']} ({$materiales[$i]['CANTIDAD_']})</div>";
    //                             }
    //                             $bienes .= "<div class='extra-materiales' style='display:none;'>{$extra}</div>";
    //                             $bienes .= "<button class='btn-ver-mas-materiales btn btn-sm btn-primary'>Ver más</button>";
    //                         }
    //                     }
    //                 }
    //                 $row->BIEN_SERVICIO = $bienes ?: '-';
    //                 unset($row->MATERIALES_JSON);
    //                 return $row;
    //             });

    //         return response()->json(['data' => $rows]);
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'data' => [],
    //             'error' => true,
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }






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
                    'po.MATERIALES_JSON'
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

            // CONSULTA ORIGINAL PARA CASOS CON PO (MANTIENE LA AGRUPACIÓN)
            $rowsConPO = DB::table('hoja_trabajo as ht')
                ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
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
                ->whereNotNull('po.NO_PO') // SOLO CASOS CON PO
                ->select([
                    DB::raw('COALESCE(po.NO_PO, CONCAT("HT-", ht.id)) as AGRUPADOR'),
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    'po.NO_PO',
                    'po.FECHA_APROBACION as FECHA_APROBACION_PO',
                    'po.FECHA_ENTREGA as FECHA_ENTREGA_PO',
                    DB::raw("
                    CASE 
                        WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL THEN 
                            CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
                        WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL THEN 
                            CONCAT(provtemp.RAZON_PROVEEDORTEMP, IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
                        ELSE NULL 
                    END as PROVEEDOR
                "),
                    'po.MATERIALES_JSON',
                    DB::raw('NULL as HT_DESCRIPCION'),
                    DB::raw('NULL as MATERIALES_HOJA_JSON')
                ])
                ->groupBy(
                    'AGRUPADOR',
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    'po.NO_PO',
                    'po.FECHA_APROBACION',
                    'po.FECHA_ENTREGA',
                    'prov.RAZON_SOCIAL_ALTA',
                    'prov.RFC_ALTA',
                    'po.MATERIALES_JSON',
                    'provtemp.RAZON_PROVEEDORTEMP',
                    'provtemp.RFC_PROVEEDORTEMP'
                );

            // CONSULTA SEPARADA PARA CASOS SIN PO
            $rowsSinPO = DB::table('hoja_trabajo as ht')
                ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
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
                ->whereNull('po.NO_PO') // SOLO CASOS SIN PO
                ->select([
                    DB::raw('CONCAT("HT-", ht.id) as AGRUPADOR'),
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    DB::raw('NULL as NO_PO'),
                    DB::raw('NULL as FECHA_APROBACION_PO'),
                    DB::raw('NULL as FECHA_ENTREGA_PO'),
                    DB::raw("
                    CASE 
                        WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL THEN 
                            CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
                        WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL THEN 
                            CONCAT(provtemp.RAZON_PROVEEDORTEMP, IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
                        WHEN ht.PROVEEDOR_SELECCIONADO IS NOT NULL THEN ht.PROVEEDOR_SELECCIONADO
                        ELSE NULL
                    END as PROVEEDOR
                "),
                    DB::raw('NULL as MATERIALES_JSON'),
                    'ht.DESCRIPCION as HT_DESCRIPCION',
                    'ht.MATERIALES_HOJA_JSON'
                ]);

            // UNIR AMBAS CONSULTAS Y ORDENAR
            $union = $rowsConPO->unionAll($rowsSinPO);

            $rows = DB::query()
                ->fromSub($union, 't')
                ->orderBy('t.NO_MR', 'desc')
                ->get()
                ->map(function ($row) {
                    $bienes = '';

                    // Si tiene PO, usar MATERIALES_JSON
                    if (!empty($row->MATERIALES_JSON)) {
                        $materiales = json_decode($row->MATERIALES_JSON, true);
                        if (is_array($materiales)) {
                            $total = count($materiales);
                            foreach ($materiales as $index => $mat) {
                                if ($index < 3) {
                                    $bienes .= "<div>• {$mat['DESCRIPCION']} ({$mat['CANTIDAD_']})</div>";
                                }
                            }
                            if ($total > 3) {
                                $extra = '';
                                for ($i = 3; $i < $total; $i++) {
                                    $extra .= "<div>• {$materiales[$i]['DESCRIPCION']} ({$materiales[$i]['CANTIDAD_']})</div>";
                                }
                                $bienes .= "<div class='extra-materiales' style='display:none;'>{$extra}</div>";
                                $bienes .= "<button class='btn-ver-mas-materiales btn btn-sm btn-primary'>Ver más</button>";
                            }
                        }
                    }
                    // Si no tiene PO, usar datos de hoja_trabajo
                    else {
                        if (!empty($row->MATERIALES_HOJA_JSON)) {
                            $materiales = json_decode($row->MATERIALES_HOJA_JSON, true);
                            if (is_array($materiales)) {
                                $total = count($materiales);
                                foreach ($materiales as $index => $mat) {
                                    if ($index < 3) {
                                        $cantidad = isset($mat['CANTIDAD_REAL']) ? $mat['CANTIDAD_REAL'] : (isset($mat['CANTIDAD']) ? $mat['CANTIDAD'] : '');
                                        $bienes .= "<div>• {$mat['DESCRIPCION']} ({$cantidad})</div>";
                                    }
                                }
                                if ($total > 3) {
                                    $extra = '';
                                    for ($i = 3; $i < $total; $i++) {
                                        $cantidad = isset($materiales[$i]['CANTIDAD_REAL']) ? $materiales[$i]['CANTIDAD_REAL'] : (isset($materiales[$i]['CANTIDAD']) ? $materiales[$i]['CANTIDAD'] : '');
                                        $extra .= "<div>• {$materiales[$i]['DESCRIPCION']} ({$cantidad})</div>";
                                    }
                                    $bienes .= "<div class='extra-materiales' style='display:none;'>{$extra}</div>";
                                    $bienes .= "<button class='btn-ver-mas-materiales btn btn-sm btn-primary'>Ver más</button>";
                                }
                            }
                        } elseif (!empty($row->HT_DESCRIPCION)) {
                            $bienes = "<div>• {$row->HT_DESCRIPCION}</div>";
                        }
                    }

                    $row->BIEN_SERVICIO = $bienes ?: '-';

                    // Limpiar campos
                    unset($row->MATERIALES_JSON);
                    unset($row->HT_DESCRIPCION);
                    unset($row->MATERIALES_HOJA_JSON);

                    return $row;
                });

            return response()->json(['data' => $rows]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}