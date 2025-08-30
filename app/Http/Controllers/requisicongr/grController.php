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




class grController extends Controller
{


    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.recepciongr.recepcionbienesgr', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }







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
    //                 'po.MATERIALES_JSON',
    //                 'po.ESTADO_APROBACION'
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

    //         // === CONSULTA ORIGINAL PARA CASOS CON PO ===
    //         $rowsConPO = DB::table('hoja_trabajo as ht')
    //             ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
    //             ->leftJoinSub($poUltimo, 'po', function ($join) {
    //                 $join->whereRaw("
    //             FIND_IN_SET(
    //                 CAST(ht.id AS CHAR), 
    //                 REPLACE(REPLACE(REPLACE(REPLACE(po.HOJA_ID, '[', ''), ']', ''), '\"', ''), ' ', '')
    //             )
    //         ");
    //             })
    //             ->leftJoin('formulario_altaproveedor as prov', function ($join) {
    //                 $join->on('prov.RFC_ALTA', '=', 'po.PROVEEDOR_SELECCIONADO');
    //             })
    //             ->leftJoin('formulario_proveedortemp as provtemp', function ($join) {
    //                 $join->on('provtemp.RAZON_PROVEEDORTEMP', '=', 'po.PROVEEDOR_SELECCIONADO');
    //             })
    //             ->whereNotNull('po.NO_PO')
    //             ->where('po.ESTADO_APROBACION', 'Aprobada')
    //             ->select([
    //                 DB::raw('COALESCE(po.NO_PO, CONCAT("HT-", ht.id)) as AGRUPADOR'),
    //                 'mr.NO_MR',
    //                 'mr.FECHA_APRUEBA_MR',
    //                 'po.NO_PO',
    //                 'po.FECHA_APROBACION as FECHA_APROBACION_PO',
    //                 'po.FECHA_ENTREGA as FECHA_ENTREGA_PO',
    //                 DB::raw("
    //             CASE 
    //                 WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL 
    //                     THEN CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
    //                 WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL 
    //                     THEN CONCAT(provtemp.RAZON_PROVEEDORTEMP, 
    //                         IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', 
    //                             CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
    //                 ELSE NULL 
    //             END as PROVEEDOR
    //         "),
    //                 'po.MATERIALES_JSON',
    //                 DB::raw('NULL as HT_DESCRIPCION'),
    //                 DB::raw('NULL as MATERIALES_HOJA_JSON'),
    //                 DB::raw('po.PROVEEDOR_SELECCIONADO as PROVEEDOR_KEY'),
    //                 DB::raw('NULL as PROVEEDOR_Q1'),
    //                 DB::raw('NULL as PROVEEDOR_Q2'),
    //                 DB::raw('NULL as PROVEEDOR_Q3'),
    //                 DB::raw('NULL as CANTIDAD_REALQ1'),
    //                 DB::raw('NULL as CANTIDAD_REALQ2'),
    //                 DB::raw('NULL as CANTIDAD_REALQ3')
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
    //                 'po.MATERIALES_JSON',
    //                 'provtemp.RAZON_PROVEEDORTEMP',
    //                 'provtemp.RFC_PROVEEDORTEMP',
    //                 'po.PROVEEDOR_SELECCIONADO'
    //             );

