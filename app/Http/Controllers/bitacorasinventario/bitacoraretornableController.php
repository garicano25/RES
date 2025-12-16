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
use App\Models\usuario\usuarioModel;
use App\Models\bitacorasalmacen\bitacoraModel;



class bitacoraretornableController extends Controller
{
    public function index()
    {

        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();
        $inventario = inventarioModel::where('ACTIVO', 1)->get();
        $usuarios = usuarioModel::where('ACTIVO', 1) ->where('USUARIO_TIPO', 1)->get();

        return view('almacen.bitacoras.bitacora_retornables', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'inventario', 'usuarios'));
    }



    // public function Tablabitacoraretornable()
    // {
    //     try {
    //         $tabla = recemplaedosModel::where('TIPO_SOLICITUD', 2)
    //             ->where('ESTADO_APROBACION', 'Aprobada')
    //             ->where('FINALIZAR_SOLICITUD_ALMACEN', 1)
    //             ->orderBy('FECHA_ALMACEN_SOLICITUD', 'asc')
    //             ->get();

    //         $data = [];
    //         $tiposPermitidos = ['AF', 'ANF'];

    //         foreach ($tabla as $value) {

    //             $materiales = json_decode($value->MATERIALES_JSON, true);
    //             if (!is_array($materiales)) continue;

    //             foreach ($materiales as $articulo) {


    //                 if (!empty($articulo['VARIOS_ARTICULOS']) && $articulo['VARIOS_ARTICULOS'] == "1") {

    //                     if (!empty($articulo['ARTICULOS']) && is_array($articulo['ARTICULOS'])) {

    //                         foreach ($articulo['ARTICULOS'] as $detalle) {

    //                             if (!empty($detalle['ES_ASIGNACION_DETALLE']) && $detalle['ES_ASIGNACION_DETALLE'] == 1) {
    //                                 continue;
    //                             }

    //                             if (
    //                                 empty($detalle['INVENTARIO']) ||
    //                                 empty($detalle['TIPO_INVENTARIO']) ||
    //                                 !in_array($detalle['TIPO_INVENTARIO'], $tiposPermitidos)
    //                             ) continue;

    //                             $producto = DB::table('formulario_inventario')
    //                                 ->select('DESCRIPCION_EQUIPO', 'MARCA_EQUIPO', 'MODELO_EQUIPO', 'SERIE_EQUIPO', 'CODIGO_EQUIPO')
    //                                 ->where('ID_FORMULARIO_INVENTARIO', $detalle['INVENTARIO'])
    //                                 ->first();

    //                             $data[] = [
    //                                 'ID_FORMULARIO_RECURSOS_EMPLEADOS' => $value->ID_FORMULARIO_RECURSOS_EMPLEADOS,
    //                                 'DESCRIPCION' => trim($articulo['DESCRIPCION'] ?? ''),
    //                                 'SOLICITANTE_SALIDA' => $value->SOLICITANTE_SALIDA ?? 'N/A',
    //                                 'FECHA_ALMACEN_SOLICITUD' => $value->FECHA_ALMACEN_SOLICITUD ?? 'N/A',
    //                                 'OBSERVACIONES_REC' => $value->OBSERVACIONES_REC ?? 'N/A',
    //                                 'CANTIDAD' => $detalle['CANTIDAD_DETALLE'] ?? '',
    //                                 'CANTIDAD_SALIDA' => $detalle['CANTIDAD_DETALLE'] ?? '',
    //                                 'PRODUCTO_NOMBRE' => $producto->DESCRIPCION_EQUIPO ?? 'N/A',
    //                                 'MARCA_EQUIPO' => $producto->MARCA_EQUIPO ?? 'N/A',
    //                                 'MODELO_EQUIPO' => $producto->MODELO_EQUIPO ?? 'N/A',
    //                                 'SERIE_EQUIPO' => $producto->SERIE_EQUIPO ?? 'N/A',
    //                                 'CODIGO_EQUIPO' => $producto->CODIGO_EQUIPO ?? 'N/A',
    //                                 'UNIDAD_SALIDA' => $detalle['UNIDAD_DETALLE'] ?? '',
    //                                 'BTN_EDITAR' => '<button type="button" class="btn btn-warning btn-custom rounded-pill editarMaterial"
    //                                                 data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
    //                                                 data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
    //                                                 <i class="bi bi-pencil-square"></i>
    //                                              </button>',
    //                                 'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill visualizarMaterial"
    //                                                 data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
    //                                                 data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
    //                                                 <i class="bi bi-eye"></i>
    //                                             </button>',
    //                             ];
    //                         }
    //                     }



    //                 } else {

    //                     if (!empty($articulo['ES_ASIGNACION']) && $articulo['ES_ASIGNACION'] == 1) {
    //                         continue;
    //                     }

    //                     if (
    //                         empty($articulo['TIPO_INVENTARIO']) ||
    //                         !in_array($articulo['TIPO_INVENTARIO'], $tiposPermitidos)
    //                     ) continue;

    //                     $producto = DB::table('formulario_inventario')
    //                         ->select('DESCRIPCION_EQUIPO', 'MARCA_EQUIPO', 'MODELO_EQUIPO', 'SERIE_EQUIPO', 'CODIGO_EQUIPO')
    //                         ->where('ID_FORMULARIO_INVENTARIO', $articulo['INVENTARIO'])
    //                         ->first();

    //                     $data[] = [
    //                         'ID_FORMULARIO_RECURSOS_EMPLEADOS' => $value->ID_FORMULARIO_RECURSOS_EMPLEADOS,
    //                         'DESCRIPCION' => trim($articulo['DESCRIPCION'] ?? ''),
    //                         'SOLICITANTE_SALIDA' => $value->SOLICITANTE_SALIDA ?? 'N/A',
    //                         'FECHA_ALMACEN_SOLICITUD' => $value->FECHA_ALMACEN_SOLICITUD ?? 'N/A',
    //                         'OBSERVACIONES_REC' => $value->OBSERVACIONES_REC ?? 'N/A',
    //                         'CANTIDAD' => $articulo['CANTIDAD'] ?? '',
    //                         'CANTIDAD_SALIDA' => $articulo['CANTIDAD_SALIDA'] ?? '',
    //                         'PRODUCTO_NOMBRE' => $producto->DESCRIPCION_EQUIPO ?? 'N/A',
    //                         'MARCA_EQUIPO' => $producto->MARCA_EQUIPO ?? 'N/A',
    //                         'MODELO_EQUIPO' => $producto->MODELO_EQUIPO ?? 'N/A',
    //                         'SERIE_EQUIPO' => $producto->SERIE_EQUIPO ?? 'N/A',
    //                         'CODIGO_EQUIPO' => $producto->CODIGO_EQUIPO ?? 'N/A',
    //                         'UNIDAD_SALIDA' => $articulo['UNIDAD_SALIDA'] ?? '',
    //                         'BTN_EDITAR' => '<button type="button" class="btn btn-warning btn-custom rounded-pill editarMaterial"
    //                                     data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
    //                                     data-inventario="' . ($articulo['INVENTARIO'] ?? '') . '">
    //                                     <i class="bi bi-pencil-square"></i>
    //                                  </button>',
    //                         'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill visualizarMaterial"
    //                                     data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
    //                                     data-inventario="' . ($articulo['INVENTARIO'] ?? '') . '">
    //                                     <i class="bi bi-eye"></i>
    //                                 </button>',
    //                     ];
    //                 }
    //             }
    //         }

    //         return response()->json(['data' => $data], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => true,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }






    public function Tablabitacoraretornable()
    {
        try {
            $tabla = recemplaedosModel::where('TIPO_SOLICITUD', 2)
                ->where('ESTADO_APROBACION', 'Aprobada')
                ->where('FINALIZAR_SOLICITUD_ALMACEN', 1)
                ->orderBy('FECHA_ALMACEN_SOLICITUD', 'asc')
                ->get();

            $data = [];

            foreach ($tabla as $value) {

                $materiales = json_decode($value->MATERIALES_JSON, true);
                if (!is_array($materiales)) continue;

                foreach ($materiales as $articulo) {

                    /* ================= VARIOS ================= */
                    if (!empty($articulo['VARIOS_ARTICULOS']) && $articulo['VARIOS_ARTICULOS'] == "1") {

                        if (empty($articulo['RETORNA_EQUIPO']) || $articulo['RETORNA_EQUIPO'] != 1) {
                            continue;
                        }

                        if (!empty($articulo['ARTICULOS']) && is_array($articulo['ARTICULOS'])) {

                            foreach ($articulo['ARTICULOS'] as $detalle) {

                                if (!empty($detalle['ES_ASIGNACION_DETALLE']) && $detalle['ES_ASIGNACION_DETALLE'] == 1) {
                                    continue;
                                }

                                // 🔴 NUEVO: tipo obligatorio, PERO sin limitar AF/ANF
                                if (
                                    empty($detalle['INVENTARIO']) ||
                                    empty($detalle['TIPO_INVENTARIO'])
                                ) continue;

                                $producto = DB::table('formulario_inventario')
                                    ->select('DESCRIPCION_EQUIPO', 'MARCA_EQUIPO', 'MODELO_EQUIPO', 'SERIE_EQUIPO', 'CODIGO_EQUIPO')
                                    ->where('ID_FORMULARIO_INVENTARIO', $detalle['INVENTARIO'])
                                    ->first();

                                $data[] = [
                                    'ID_FORMULARIO_RECURSOS_EMPLEADOS' => $value->ID_FORMULARIO_RECURSOS_EMPLEADOS,
                                    'DESCRIPCION' => trim($articulo['DESCRIPCION'] ?? ''),
                                    'SOLICITANTE_SALIDA' => $value->SOLICITANTE_SALIDA ?? 'N/A',
                                    'FECHA_ALMACEN_SOLICITUD' => $value->FECHA_ALMACEN_SOLICITUD ?? 'N/A',
                                    'OBSERVACIONES_REC' => $value->OBSERVACIONES_REC ?? 'N/A',
                                    'CANTIDAD' => $detalle['CANTIDAD_DETALLE'] ?? '',
                                    'CANTIDAD_SALIDA' => $detalle['CANTIDAD_DETALLE'] ?? '',
                                    'PRODUCTO_NOMBRE' => $producto->DESCRIPCION_EQUIPO ?? 'N/A',
                                    'MARCA_EQUIPO' => $producto->MARCA_EQUIPO ?? 'N/A',
                                    'MODELO_EQUIPO' => $producto->MODELO_EQUIPO ?? 'N/A',
                                    'SERIE_EQUIPO' => $producto->SERIE_EQUIPO ?? 'N/A',
                                    'CODIGO_EQUIPO' => $producto->CODIGO_EQUIPO ?? 'N/A',
                                    'UNIDAD_SALIDA' => $detalle['UNIDAD_DETALLE'] ?? '',
                                    'BTN_EDITAR' => '<button type="button" class="btn btn-warning btn-custom rounded-pill editarMaterial"
                                    data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
                                    data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
                                    <i class="bi bi-pencil-square"></i>
                                </button>',
                                    'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill visualizarMaterial"
                                    data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
                                    data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
                                    <i class="bi bi-eye"></i>
                                </button>',
                                ];
                            }
                        }

                        /* ================= ÚNICO ================= */
                    } else {

                        if (empty($articulo['RETORNA_EQUIPO']) || $articulo['RETORNA_EQUIPO'] != 1) {
                            continue;
                        }

                        if (
                            empty($articulo['TIPO_INVENTARIO']) ||
                            empty($articulo['INVENTARIO'])
                        ) continue;

                        $producto = DB::table('formulario_inventario')
                            ->select('DESCRIPCION_EQUIPO', 'MARCA_EQUIPO', 'MODELO_EQUIPO', 'SERIE_EQUIPO', 'CODIGO_EQUIPO')
                            ->where('ID_FORMULARIO_INVENTARIO', $articulo['INVENTARIO'])
                            ->first();

                        $data[] = [
                            'ID_FORMULARIO_RECURSOS_EMPLEADOS' => $value->ID_FORMULARIO_RECURSOS_EMPLEADOS,
                            'DESCRIPCION' => trim($articulo['DESCRIPCION'] ?? ''),
                            'SOLICITANTE_SALIDA' => $value->SOLICITANTE_SALIDA ?? 'N/A',
                            'FECHA_ALMACEN_SOLICITUD' => $value->FECHA_ALMACEN_SOLICITUD ?? 'N/A',
                            'OBSERVACIONES_REC' => $value->OBSERVACIONES_REC ?? 'N/A',
                            'CANTIDAD' => $articulo['CANTIDAD'] ?? '',
                            'CANTIDAD_SALIDA' => $articulo['CANTIDAD_SALIDA'] ?? '',
                            'PRODUCTO_NOMBRE' => $producto->DESCRIPCION_EQUIPO ?? 'N/A',
                            'MARCA_EQUIPO' => $producto->MARCA_EQUIPO ?? 'N/A',
                            'MODELO_EQUIPO' => $producto->MODELO_EQUIPO ?? 'N/A',
                            'SERIE_EQUIPO' => $producto->SERIE_EQUIPO ?? 'N/A',
                            'CODIGO_EQUIPO' => $producto->CODIGO_EQUIPO ?? 'N/A',
                            'UNIDAD_SALIDA' => $articulo['UNIDAD_SALIDA'] ?? '',
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

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }








    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_BITACORAS_ALMACEN == 0) {
                        DB::statement('ALTER TABLE bitacorasalmacen AUTO_INCREMENT=1;');
                        $bitacoras = bitacoraModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $bitacoras = bitacoraModel::where('ID_BITACORAS_ALMACEN', $request['ID_BITACORAS_ALMACEN'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['bitacora'] = 'Desactivada';
                            } else {
                                $bitacoras = bitacoraModel::where('ID_BITACORAS_ALMACEN', $request['ID_BITACORAS_ALMACEN'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['bitacora'] = 'Activada';
                            }
                        } else {
                            $bitacoras = bitacoraModel::find($request->ID_BITACORAS_ALMACEN);
                            $bitacoras->update($request->all());
                            $response['code'] = 1;
                            $response['bitacora'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['bitacora']  = $bitacoras;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar ');
        }
    }

    

}
