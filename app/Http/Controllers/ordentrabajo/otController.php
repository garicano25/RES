<?php

namespace App\Http\Controllers\ordentrabajo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;

use App\Models\ofertas\ofertasModel;

use App\Models\ordentrabajo\otModel;

class otController extends Controller
{
    public function index()
    {
        $solicitudes = ofertasModel::select(
            'ID_FORMULARIO_OFERTAS',
            'NO_OFERTA',
          
        )
            ->where('ESTATUS_OFERTA', 'like', '%Aceptada%')
            ->get();

     

        return view('ventas.orden_trabajo.orden_trabajo', compact('solicitudes'));
    }




    public function Tablaordentrabajo()
    {
        try {
            $tabla = otModel::select(
                'formulario_ordentrabajo.*',
                'formulario_ofertas.NO_OFERTA',

            )
                ->leftJoin(
                    'formulario_ofertas',
                    'formulario_ordentrabajo.OFERTA_ID',
                    '=',
                    'formulario_ofertas.ID_FORMULARIO_OFERTAS'
                )
                ->get();


            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ORDEN . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" disabled><i class="bi  bi-ban"></i></button>';
                  
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ORDEN . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
                    
                }
            }

            // Respuesta
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }




    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_ORDEN == 0) {
                        DB::statement('ALTER TABLE formulario_ordentrabajo AUTO_INCREMENT=1;');

                        $year = date('y'); // Año actual en dos dígitos
                        $lastOrder = otModel::where('NO_ORDEN_CONFIRMACION', 'like', "RESOT-$year-%")
                        ->orderBy('NO_ORDEN_CONFIRMACION', 'desc')
                        ->first();

                        $nextNumber = $lastOrder ? intval(substr($lastOrder->NO_ORDEN_CONFIRMACION, -3)) + 1 : 1;
                        $noOrdenConfirmacion = sprintf("RESOT-%s-%03d", $year, $nextNumber);

                        $ordenes = otModel::create(array_merge($request->all(), [
                            'NO_ORDEN_CONFIRMACION' => $noOrdenConfirmacion
                        ]));

                        return response()->json([
                            'code' => 1,
                            'orden' => $ordenes
                        ]);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            otModel::where('ID_FORMULARIO_ORDEN', $request->ID_FORMULARIO_ORDEN)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'orden' => $estado == 0 ? 'Desactivada' : 'Activada'
                            ]);
                        } else {
                            $ordenes = otModel::find($request->ID_FORMULARIO_ORDEN);
                            if ($ordenes) {
                                $ordenes->update($request->all());
                                return response()->json([
                                    'code' => 1,
                                    'orden' => 'Actualizada'
                                ]);
                            }
                            return response()->json([
                                'code' => 0,
                                'msj' => 'Orden no encontrada'
                            ], 404);
                        }
                    }
                    break;
                default:
                    return response()->json([
                        'code' => 1,
                        'msj' => 'Api no encontrada'
                    ]);
            }
        } catch (Exception $e) {
            Log::error("Error al guardar orden: " . $e->getMessage());
            return response()->json([
                'code' => 0,
                'error' => 'Error al guardar la orden'
            ], 500);
        }
    }

}
