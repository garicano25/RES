<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\catalogotipovacanteModel;

use DB;
class catalogotipovacanteController extends Controller
{
    public function Tablatipovacantes()
    {
        try {
            $tabla = catalogotipovacanteModel::get();
    
            foreach ($tabla as $value) {
            
                // Botones
                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-circle ELIMINAR"><i class="bi bi-power"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-circle EDITAR"><i class="bi bi-pencil-square"></i></button>';
                
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

                    
                    if ($request->ID_CATALOGO_TIPOVACANTE == 0) {

                        DB::statement('ALTER TABLE catalogo_tipovacantes AUTO_INCREMENT=1;');
                        $tipos = catalogotipovacanteModel::create($request->all());
                    } else { 

                        if (!isset($request->ELIMINAR)) {


                            $tipos = catalogotipovacanteModel::find($request->ID_CATALOGO_TIPOVACANTE);
                            $tipos->update($request->all());
                        } else {

                            $tipos = catalogotipovacanteModel::where('ID_CATALOGO_TIPOVACANTE', $request['ID_CATALOGO_TIPOVACANTE'])->delete();

                            $response['code']  = 1;
                            $response['tipo']  = 'Eliminada';
                            return response()->json($response);
                        }
                    }

                    $response['code']  = 1;
                    $response['tipo']  = $tipos;
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
