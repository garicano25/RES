<?php

namespace App\Http\Controllers\confirmacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;

use App\Models\confirmacion\catalogoverificacioninformacionModel;

class catalagoverificacioninformacionController extends Controller
{
    public function Tablaverificacioncliente()
    {
        try {
            $tabla = catalogoverificacioninformacionModel::get();

            foreach ($tabla as $value) {



                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_VERIFICACION_CLIENTE . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_VERIFICACION_CLIENTE . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
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
                    if ($request->ID_CATALOGO_VERIFICACION_CLIENTE == 0) {
                        DB::statement('ALTER TABLE catalogo_verificacioncliente AUTO_INCREMENT=1;');
                        $verificaciones = catalogoverificacioninformacionModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $verificaciones = catalogoverificacioninformacionModel::where('ID_CATALOGO_VERIFICACION_CLIENTE', $request['ID_CATALOGO_VERIFICACION_CLIENTE'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['verificacion'] = 'Desactivada';
                            } else {
                                $verificaciones = catalogoverificacioninformacionModel::where('ID_CATALOGO_VERIFICACION_CLIENTE', $request['ID_CATALOGO_VERIFICACION_CLIENTE'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['verificacion'] = 'Activada';
                            }
                        } else {
                            $verificaciones = catalogoverificacioninformacionModel::find($request->ID_CATALOGO_VERIFICACION_CLIENTE);
                            $verificaciones->update($request->all());
                            $response['code'] = 1;
                            $response['verificacion'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['verificacion']  = $verificaciones;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar');
        }
    }



}
