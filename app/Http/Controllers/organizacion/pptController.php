<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\cursospptModel;
use App\Models\organizacion\formulariopptModel;
use DB;     

class pptController extends Controller{


    public function TablaPPT()
    {
        try {

            $tabla = formulariopptModel::get();

            foreach ($tabla as $key => $value) {

                $value->ELABORADO_POR =  $value->ELABORADO_NOMBRE_PPT . '<br>' . $value->ELABORADO_FECHA_PPT;
                $value->REVISADO_POR = is_null($value->REVISADO_NOMBRE_PPT) ? '<span class="badge text-bg-warning">Sin revisar</span>' : $value->REVISADO_NOMBRE_PPT . '<br>' . $value->REVISADO_FECHA_PPT;
                $value->AUTORIZADO_POR = is_null($value->AUTORIZADO_NOMBRE_PPT) ? '<span class="badge text-bg-danger">Sin autorizar</span>' : $value->AUTORIZADO_NOMBRE_PPT . '<br>' . $value->AUTORIZADO_FECHA_PPT; 



                // // Botones
                // if (auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Reconocimiento', 'CoordinadorHI'])  && ($recsensorial->recsensorial_bloqueado + 0) == 0) {

                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-danger btn-circle ELIMINAR"><i class="bi bi-trash3"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-circle EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_PPT = '<button type="button" class="btn btn-success btn-circle PPT"><i class="bi bi-file-earmark-excel"></i></button>';
                $value->BTN_ACCION = '<button type="button" class="btn btn-primary btn-circle ACCION"><i class="bi bi-eye"></i></button>';



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




    public function store(Request $request)
    {

        try {
            switch (intval($request->api)) {
                    //Guardar Area
                case 1:

                    //Guardamos Area
                    if ($request->ID_FORMULARIO_PPT == 0) {

                        //GUARDAR EL FORMULARIO
                        DB::statement('ALTER TABLE formulario_ppt AUTO_INCREMENT=1;');
                        $PPT = formulariopptModel::create($request->all());

                   

                        // GUARDAR LOS CURSOS
                        if ($request->CURSO_PPT) {
                            foreach ($request->CURSO_PPT as $key => $value) {

                                $num = $key + 1;
                                
                                if ((isset($request->CURSO_REQUERIDO_PPT[$key]) || isset($request->CURSO_DESEABLE_PPT[$key])) && isset($request->CURSO_CUMPLE_PPT[$num])) {
                                    
                                    $guardar_curso = cursospptModel::create([
                                        'FORMULARIO_PPT_ID' => $PPT->ID_FORMULARIO_PPT,
                                        'CURSO_PPT' => $value,
                                        'CURSO_REQUERIDO' => $request->CURSO_REQUERIDO_PPT[$key],
                                        'CURSO_DESEABLE' => $request->CURSO_DESEABLE_PPT[$key],
                                        'CURSO_CUMPLE_PPT' => $request->CURSO_CUMPLE_PPT[$num]
                                    ]);

                                } 

                            }
                        }

                        $response['code']  = 1;
                        $response['PPT']  = $PPT;
                        return response()->json($response);


                    } else { //Editamos el ppt y eliminar ppt

               
                        $PPT = formulariopptModel::find($request->ID_FORMULARIO_PPT);
                        $PPT->update($request->all());


                        //ELIMINAMOS LOS CURSOS ANTERIORES
                        $eliminar_cursos = cursospptModel::where('FORMULARIO_PPT_ID', $request["ID_FORMULARIO_PPT"])->delete();


                        // GUARDAR LOS CURSOS
                        if ($request->CURSO_PPT) {
                            foreach ($request->CURSO_PPT as $key => $value) {

                                $num = $key + 1;

                                if ((isset($request->CURSO_REQUERIDO_PPT[$key]) || isset($request->CURSO_DESEABLE_PPT[$key])) && isset($request->CURSO_CUMPLE_PPT[$num])) {

                                    $guardar_curso = cursospptModel::create([
                                        'FORMULARIO_PPT_ID' => $request->ID_FORMULARIO_PPT,
                                        'CURSO_PPT' => $value,
                                        'CURSO_REQUERIDO' => $request->CURSO_REQUERIDO_PPT[$key],
                                        'CURSO_DESEABLE' => $request->CURSO_DESEABLE_PPT[$key],
                                        'CURSO_CUMPLE_PPT' => $request->CURSO_CUMPLE_PPT[$num]
                                    ]);
                                }
                            }
                        }

                        $response['code']  = 1;
                        $response['PPT']  = $PPT;
                        return response()->json($response);
                    }

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
