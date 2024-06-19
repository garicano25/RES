<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\organizacion\catalogomotivovacanteModel;

use DB;

class catalogomotivovacanteControlller extends Controller
{
    public function Tablamotivovacante()
    {
        try {
            $tabla = catalogomotivovacanteModel::get();
    
            foreach ($tabla as $value) {
            
                // Botones
                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill ELIMINAR"><i class="bi bi-power"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                
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

                    
                    if ($request->ID_CATALOGO_MOTIVOVACANTE == 0) {

                        DB::statement('ALTER TABLE catalogo_motivovacantes AUTO_INCREMENT=1;');
                        $motivos = catalogomotivovacanteModel::create($request->all());
                    } else { 

                        if (!isset($request->ELIMINAR)) {


                            $motivos = catalogomotivovacanteModel::find($request->ID_CATALOGO_MOTIVOVACANTE);
                            $motivos->update($request->all());
                        } else {

                            $motivos = catalogomotivovacanteModel::where('ID_CATALOGO_MOTIVOVACANTE', $request['ID_CATALOGO_MOTIVOVACANTE'])->delete();

                            $response['code']  = 1;
                            $rbtn-custom rounded-pill']  = 'Eliminada';
                            return response()->json($response);
                        }
                    }

                    $response['code']  = 1;
                    $response['motivo']  = $motivos;
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

                