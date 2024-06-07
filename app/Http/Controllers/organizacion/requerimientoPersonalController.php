<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\organizacion\areasModel;
use App\Models\organizacion\formulariorequerimientoModel;
use App\Models\organizacion\departamentosAreasModel;


use DB;

class requerimientoPersonalController extends Controller
{
    public function index()
    {
         $categoria = departamentosAreasModel::orderBy('NOMBRE', 'ASC')->get();

        $areas = areasModel::orderBy('NOMBRE', 'ASC')->get();
        return view('RH.organizacion.requerimiento_personal', compact('areas','categoria'));
        
    }


    public function Tablarequerimiento()
    {
        try {
            $tabla = formulariorequerimientoModel::get();
    
            foreach ($tabla as $value) {
            
                // Botones
                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-danger btn-circle ELIMINAR"><i class="bi bi-trash3"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-circle EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_RP = '<button type="button" class="btn btn-success btn-circle RP"><i class="bi bi-file-earmark-excel-fill"></i></button>';
                $value->BTN_ACCION = '<button type="button" class="btn btn-success btn-circle " data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Finalizado Requisición" title="Finalizado"><i class="bi bi-check-circle-fill"></i></button>';

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

                    
                    if ($request->ID_FORMULARO_REQUERIMIENTO == 0) {

                        DB::statement('ALTER TABLE formulario_requerimientos AUTO_INCREMENT=1;');
                        $requerimientos = formulariorequerimientoModel::create($request->all());
                    } else { 

                        if (!isset($request->ELIMINAR)) {


                            $requerimientos = formulariorequerimientoModel::find($request->ID_FORMULARO_REQUERIMIENTO);
                            $requerimientos->update($request->all());
                        } else {

                            $requerimientos = formulariorequerimientoModel::where('ID_FORMULARO_REQUERIMIENTO', $request['ID_FORMULARO_REQUERIMIENTO'])->delete();

                            $response['code']  = 1;
                            $response['requerimiento']  = 'Eliminada';
                            return response()->json($response);
                        }
                    }

                    $response['code']  = 1;
                    $response['requerimiento']  = $requerimientos;
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