    //         // === CONSULTA PARA CASOS SIN PO ===
    //         $rowsSinPO = DB::table('hoja_trabajo as ht')
    //             ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
    //             ->leftJoinSub($poUltimo, 'po', function ($join) {
    //                 $join->whereRaw("
    //             FIND_IN_SET(
    //                 CAST(ht.id AS CHAR), 
    //                 REPLACE(REPLACE(REPLACE(REPLACE(po.HOJA_ID, '[', ''), ']', ''), '\"', ''), ' ', '')
    //             )
    //         ");
    //             })
    //             ->leftJoin('formulario_altaproveedor as prov', function ($join) {
    //                 $join->on('prov.RFC_ALTA', '=', 'ht.PROVEEDOR_SELECCIONADO');
    //             })
    //             ->leftJoin('formulario_proveedortemp as provtemp', function ($join) {
    //                 $join->on('provtemp.RAZON_PROVEEDORTEMP', '=', 'ht.PROVEEDOR_SELECCIONADO');
    //             })
    //             ->whereNull('po.NO_PO')
    //             ->where('ht.ESTADO_APROBACION', 'Aprobada')
    //             ->select([
    //                 DB::raw('CONCAT("HT-", ht.NO_MR, "-", ht.PROVEEDOR_SELECCIONADO) as AGRUPADOR'),
    //                 'mr.NO_MR',
    //                 'mr.FECHA_APRUEBA_MR',
    //                 DB::raw('NULL as NO_PO'),
    //                 DB::raw('NULL as FECHA_APROBACION_PO'),
    //                 DB::raw('NULL as FECHA_ENTREGA_PO'),
    //                 DB::raw("
    //             CASE 
    //                 WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL 
    //                     THEN CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
    //                 WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL 
    //                     THEN CONCAT(provtemp.RAZON_PROVEEDORTEMP, 
    //                         IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', 
    //                             CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
    //                 WHEN ht.PROVEEDOR_SELECCIONADO IS NOT NULL 
    //                     THEN ht.PROVEEDOR_SELECCIONADO
    //                 ELSE NULL 
    //             END as PROVEEDOR
    //         "),
    //                 DB::raw('NULL as MATERIALES_JSON'),
    //                 'ht.DESCRIPCION as HT_DESCRIPCION',
    //                 'ht.MATERIALES_HOJA_JSON',
    //                 'ht.PROVEEDOR_SELECCIONADO as PROVEEDOR_KEY',
    //                 'ht.PROVEEDOR_Q1',
    //                 'ht.PROVEEDOR_Q2',
    //                 'ht.PROVEEDOR_Q3',
    //                 'ht.CANTIDAD_REALQ1',
    //                 'ht.CANTIDAD_REALQ2',
    //                 'ht.CANTIDAD_REALQ3'
    //             ]);

    //         // === UNIR CONSULTAS ===
    //         $union = $rowsConPO->unionAll($rowsSinPO);

    //         // === AGRUPACIÓN FINAL ===
    //         $rows = DB::query()
    //             ->fromSub($union, 't')
    //             ->orderBy('t.NO_MR', 'desc')
    //             ->get()
    //             ->groupBy('AGRUPADOR')
    //             ->map(function ($group) {
    //                 $first = $group->first();

    //                 $materialesArray = [];

    //                 foreach ($group as $row) {
    //                     if (!empty($row->MATERIALES_JSON)) {
    //                         $materiales = json_decode($row->MATERIALES_JSON, true);
    //                         if (is_array($materiales)) {
    //                             foreach ($materiales as $mat) {
    //                                 if (($mat['CANTIDAD_'] ?? 0) > 0) {
    //                                     $materialesArray[] = "• {$mat['DESCRIPCION']} ({$mat['CANTIDAD_']})";
    //                                 }
    //                             }
    //                         }
    //                     } elseif (!empty($row->MATERIALES_HOJA_JSON)) {
    //                         $materiales = json_decode($row->MATERIALES_HOJA_JSON, true);
    //                         if (is_array($materiales)) {
    //                             foreach ($materiales as $mat) {
    //                                 $cantidad = $mat['CANTIDAD_REAL'] ?? ($mat['CANTIDAD'] ?? 0);
    //                                 if ($cantidad > 0) {
    //                                     $materialesArray[] = "• {$mat['DESCRIPCION']} ({$cantidad})";
    //                                 }
    //                             }
    //                         }
    //                     } elseif (!empty($row->HT_DESCRIPCION)) {
    //                         $cantidad = 0;
    //                         if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
    //                             $cantidad = $row->CANTIDAD_REALQ1;
    //                         } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
    //                             $cantidad = $row->CANTIDAD_REALQ2;
    //                         } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
    //                             $cantidad = $row->CANTIDAD_REALQ3;
    //                         }

    //                         if ($cantidad > 0) {
    //                             $materialesArray[] = "• {$row->HT_DESCRIPCION} ({$cantidad})";
    //                         } else {
    //                             $materialesArray[] = "• {$row->HT_DESCRIPCION}";
    //                         }
    //                     }
    //                 }

