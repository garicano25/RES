<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\areasModel;
use App\Models\organizacion\departamentosAreasModel;
use App\Models\organizacion\encargadosAreasModel;


use DB;


class areasController extends Controller
{






    public function TablaAreas()
    {
        try {

            $tabla = areasModel::where('ACTIVO', 1)->get();

            foreach ($tabla as $key => $value) {


                //Obtenemos el area afectada
                $departamentos = DB::select('SELECT NOMBRE FROM departamentos_areas da  WHERE da.AREA_ID = ? ', [$value->ID_AREA]);
                $encargados = DB::select('SELECT NOMBRE_CARGO FROM encargados_areas da  WHERE da.AREA_ID = ? ', [$value->ID_AREA]);


                $cadena = "";
                foreach ($departamentos  as $key => $val) {
                    $cadena .= "<li>" .  $val->NOMBRE . "</li>";
                }

                $encargados_list = "";
                foreach ($encargados  as $key => $val1) {
                    $encargados_list .= "<li>" .  $val1->NOMBRE_CARGO . "</li>";
                }

                $value['DEPARTAMENTOS'] = $cadena;
                $value['ENCARGADOS'] = $encargados_list === "" ? '<span class="badge text-bg-warning ">Sin encargados</span>' : $encargados_list;


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


    public function TablaEncargados($area_id)
    {
        try {

            $tabla = encargadosAreasModel::where('AREA_ID', $area_id)->get();

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


    public function listaEncagadosAreas($area_id){
        try {
            
            $opciones_select = '<option value="">&nbsp;</option>';
            $areas = encargadosAreasModel::where('AREA_ID', $area_id)->get();

            foreach ($areas as $key => $value) {
                
                $opciones_select .= '<option value="' . $value->ID_ENCARGADO_AREA . '"   >' . $value->NOMBRE_CARGO . '</option>';

            }



            // // respuesta
            $dato["code"] = 1;
            $dato['opciones'] = $opciones_select;
            $dato["msj"] = 'Datos consultados correctamente';
            return response()->json($dato);

        } catch (Exception $e) {

            $dato["code"] = 2;
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['opciones'] = $opciones_select;
            return response()->json($dato);
        }
    }


    public function getDataOrganigrama($area_id, $esGeneral){
        try {

            $resultados = DB::select('CALL sp_obtener_json_organigrama_b(?, ?)', [$area_id, $esGeneral]);

            $arreglo_json = [];
            foreach ($resultados as $resultado) {
            
                $json = json_decode($resultado->JSON_DIRECCION, true);
           
                $arreglo_json[] = $json;
            }
            


            $response['code']  = 1;
            $response['data']  = json_encode($arreglo_json);
            return response()->json($response);

        } catch (Exception  $e) {

            return response()->json('Error al ejecutar el Procedure');
        }
    }

    public function store(Request $request)
    {

        try {
            switch (intval($request->api)) {
                    //Guardar Area
                case 1:

                    //Guardamos Area
                    if ($request->ID_AREA == 0) {

                        DB::statement('ALTER TABLE areas AUTO_INCREMENT=1;');
                        $areas = areasModel::create($request->all());
                    } else { //Editamos Area y eliminar area

                        if (!isset($request->ELIMINAR)) {


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
                        $departamentos = departamentosAreasModel::create($request->all());

                        $response['code']  = 1;
                        $response['departamento']  = $departamentos;
                        return response()->json($response);
                    } else { //Eliminar departamento

                        $departamentos = departamentosAreasModel::where('ID_DEPARTAMENTO_AREA', $request['ID_DEPARTAMENTO_AREA'])->delete();

                        $response['code']  = 1;
                        $response['departamento']  = 'Eliminado';
                        return response()->json($response);
                    }

                    break;

                //GUARDAR ENCARGADOS
                case 3:
                    //Guardamos departamento
                    if ($request->ID_ENCARGADO_AREA == 0) {

                        DB::statement('ALTER TABLE encargados_areas AUTO_INCREMENT=1;');
                        $encargados = encargadosAreasModel::create($request->all());

                        $response['code']  = 1;
                        $response['encargado']  = $encargados;
                        return response()->json($response);

                    } else { //Eliminar encargado del area

                        $encargados = encargadosAreasModel::where('ID_ENCARGADO_AREA', $request['ID_ENCARGADO_AREA'])->delete();

                        $response['code']  = 1;
                        $response['encargado']  = 'Eliminado';
                        return response()->json($response);
                    }



                    break;
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
