<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\catalogojerarquiaModel;
use App\Models\organizacion\catalogoasesorModel;

use DB;


class catalogosController extends Controller
{
    
    public function Tablajerarquia()
    {
        try {
            $tabla = catalogojerarquiaModel::get();
    
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

                    
                    if ($request->ID_CATALOGO_JERARQUIA == 0) {

                        DB::statement('ALTER TABLE catalogo_jerarquias AUTO_INCREMENT=1;');
                        $jerarquias = catalogojerarquiaModel::create($request->all());
                    } else { 

                        if (!isset($request->ELIMINAR)) {


                            $jerarquias = catalogojerarquiaModel::find($request->ID_CATALOGO_JERARQUIA);
                            $jerarquias->update($request->all());
                        } else {

                            $jerarquias = catalogojerarquiaModel::where('ID_CATALOGO_JERARQUIA', $request['ID_CATALOGO_JERARQUIA'])->delete();

                            $response['code']  = 1;
                            $response['jerarquia']  = 'Eliminada';
                            return response()->json($response);
                        }
                    }

                    $response['code']  = 1;
                    $response['jerarquia']  = $jerarquias;
                    return response()->json($response);

                    break;

                case 2:

                    if ($request->ID_CATALOGO_ASESOR == 0) {

                        DB::statement('ALTER TABLE catalogo_asesores AUTO_INCREMENT=1;');
                        $asesores = catalogoasesorModel::create($request->all());
                    } else { 

                        if (!isset($request->ELIMINAR)) {


                            $asesores = catalogoasesorModel::find($request->ID_CATALOGO_ASESOR);
                            $asesores->update($request->all());
                        } else {

                            $asesores = catalogoasesorModel::where('ID_CATALOGO_ASESOR', $request['ID_CATALOGO_ASESOR'])->delete();

                            $response['code']  = 1;
                            $response['asesor']  = 'Eliminada';
                            return response()->json($response);
                        }
                    }

                    $response['code']  = 1;
                    $response['asesor']  = $asesores;
                    return response()->json($response);

                    break;

                // //GUARDAR ENCARGADOS
                // case 3:
                //     //Guardamos departamento
                //     if ($request->ID_ENCARGADO_AREA == 0) {

                //         DB::statement('ALTER TABLE encargados_areas AUTO_INCREMENT=1;');
                //         $encargados = encargadosAreasModel::create($request->all());

                //         $response['code']  = 1;
                //         $response['encargado']  = $encargados;
                //         return response()->json($response);

                //     } else { //Eliminar encargado del area

                //         $encargados = encargadosAreasModel::where('ID_ENCARGADO_AREA', $request['ID_ENCARGADO_AREA'])->delete();

                //         $response['code']  = 1;
                //         $response['encargado']  = 'Eliminado';
                //         return response()->json($response);
                //     }



                //     break;

                default:

                    $response['code']  = 2;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {

            return response()->json('Error al guardar el Area');
        }
    }

}