    //                 $bienes = '';
    //                 if (!empty($materialesArray)) {
    //                     $mostrar = array_slice($materialesArray, 0, 3);
    //                     $ocultos = array_slice($materialesArray, 3);

    //                     foreach ($mostrar as $m) {
    //                         $bienes .= "<div>{$m}</div>";
    //                     }

    //                     if (!empty($ocultos)) {
    //                         $bienes .= '<div class="extra-materiales" style="display:none">';
    //                         foreach ($ocultos as $m) {
    //                             $bienes .= "<div>{$m}</div>";
    //                         }
    //                         $bienes .= '</div>';
    //                         $bienes .= '<button type="button" class="btn-ver-mas-materiales btn btn-link p-0">Ver más</button>';
    //                     }
    //                 } else {
    //                     $bienes = '-';
    //                 }

    //                 $first->BIEN_SERVICIO = $bienes;
    //                 unset($first->MATERIALES_JSON, $first->HT_DESCRIPCION, $first->MATERIALES_HOJA_JSON);

    //                 return $first;
    //             })
    //             ->values();

    //         return response()->json(['data' => $rows]);
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'data' => [],
    //             'error' => true,
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }




    /// CONSULTA CON TODOS LOS DATOS SOLO QUE NO TIENE LO DEL USUARIO


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
    //                 'po.MATERIALES_JSON',
    //                 'po.ESTADO_APROBACION'
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

    //         // === CONSULTA ORIGINAL PARA CASOS CON PO ===
    //         $rowsConPO = DB::table('hoja_trabajo as ht')
    //             ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
    //             ->leftJoinSub($poUltimo, 'po', function ($join) {
    //                 $join->whereRaw("
    //             FIND_IN_SET(
    //                 CAST(ht.id AS CHAR), 
    //                 REPLACE(REPLACE(REPLACE(REPLACE(po.HOJA_ID, '[', ''), ']', ''), '\"', ''), ' ', '')
    //             )
    //         ");
    //             })
    //             ->leftJoin('formulario_altaproveedor as prov', function ($join) {
    //                 $join->on('prov.RFC_ALTA', '=', 'po.PROVEEDOR_SELECCIONADO');
    //             })
    //             ->leftJoin('formulario_proveedortemp as provtemp', function ($join) {
    //                 $join->on('provtemp.RAZON_PROVEEDORTEMP', '=', 'po.PROVEEDOR_SELECCIONADO');
    //             })
    //             ->whereNotNull('po.NO_PO')
    //             ->where('po.ESTADO_APROBACION', 'Aprobada')
    //             ->select([
    //                 DB::raw('COALESCE(po.NO_PO, CONCAT("HT-", ht.id)) as AGRUPADOR'),
    //                 'mr.NO_MR',
    //                 'mr.FECHA_APRUEBA_MR',
    //                 'po.NO_PO',
    //                 'po.FECHA_APROBACION as FECHA_APROBACION_PO',
    //                 'po.FECHA_ENTREGA as FECHA_ENTREGA_PO',
    //                 DB::raw("
    //             CASE 
    //                 WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL 
    //                     THEN CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
    //                 WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL 
    //                     THEN CONCAT(provtemp.RAZON_PROVEEDORTEMP, 
    //                         IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', 
    //                             CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
    //                 ELSE NULL 
    //             END as PROVEEDOR
    //         "),
    //                 'po.MATERIALES_JSON',
    //                 DB::raw('NULL as HT_DESCRIPCION'),
    //                 DB::raw('NULL as MATERIALES_HOJA_JSON'),
    //                 DB::raw('po.PROVEEDOR_SELECCIONADO as PROVEEDOR_KEY'),
    //                 DB::raw('NULL as PROVEEDOR_Q1'),
    //                 DB::raw('NULL as PROVEEDOR_Q2'),
    //                 DB::raw('NULL as PROVEEDOR_Q3'),
    //                 DB::raw('NULL as CANTIDAD_REALQ1'),
    //                 DB::raw('NULL as CANTIDAD_REALQ2'),
    //                 DB::raw('NULL as CANTIDAD_REALQ3'),
    //                 DB::raw('NULL as PRECIO_UNITARIOQ1'),
    //                 DB::raw('NULL as PRECIO_UNITARIOQ2'),
    //                 DB::raw('NULL as PRECIO_UNITARIOQ3')

    //         ])
    //             ->groupBy(
    //                 'AGRUPADOR',
    //                 'mr.NO_MR',
    //                 'mr.FECHA_APRUEBA_MR',
    //                 'po.NO_PO',
    //                 'po.FECHA_APROBACION',
    //                 'po.FECHA_ENTREGA',
    //                 'prov.RAZON_SOCIAL_ALTA',
    //                 'prov.RFC_ALTA',
    //                 'po.MATERIALES_JSON',
    //                 'provtemp.RAZON_PROVEEDORTEMP',
    //                 'provtemp.RFC_PROVEEDORTEMP',
    //                 'po.PROVEEDOR_SELECCIONADO'
    //             );

    //         // === CONSULTA PARA CASOS SIN PO ===
    //         $rowsSinPO = DB::table('hoja_trabajo as ht')
    //             ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
    //             ->leftJoinSub($poUltimo, 'po', function ($join) {
    //                 $join->whereRaw("
    //             FIND_IN_SET(
    //                 CAST(ht.id AS CHAR), 
    //                 REPLACE(REPLACE(REPLACE(REPLACE(po.HOJA_ID, '[', ''), ']', ''), '\"', ''), ' ', '')
    //             )
    //         ");
    //             })
    //             ->leftJoin('formulario_altaproveedor as prov', function ($join) {
    //                 $join->on('prov.RFC_ALTA', '=', 'ht.PROVEEDOR_SELECCIONADO');
    //             })
    //             ->leftJoin('formulario_proveedortemp as provtemp', function ($join) {
    //                 $join->on('provtemp.RAZON_PROVEEDORTEMP', '=', 'ht.PROVEEDOR_SELECCIONADO');
    //             })
    //             ->whereNull('po.NO_PO')
    //             ->where('ht.ESTADO_APROBACION', 'Aprobada')
    //             ->select([
    //                 DB::raw('CONCAT("HT-", ht.NO_MR, "-", ht.PROVEEDOR_SELECCIONADO) as AGRUPADOR'),
    //                 'mr.NO_MR',
    //                 'mr.FECHA_APRUEBA_MR',
    //                 DB::raw('NULL as NO_PO'),
    //                 DB::raw('NULL as FECHA_APROBACION_PO'),
    //                 DB::raw('NULL as FECHA_ENTREGA_PO'),
    //                 DB::raw("
    //             CASE 
    //                 WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL 
    //                     THEN CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
    //                 WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL 
    //                     THEN CONCAT(provtemp.RAZON_PROVEEDORTEMP, 
    //                         IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', 
    //                             CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
    //                 WHEN ht.PROVEEDOR_SELECCIONADO IS NOT NULL 
    //                     THEN ht.PROVEEDOR_SELECCIONADO
    //                 ELSE NULL 
    //             END as PROVEEDOR
    //         "),
    //                 DB::raw('NULL as MATERIALES_JSON'),
    //                 'ht.DESCRIPCION as HT_DESCRIPCION',
    //                 'ht.MATERIALES_HOJA_JSON',
    //                 'ht.PROVEEDOR_SELECCIONADO as PROVEEDOR_KEY',
    //                 'ht.PROVEEDOR_Q1',
    //                 'ht.PROVEEDOR_Q2',
    //                 'ht.PROVEEDOR_Q3',
    //                 'ht.CANTIDAD_REALQ1',
    //                 'ht.CANTIDAD_REALQ2',
    //                 'ht.CANTIDAD_REALQ3',

    //                 'ht.PRECIO_UNITARIOQ1',
    //                 'ht.PRECIO_UNITARIOQ2',
    //                 'ht.PRECIO_UNITARIOQ3'

    //         ]);

    //         // === UNIR CONSULTAS ===
    //         $union = $rowsConPO->unionAll($rowsSinPO);

    //         // === AGRUPACIÓN FINAL ===
    //         $rows = DB::query()
    //             ->fromSub($union, 't')
    //             ->orderBy('t.NO_MR', 'desc')
    //             ->get()
    //             ->groupBy('AGRUPADOR')
    //             ->map(function ($group) {
    //                 $first = $group->first();

    //                 $materialesArray = [];


    //             $vistos = []; 

    //             foreach ($group as $row) {

    //                 if (!empty($row->MATERIALES_JSON)) {
    //                     $materiales = json_decode($row->MATERIALES_JSON, true);
    //                     if (is_array($materiales)) {
    //                         foreach ($materiales as $mat) {
    //                             $cantidad = $mat['CANTIDAD_'] ?? 0;
    //                             $precio   = $mat['PRECIO_UNITARIO'] ?? null;
    //                             $key      = $mat['DESCRIPCION'] . '-' . $cantidad . '-' . $precio;

    //                             if ($cantidad > 0 && !isset($vistos[$key])) {
    //                                 $vistos[$key] = true;
    //                                 $texto = "• {$mat['DESCRIPCION']} ({$cantidad})";
    //                                 if ($precio !== null && $precio !== '') {
    //                                     $texto .= " - $ {$precio}";
    //                                 }
    //                                 $materialesArray[] = $texto;
    //                             }
    //                         }
    //                     }
    //                 }

    //                 // === Caso SIN PO, usando JSON de hoja_trabajo ===
    //                 elseif (!empty($row->MATERIALES_HOJA_JSON)) {
    //                     $materiales = json_decode($row->MATERIALES_HOJA_JSON, true);
    //                     if (is_array($materiales)) {
    //                         foreach ($materiales as $mat) {
    //                             $cantidad = $mat['CANTIDAD_REAL'] ?? ($mat['CANTIDAD'] ?? 0);
    //                             if ($cantidad <= 0) continue;

    //                             // Precio según proveedor seleccionado
    //                             $precio = null;
    //                             if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
    //                                 $precio = $mat['PRECIO_UNITARIO'] ?? null;
    //                             } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
    //                                 $precio = $mat['PRECIO_UNITARIO_Q2'] ?? null;
    //                             } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
    //                                 $precio = $mat['PRECIO_UNITARIO_Q3'] ?? null;
    //                             }

    //                             $key = $mat['DESCRIPCION'] . '-' . $cantidad . '-' . $precio;
    //                             if (!isset($vistos[$key])) {
    //                                 $vistos[$key] = true;
    //                                 $texto = "• {$mat['DESCRIPCION']} ({$cantidad})";
    //                                 if ($precio !== null && $precio !== '') {
    //                                     $texto .= " - $ {$precio}";
    //                                 }
    //                                 $materialesArray[] = $texto;
    //                             }
    //                         }
    //                     }
    //                 }

    //                 // === Caso SIN PO, usando solo descripción/columnas ===
    //                 elseif (!empty($row->HT_DESCRIPCION)) {
    //                     $cantidad = 0;
    //                     $precio   = null;

    //                     if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
    //                         $cantidad = $row->CANTIDAD_REALQ1;
    //                         $precio   = $row->PRECIO_UNITARIOQ1;
    //                     } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
    //                         $cantidad = $row->CANTIDAD_REALQ2;
    //                         $precio   = $row->PRECIO_UNITARIOQ2;
    //                     } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
    //                         $cantidad = $row->CANTIDAD_REALQ3;
    //                         $precio   = $row->PRECIO_UNITARIOQ3;
    //                     }

    //                     if ($cantidad > 0) {
    //                         $key = $row->HT_DESCRIPCION . '-' . $cantidad . '-' . $precio;
    //                         if (!isset($vistos[$key])) {
    //                             $vistos[$key] = true;
    //                             $texto = "• {$row->HT_DESCRIPCION} ({$cantidad})";
    //                             if ($precio !== null && $precio !== '') {
    //                                 $texto .= " - $ {$precio}";
    //                             }
    //                             $materialesArray[] = $texto;
    //                         }
    //                     }
    //                 }
    //             }



    //             $bienes = '';
    //                 if (!empty($materialesArray)) {
    //                     $mostrar = array_slice($materialesArray, 0, 3);
    //                     $ocultos = array_slice($materialesArray, 3);

    //                     foreach ($mostrar as $m) {
    //                         $bienes .= "<div>{$m}</div>";
    //                     }

    //                     if (!empty($ocultos)) {
    //                         $bienes .= '<div class="extra-materiales" style="display:none">';
    //                         foreach ($ocultos as $m) {
    //                             $bienes .= "<div>{$m}</div>";
    //                         }
    //                         $bienes .= '</div>';
    //                         $bienes .= '<button type="button" class="btn-ver-mas-materiales btn btn-link p-0">Ver más</button>';
    //                     }
    //                 } else {
    //                     $bienes = '-';
    //                 }

    //                 $first->BIEN_SERVICIO = $bienes;
    //                 unset($first->MATERIALES_JSON, $first->HT_DESCRIPCION, $first->MATERIALES_HOJA_JSON);

    //                 return $first;
    //             })
    //             ->values();

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
                ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 'mr.USUARIO_ID') // JOIN usuarios
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
                    DB::raw('NULL as PRECIO_UNITARIOQ3')

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
                ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 'mr.USUARIO_ID') // JOIN usuarios
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
                    DB::raw("CONCAT(u.EMPLEADO_NOMBRE, ' ', u.EMPLEADO_APELLIDOPATERNO, ' ', u.EMPLEADO_APELLIDOMATERNO) as USUARIO_NOMBRE"), // Nombre usuario
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
                    'ht.PRECIO_UNITARIOQ3'
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

                    foreach ($group as $row) {
                        if (!empty($row->MATERIALES_JSON)) {
                            $materiales = json_decode($row->MATERIALES_JSON, true);
                            if (is_array($materiales)) {
                                foreach ($materiales as $mat) {
                                    $cantidad = $mat['CANTIDAD_'] ?? 0;
                                    $precio   = $mat['PRECIO_UNITARIO'] ?? null;
                                    $key      = $mat['DESCRIPCION'] . '-' . $cantidad . '-' . $precio;

                                    if ($cantidad > 0 && !isset($vistos[$key])) {
                                        $vistos[$key] = true;
                                        $texto = "• {$mat['DESCRIPCION']} ({$cantidad})";
                                        if ($precio !== null && $precio !== '') {
                                            $texto .= " - $ {$precio}";
                                        }
                                        $materialesArray[] = $texto;
                                    }
                                }
                            }
                        } elseif (!empty($row->MATERIALES_HOJA_JSON)) {
                            $materiales = json_decode($row->MATERIALES_HOJA_JSON, true);
                            if (is_array($materiales)) {
                                foreach ($materiales as $mat) {
                                    $cantidad = $mat['CANTIDAD_REAL'] ?? ($mat['CANTIDAD'] ?? 0);
                                    if ($cantidad <= 0) continue;

                                    $precio = null;
                                    if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
                                        $precio = $mat['PRECIO_UNITARIO'] ?? null;
                                    } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
                                        $precio = $mat['PRECIO_UNITARIO_Q2'] ?? null;
                                    } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
                                        $precio = $mat['PRECIO_UNITARIO_Q3'] ?? null;
                                    }

                                    $key = $mat['DESCRIPCION'] . '-' . $cantidad . '-' . $precio;
                                    if (!isset($vistos[$key])) {
                                        $vistos[$key] = true;
                                        $texto = "• {$mat['DESCRIPCION']} ({$cantidad})";
                                        if ($precio !== null && $precio !== '') {
                                            $texto .= " - $ {$precio}";
                                        }
                                        $materialesArray[] = $texto;
                                    }
                                }
                            }
                        } elseif (!empty($row->HT_DESCRIPCION)) {
                            $cantidad = 0;
                            $precio   = null;

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
                                $key = $row->HT_DESCRIPCION . '-' . $cantidad . '-' . $precio;
                                if (!isset($vistos[$key])) {
                                    $vistos[$key] = true;
                                    $texto = "• {$row->HT_DESCRIPCION} ({$cantidad})";
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
}