<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\cursospptModel;
use App\Models\organizacion\formulariopptModel;
use DB;

class pptController extends Controller{



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


                        //GUARDAR LOS CURSOS
                        // if ($request->CURSO_PPT) {
                        //     foreach ($request->CURSO_PPT as $key => $value) {
                        //         $guardar_curso = cursospptModel::create([
                        //             'FORMULARO_PPT_ID' => $PPT->ID_FORMULARIO_PPT,
                        //             'CURSO_PPT' => $value,
                        //             'CURSO_REQUERIDO' => $request->CURSO_REQUERIDO_PPT[$key],
                        //             'CURSO_DESEABLE_PPT' => $request->CURSO_DESEABLE_PPT[$key],
                        //             'CURSO_CUMPLE_PPT' => $request->CURSO_CUMPLE_PPT[$key]
                        //         ]);
                        //     }
                        // }


                    } else { //Editamos el ppt y eliminar ppt

                        echo 'Edit';
                    }

                    $response['code']  = 1;
                    $response['PPT']  = $PPT;
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
