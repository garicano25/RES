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

            $rows = DB::table('hoja_trabajo as ht')
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
                ->select([
                    DB::raw('COALESCE(po.NO_PO, CONCAT("HT-", ht.id)) as AGRUPADOR'),
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    'po.NO_PO',
                    'po.FECHA_APROBACION as FECHA_APROBACION_PO',
                    'po.FECHA_ENTREGA as FECHA_ENTREGA_PO',
                    DB::raw("IF(po.NO_PO IS NOT NULL, CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')'), NULL) as PROVEEDOR"),
                    'po.MATERIALES_JSON'
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
                    'po.MATERIALES_JSON'
                )
                ->orderBy('mr.NO_MR', 'desc')
                ->get()
                ->map(function ($row) {
                    $bienes = '';
                    if (!empty($row->MATERIALES_JSON)) {
                        $materiales = json_decode($row->MATERIALES_JSON, true);
                        if (is_array($materiales)) {
                            $total = count($materiales);
                            foreach ($materiales as $index => $mat) {
                                if ($index < 3) {
                                    $bienes .= "<div>{$mat['DESCRIPCION']} ({$mat['CANTIDAD_']})</div>";
                                }
                            }
                            if ($total > 3) {
                                $extra = '';
                                for ($i = 3; $i < $total; $i++) {
                                    $extra .= "<div>{$materiales[$i]['DESCRIPCION']} ({$materiales[$i]['CANTIDAD_']})</div>";
                                }
                                $bienes .= "<div class='extra-materiales' style='display:none;'>{$extra}</div>";
                                $bienes .= "<button class='btn-ver-mas-materiales btn btn-sm btn-primary'>Ver más</button>";
                            }
                        }
                    }
                    $row->BIEN_SERVICIO = $bienes ?: '-';
                    unset($row->MATERIALES_JSON);
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
