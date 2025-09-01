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



    // private function generarNoGR()
    // {
    //     $anio = date('y'); // dos dígitos, ej. "25"
    //     $prefijo = "RES-GR{$anio}-";

    //     // Buscar el último consecutivo de este año
    //     $ultimo = DB::table('formulario_bitacoragr')
    //         ->where('NO_GR', 'like', $prefijo . '%')
    //         ->orderByDesc('NO_GR')
    //         ->value('NO_GR');

    //     if ($ultimo) {
    //         $num = (int) substr($ultimo, -3); // últimos 3 dígitos
    //         $nuevo = str_pad($num + 1, 3, '0', STR_PAD_LEFT);
    //     } else {
    //         $nuevo = "001";
    //     }

    //     return $prefijo . $nuevo;
    // }



    // public function guardarGR(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         // 1. Generar NO_GR
    //         $no_gr = $this->generarNoGR();

    //         // 2. Guardar cabecera
    //         $idGR = DB::table('formulario_bitacoragr')->insertGetId([
    //             'NO_GR' => $no_gr,
    //             'NO_MR' => $request->modal_no_mr,
    //             'NO_PO' => $request->modal_no_po,
    //             'PROVEEDOR_KEY' => $request->PROVEEDOR_EQUIPO,
    //             'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
    //             'FECHA_EMISION' => $request->DESDE_ACREDITACION,
    //             'NO_RECEPCION' => $request->NO_RECEPCION,
    //         ]);

    //         // 3. Guardar detalle (JSON convertido en arrays)
    //         if ($request->has('DESCRIPCION')) {
    //             foreach ($request->DESCRIPCION as $i => $desc) {
    //                 DB::table('formulario_bitacoragr_detalle')->insert([
    //                     'ID_GR' => $idGR,
    //                     'DESCRIPCION' => $desc,
    //                     'CANTIDAD' => $request->CANTIDAD[$i] ?? 0,
    //                     'CANTIDAD_RECHAZADA' => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
    //                     'CANTIDAD_ACEPTADA' => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
    //                     'PRECIO_UNITARIO' => $request->PRECIO_UNITARIO[$i] ?? null,
    //                     'CUMPLE' => $request->CUMPLE[$i] ?? null,
    //                     'COMENTARIO_CUMPLE' => $request->COMENTARIO_CUMPLE[$i] ?? null,
    //                     'ESTADO_FISICO' => $request->ESTADO_FISICO[$i] ?? null,
    //                     'COMENTARIO_ESTADO' => $request->COMENTARIO_ESTADO[$i] ?? null,
    //                     'COMENTARIO_DIFERENCIA' => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
    //                     'TIPO_BS' => $request->TIPO_BS[$i] ?? null,
    //                 ]);
    //             }
    //         }

    //         DB::commit();
    //         return response()->json(['ok' => true, 'no_gr' => $no_gr]);
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => true, 'msg' => $e->getMessage()]);
    //     }
    // }



    // public function guardarGR(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $no_gr = $this->generarNoGR();

    //         $noRecepcion = $this->generarNoRecepcion();

    //         $idGR = DB::table('formulario_bitacoragr')->insertGetId([
    //             'NO_GR'            => $no_gr,
    //             'NO_MR'            => $request->modal_no_mr,
    //             'NO_PO'            => $request->modal_no_po,
    //             'PROVEEDOR_KEY'    => $request->PROVEEDOR_EQUIPO,
    //             'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
    //             'FECHA_EMISION'    => $request->DESDE_ACREDITACION,
    //             'NO_RECEPCION'     => $noRecepcion,
    //             'CREATED_AT'       => now(),
    //         ]);

    //         if ($request->has('DESCRIPCION')) {
    //             foreach ($request->DESCRIPCION as $i => $desc) {
    //                 DB::table('formulario_bitacoragr_detalle')->insert([
    //                     'ID_GR'                 => $idGR,
    //                     'DESCRIPCION'           => $desc,
    //                     'CANTIDAD'              => $request->CANTIDAD[$i] ?? 0,
    //                     'CANTIDAD_RECHAZADA'    => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
    //                     'CANTIDAD_ACEPTADA'     => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
    //                     'PRECIO_UNITARIO'       => $request->PRECIO_UNITARIO[$i] ?? null,
    //                     'CUMPLE'                => $request->CUMPLE[$i] ?? null,
    //                     'COMENTARIO_CUMPLE'     => $request->COMENTARIO_CUMPLE[$i] ?? null,
    //                     'ESTADO_FISICO'         => $request->ESTADO_FISICO[$i] ?? null,
    //                     'COMENTARIO_ESTADO'     => $request->COMENTARIO_ESTADO[$i] ?? null,
    //                     'COMENTARIO_DIFERENCIA' => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
    //                     'TIPO_BS'               => $request->TIPO_BS[$i] ?? null,
    //                 ]);
    //             }
    //         }

    //         DB::commit();
    //         return response()->json([
    //             'ok'          => true,
    //             'no_gr'       => $no_gr,
    //             'no_recepcion' => $noRecepcion,
    //             'msg'         => "GR guardada correctamente",
    //         ]);
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'error'   => true,
    //             'msg'     => $e->getMessage(),
    //             'trace'   => $e->getTraceAsString(),
    //         ], 500);
    //     }
    // }





    public function guardarGR(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->filled('ID_GR')) {
                // ========================
                // MODO EDITAR
                // ========================
                $idGR = $request->ID_GR;

                DB::table('formulario_bitacoragr')
                    ->where('ID_GR', $idGR)
                    ->update([
                        'NO_MR'            => $request->modal_no_mr,
                        'NO_PO'            => $request->modal_no_po,
                        'PROVEEDOR_KEY'    => $request->PROVEEDOR_EQUIPO,
                        'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
                        'FECHA_EMISION'    => $request->DESDE_ACREDITACION,
                        // quitamos updated_at porque no existe en tu tabla
                    ]);

                // Borrar detalle anterior y volver a insertar
                DB::table('formulario_bitacoragr_detalle')
                    ->where('ID_GR', $idGR)
                    ->delete();

                foreach ($request->DESCRIPCION as $i => $desc) {
                    DB::table('formulario_bitacoragr_detalle')->insert([
                        'ID_GR'                 => $idGR,
                        'DESCRIPCION'           => $desc,
                        'CANTIDAD'              => $request->CANTIDAD[$i] ?? 0,
                        'CANTIDAD_RECHAZADA'    => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
                        'CANTIDAD_ACEPTADA'     => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
                        'PRECIO_UNITARIO'       => $request->PRECIO_UNITARIO[$i] ?? null,
                        'CUMPLE'                => $request->CUMPLE[$i] ?? null,
                        'COMENTARIO_CUMPLE'     => $request->COMENTARIO_CUMPLE[$i] ?? null,
                        'ESTADO_FISICO'         => $request->ESTADO_FISICO[$i] ?? null,
                        'COMENTARIO_ESTADO'     => $request->COMENTARIO_ESTADO[$i] ?? null,
                        'COMENTARIO_DIFERENCIA' => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
                        'TIPO_BS'               => $request->TIPO_BS[$i] ?? null,
                    ]);
                }

                DB::commit();
                return response()->json([
                    'ok'    => true,
                    'edit'  => true,
                    'msg'   => "GR actualizada correctamente",
                ]);
            } else {
                // ========================
                // MODO CREAR
                // ========================
                $no_gr       = $this->generarNoGR();
                $noRecepcion = $this->generarNoRecepcion();

                $idGR = DB::table('formulario_bitacoragr')->insertGetId([
                    'NO_GR'            => $no_gr,
                    'NO_MR'            => $request->modal_no_mr,
                    'NO_PO'            => $request->modal_no_po,
                    'PROVEEDOR_KEY'    => $request->PROVEEDOR_EQUIPO,
                    'USUARIO_SOLICITO' => $request->modal_usuario_nombre,
                    'FECHA_EMISION'    => $request->DESDE_ACREDITACION,
                    'NO_RECEPCION'     => $noRecepcion,
                    'CREATED_AT'       => now(),
                ]);

                foreach ($request->DESCRIPCION as $i => $desc) {
                    DB::table('formulario_bitacoragr_detalle')->insert([
                        'ID_GR'                 => $idGR,
                        'DESCRIPCION'           => $desc,
                        'CANTIDAD'              => $request->CANTIDAD[$i] ?? 0,
                        'CANTIDAD_RECHAZADA'    => $request->CANTIDAD_RECHAZADA[$i] ?? 0,
                        'CANTIDAD_ACEPTADA'     => $request->CANTIDAD_ACEPTADA[$i] ?? 0,
                        'PRECIO_UNITARIO'       => $request->PRECIO_UNITARIO[$i] ?? null,
                        'CUMPLE'                => $request->CUMPLE[$i] ?? null,
                        'COMENTARIO_CUMPLE'     => $request->COMENTARIO_CUMPLE[$i] ?? null,
                        'ESTADO_FISICO'         => $request->ESTADO_FISICO[$i] ?? null,
                        'COMENTARIO_ESTADO'     => $request->COMENTARIO_ESTADO[$i] ?? null,
                        'COMENTARIO_DIFERENCIA' => $request->COMENTARIO_DIFERENCIA[$i] ?? null,
                        'TIPO_BS'               => $request->TIPO_BS[$i] ?? null,
                    ]);
                }

                DB::commit();
                return response()->json([
                    'ok'          => true,
                    'edit'        => false,
                    'no_gr'       => $no_gr,
                    'no_recepcion' => $noRecepcion,
                    'msg'         => "GR creada correctamente",
                ]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'msg'   => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }





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





    public function consultarGR(Request $request)
    {
        $no_mr = $request->NO_MR;
        $no_po = $request->NO_PO;
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
                'd.ESTADO_FISICO',
                'd.COMENTARIO_ESTADO',
                'd.COMENTARIO_DIFERENCIA',
                'd.TIPO_BS'
            )
            ->where('gr.NO_MR', $no_mr);

        if ($no_po) {
            $query->where('gr.NO_PO', $no_po);
        } else {
            $query->where('gr.PROVEEDOR_KEY', $proveedor);
        }

        $registros = $query->get();

        if ($registros->isEmpty()) {
            return response()->json(['existe' => false]);
        }

        $cabecera = $registros->first();
        $detalle = $registros->map(function ($row) {
            return [
                'DESCRIPCION' => $row->DESCRIPCION,
                'CANTIDAD' => $row->CANTIDAD,
                'CANTIDAD_RECHAZADA' => $row->CANTIDAD_RECHAZADA,
                'CANTIDAD_ACEPTADA' => $row->CANTIDAD_ACEPTADA,
                'PRECIO_UNITARIO' => $row->PRECIO_UNITARIO,
                'CUMPLE' => $row->CUMPLE,
                'COMENTARIO_CUMPLE' => $row->COMENTARIO_CUMPLE,
                'ESTADO_FISICO' => $row->ESTADO_FISICO,
                'COMENTARIO_ESTADO' => $row->COMENTARIO_ESTADO,
                'COMENTARIO_DIFERENCIA' => $row->COMENTARIO_DIFERENCIA,
                'TIPO_BS' => $row->TIPO_BS,
            ];
        });

        return response()->json([
            'existe' => true,
            'cabecera' => $cabecera,
            'detalle' => $detalle
        ]);
    }



}