<?php

namespace App\Http\Controllers\proveedor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\proveedor\proveedortempModel;

use DB;



class proveedortempController extends Controller
{
    public function Tablaproveedortemporal()
    {
        try {
            $tabla = proveedortempModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_PROVEEDORTEMP . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_PROVEEDORTEMP . '" checked><span class="slider round"></span></label>';
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
                    if ($request->ID_FORMULARIO_PROVEEDORTEMP == 0) {
                        DB::statement('ALTER TABLE formulario_proveedortemp AUTO_INCREMENT=1;');
                        $temporales = proveedortempModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $temporales = proveedortempModel::where('ID_FORMULARIO_PROVEEDORTEMP', $request['ID_FORMULARIO_PROVEEDORTEMP'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['temporal'] = 'Desactivada';
                            } else {
                                $temporales = proveedortempModel::where('ID_FORMULARIO_PROVEEDORTEMP', $request['ID_FORMULARIO_PROVEEDORTEMP'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['temporal'] = 'Activada';
                            }
                        } else {
                            $temporales = proveedortempModel::find($request->ID_FORMULARIO_PROVEEDORTEMP);
                            $temporales->update($request->all());
                            $response['code'] = 1;
                            $response['temporal'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['temporal']  = $temporales;
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
