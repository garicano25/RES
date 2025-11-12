<?php

namespace App\Http\Controllers\bitacorasinventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Log;


use DB;



use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\inventarioModel;
use App\Models\inventario\catalogotipoinventarioModel;


use App\Models\recempleados\recemplaedosModel;


class bitacoraretornableController extends Controller
{
    public function index()
    {

        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();
        $inventario = inventarioModel::where('ACTIVO', 1)->get();

        return view('almacen.bitacoras.bitacora_retornables', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'inventario'));
    }




    public function Tablabitacoraretornable()
    {
        try {
            $tabla = recemplaedosModel::where('TIPO_SOLICITUD', 2)
                ->where('ESTADO_APROBACION', 'Aprobada')
                ->where('FINALIZAR_SOLICITUD_ALMACEN', 1)
                ->orderBy('FECHA_SALIDA', 'asc')
                ->get();

            $data = [];
            $tiposPermitidos = ['AF', 'ANF'];

            foreach ($tabla as $value) {
                $materiales = json_decode($value->MATERIALES_JSON, true);

                if (is_array($materiales)) {
                    foreach ($materiales as $articulo) {
                        if (
                            isset($articulo['EN_EXISTENCIA']) &&
                            $articulo['EN_EXISTENCIA'] != 0 &&
                            isset($articulo['TIPO_INVENTARIO']) &&
                            in_array($articulo['TIPO_INVENTARIO'], $tiposPermitidos)
                        ) {
                            $producto = DB::table('formulario_inventario')
                                ->select('DESCRIPCION_EQUIPO', 'MARCA_EQUIPO', 'MODELO_EQUIPO', 'SERIE_EQUIPO', 'CODIGO_EQUIPO')
                                ->where('ID_FORMULARIO_INVENTARIO', $articulo['INVENTARIO'])
                                ->first();

                            $data[] = [
                                'ID_FORMULARIO_RECURSOS_EMPLEADOS' => $value->ID_FORMULARIO_RECURSOS_EMPLEADOS,
                                'DESCRIPCION' => $articulo['DESCRIPCION'] ?? '',
                                'SOLICITANTE_SALIDA' => $value->SOLICITANTE_SALIDA ?? 'N/A',
                                'FECHA_SALIDA' => $value->FECHA_SALIDA ?? 'N/A',
                                'OBSERVACIONES_REC' => $value->OBSERVACIONES_REC ?? 'N/A',

                                'CANTIDAD' => $articulo['CANTIDAD'] ?? '',
                                'CANTIDAD_SALIDA' => $articulo['CANTIDAD_SALIDA'] ?? '',
                                'PRODUCTO_NOMBRE' => $producto->DESCRIPCION_EQUIPO ?? 'N/A',
                                'MARCA_EQUIPO' => $producto->MARCA_EQUIPO ?? 'N/A',
                                'MODELO_EQUIPO' => $producto->MODELO_EQUIPO ?? 'N/A',
                                'SERIE_EQUIPO' => $producto->SERIE_EQUIPO ?? 'N/A',
                                'CODIGO_EQUIPO' => $producto->CODIGO_EQUIPO ?? 'N/A',
                                'BTN_EDITAR' => '<button type="button" class="btn btn-warning btn-custom rounded-pill editarMaterial" 
                                                data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" 
                                                data-inventario="' . ($articulo['INVENTARIO'] ?? '') . '">
                                                <i class="bi bi-pencil-square"></i>
                                             </button>',
                                'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill visualizarMaterial" 
                                                data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" 
                                                data-inventario="' . ($articulo['INVENTARIO'] ?? '') . '">
                                                <i class="bi bi-eye"></i> 
                                             </button>',
                            ];
                        }
                    }
                }
            }

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }







}
