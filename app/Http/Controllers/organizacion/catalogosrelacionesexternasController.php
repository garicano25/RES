<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\catalogorelacionesexternaModel;

use DB;

class catalogosrelacionesexternasController extends Controller
{
    public function Tablarelacionesexterna()
    {
        try {
            $tabla = catalogorelacionesexternaModel::get();
    
            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill ELIMINAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';

                } else {
                    $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill ELIMINAR"><i class="bi bi-power"></i></button>';
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

                    
                    if ($request->ID_CATALOGO_RELACIONESEXTERNAS == 0) {

                        DB::statement('ALTER TABLE catalogo_relacionesexternas AUTO_INCREMENT=1;');
                        $externas = catalogorelacionesexternaModel::create($request->all());
                    } else { 

                        if (!isset($request->ELIMINAR)) {
                            $externas = catalogorelacionesexternaModel::find($request->ID_CATALOGO_RELACIONESEXTERNAS);
                            $externas->update($request->all());
                            
                        } else {
                            $externas = catalogorelacionesexternaModel::where('ID_CATALOGO_RELACIONESEXTERNAS', $request['ID_CATALOGO_RELACIONESEXTERNAS'])->update(['ACTIVO' => 0]);
                            $response['code']  = 1;
                            $response['externa']  = 'Desactivada';
                            return response()->json($response);
                        }
                    }

                    $response['code']  = 1;
                    $response['externa']  = $externas;
                    return response()->json($response);

                    break;

                default:

                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {

            return response()->json('Error al guardar las Relaciones');
        }
    }

}
