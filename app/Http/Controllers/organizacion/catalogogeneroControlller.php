<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\organizacion\catalogogeneroModel;

use DB;

class catalogogeneroControlller extends Controller
{
    public function Tablageneros()
    {
        try {
            $tabla = catalogogeneroModel::get();
    
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
                    if ($request->ID_CATALOGO_GENERO == 0) {
                        DB::statement('ALTER TABLE catalogo_generos AUTO_INCREMENT=1;');
                        $generos = catalogogeneroModel::create($request->all());
                    } else { 
                        
                        if (!isset($request->ELIMINAR)) {
                            $generos = catalogogeneroModel::find($request->ID_CATALOGO_GENERO);
                            $generos->update($request->all());
                        } else {
                            $generos = catalogogeneroModel::where('ID_CATALOGO_GENERO', $request['ID_CATALOGO_GENERO'])->update(['ACTIVO' => 0]);
                            $response['code']  = 1;
                            $response['genero']  = 'Desactivada';
                            return response()->json($response);
                        }
                    }
                    $response['code']  = 1;
                    $response['genero']  = $generos;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar el género');
        }
    }
    
}
