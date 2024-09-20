<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\organizacion\catalogofuncionesgestionModel;

use DB;

class catalogosfuncionesgestionController extends Controller
{
   

    public function Tablafuncionesgestion()
    {
        try {
            $tabla = catalogofuncionesgestionModel::get();
    
            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_FUNCIONESGESTION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_FUNCIONESGESTION . '" checked><span class="slider round"></span></label>';
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

                
                if ($request->ID_CATALOGO_FUNCIONESGESTION == 0) {

                    DB::statement('ALTER TABLE catalogo_funcionesgestiones AUTO_INCREMENT=1;');
                    $gestiones = catalogofuncionesgestionModel::create($request->all());
                } else { 

                    if (isset($request->ELIMINAR)) {
                        if ($request->ELIMINAR == 1) {
                            $gestiones = catalogofuncionesgestionModel::where('ID_CATALOGO_FUNCIONESGESTION', $request['ID_CATALOGO_FUNCIONESGESTION'])->update(['ACTIVO' => 0]);
                            $response['code'] = 1;
                            $response['gestion'] = 'Desactivada';
                        } else {
                            $gestiones = catalogofuncionesgestionModel::where('ID_CATALOGO_FUNCIONESGESTION', $request['ID_CATALOGO_FUNCIONESGESTION'])->update(['ACTIVO' => 1]);
                            $response['code'] = 1;
                            $response['gestion'] = 'Activada';
                        }
                    } else {
                        $gestiones = catalogofuncionesgestionModel::find($request->ID_CATALOGO_FUNCIONESGESTION);
                        $gestiones->update($request->all());
                        $response['code'] = 1;
                        $response['gestion'] = 'Actualizada';
                    }
                    return response()->json($response);
                }

                $response['code']  = 1;
                $response['gestion']  = $gestiones;
                return response()->json($response);

                break;

            default:

                $response['code']  = 1;
                $response['msj']  = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {

        return response()->json('Error al guardar las funciones');
    }
}

}


