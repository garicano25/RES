<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\reclutamiento\catalogovacantesModel;
use App\Models\organizacion\departamentosAreasModel;

use DB;


class catalogovacantesController extends Controller
{

   
        public function index()
    {
        $areas = DB::select("SELECT ID_CATALOGO_CATEGORIA  AS ID_DEPARTAMENTO_AREA, NOMBRE_CATEGORIA AS NOMBRE
        FROM catalogo_categorias
        WHERE ACTIVO = 1");

        return view('RH.reclutamiento.vacantes', compact('areas'));
   
    }

    

    public function Tablavacantes()
    {
        try {
            $tabla = DB::select("SELECT vac.*, cat.NOMBRE_CATEGORIA
                                FROM catalogo_vacantes vac
                                LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE");
    
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
                    if ($request->ID_CATALOGO_VACANTE == 0) {
                        DB::statement('ALTER TABLE catalogo_vacantes AUTO_INCREMENT=1;');
                        $vacantes = catalogovacantesModel::create($request->all());
                    } else { 
                        if (!isset($request->ELIMINAR)) {
                            $vacantes = catalogovacantesModel::find($request->ID_CATALOGO_VACANTE);
                            $vacantes->update($request->all());
                        } else {
                            $vacantes = catalogovacantesModel::where('ID_CATALOGO_VACANTE', $request['ID_CATALOGO_VACANTE'])->delete();
                            $response['code']  = 1;
                            $response['vacante']  = 'Eliminada';
                            return response()->json($response);
                        }
                    }
                    $response['code']  = 1;
                    $response['vacante']  = $vacantes;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar la nueva vacante');
        }
    }
}
