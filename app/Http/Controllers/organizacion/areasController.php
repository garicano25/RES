<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\areasModel;
use App\Models\organizacion\departamentosAreasModel;

use DB;


class areasController extends Controller{






    public function TablaAreas(){
        try {
      
            $tabla = areasModel::where('ACTIVO', 1)->get();

            foreach ($tabla as $key => $value) {
    
            
                //Obtenemos el area afectada
                $departamentos = DB::select('SELECT NOMBRE FROM departamentos_areas da  WHERE da.AREA_ID = ? ' , [$value->ID_AREA]);

                $cadena = "";
                foreach ($departamentos  as $key => $val) {
                    $cadena .= "<li>" .  $val->NOMBRE . "</li>";
                }

                $value['DEPARTAMENTOS'] = $cadena;
                $value['ENCARGADOS'] = 'NA';

            
                // // Botones
                // if (auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Reconocimiento', 'CoordinadorHI'])  && ($recsensorial->recsensorial_bloqueado + 0) == 0) {
             
                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-danger btn-circle ELIMINAR"><i class="bi bi-trash3"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-circle EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_ORGANIGRAMA = '<button type="button" class="btn btn-success btn-circle ORGANIGRAMA"><i class="bi bi-diagram-3-fill"></i></button>';


                // } else {
              
                //     $value->boton_eliminar = '<button type="button" class="btn btn-secondary btn-circle"><i class="fa fa-ban"></i></button>';
                // }
            }

            // respuesta
            $dato['data'] = $tabla;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['data'] = 0;
            return response()->json($dato);
        }
    }


    public function TablaCargos($area_id){
        try {

            $tabla = departamentosAreasModel::where('ACTIVO', 1)->where('AREA_ID', $area_id)->get();

            $COUNT = 1;
            foreach ($tabla as $key => $value) {
                
                $value->COUNT = $COUNT;
                $COUNT += 1;


                // // Botones
                // if (auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Reconocimiento', 'CoordinadorHI'])  && ($recsensorial->recsensorial_bloqueado + 0) == 0) {

                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-danger btn-circle ELIMINAR"><i class="bi bi-trash3"></i></button>';

                // } else {

                //     $value->boton_eliminar = '<button type="button" class="btn btn-secondary btn-circle"><i class="fa fa-ban"></i></button>';
                // }
            }

            // respuesta
            $dato['data'] = $tabla;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['data'] = 0;
            return response()->json($dato);
        }
    }


    public function store(Request $request){
       
        try {
            switch (intval($request->api)) {
            //Guardar Area
            case 1: 

                //Guardamos Area
                if ($request->ID_AREA == 0) {

                DB::statement('ALTER TABLE areas AUTO_INCREMENT=1;');
                $areas = areasModel::create($request->all());

                } else{ //Editamos Area y eliminar area

                    if(!isset($request->ELIMINAR)){

                        
                        $areas = areasModel::find($request->ID_AREA);
                        $areas->update($request->all());
                        
                    } else {

                        $areas = areasModel::where('ID_AREA', $request['ID_AREA'])->delete();

                        $response['code']  = 1;
                        $response['area']  = 'Eliminada';
                        return response()->json($response);
                    }

                  
                }

                $response['code']  = 1;
                $response['area']  = $areas;
                return response()->json($response);

                break;
            //Guardar Departamento
            case 2:

                    //Guardamos departamento
                    if ($request->ID_DEPARTAMENTO_AREA == 0) {

                        DB::statement('ALTER TABLE departamentos_areas AUTO_INCREMENT=1;');
                        $areas = departamentosAreasModel::create($request->all());

                    } else { //Editamos departamento

                        $areas = departamentosAreasModel::find($request->ID_DEPARTAMENTO_AREA);
                        $areas->update($request->all());
                    }

                    $response['code']  = 1;
                    $response['departamento']  = $areas;
                    return response()->json($response);

                break;

            default:

                $response['code']  = 2;
                return response()->json($response);

            }
 
        } catch (Exception $e) {

            return response()->json('Error al guardar el Area');
        }
    }
}
