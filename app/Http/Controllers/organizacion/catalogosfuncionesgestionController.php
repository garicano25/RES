<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\organizacion\catalogofuncionesgestionModel;

use DB;

class catalogosfuncionesgestionController extends Controller
{
    public function index()
    {
        $areas = DB::select("
            SELECT NOMBRE, ID_DEPARTAMENTO_AREA as ID
            FROM departamentos_areas
            WHERE ACTIVO = 1

            UNION

            SELECT NOMBRE_CARGO AS NOMBRE, ID_ENCARGADO_AREA AS ID
            FROM encargados_areas
        ");

        return view('RH.organizacion.Catálogos.catálogo_funcionescargo', compact('areas'));
    }

    public function Tablaafuncionescargo()
    {
        try {
            $tabla = catalogofuncionescargoModel::get();
    
            foreach ($tabla as $value) {
            
                // Botones
                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-danger btn-circle ELIMINAR"><i class="bi bi-trash3"></i></button>';
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

                    
                    if ($request->ID_CATALOGO_FUNCIONESCARGO == 0) {

                        DB::statement('ALTER TABLE catalogo_funcionescargos AUTO_INCREMENT=1;');
                        $cargos = catalogofuncionescargoModel::create($request->all());
                    } else { 

                        if (!isset($request->ELIMINAR)) {


                            $cargos = catalogofuncionescargoModel::find($request->ID_CATALOGO_FUNCIONESCARGO);
                            $cargos->update($request->all());
                        } else {

                            $cargos = catalogofuncionesgestionModel::where('ID_CATALOGO_FUNCIONESCARGO', $request['ID_CATALOGO_FUNCIONESCARGO'])->delete();

                            $response['code']  = 1;
                            $response['cargo']  = 'Eliminada';
                            return response()->json($response);
                        }
                    }

                    $response['code']  = 1;
                    $response['cargo']  = $cargos;
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
