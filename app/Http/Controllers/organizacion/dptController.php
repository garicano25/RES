<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\formulariodptModel;
use App\Models\organizacion\relacionesinternasModel;
use App\Models\organizacion\relacionesexternasModel;
use App\Models\organizacion\departamentosAreasModel;
use DB;

class dptController extends Controller
{
    public function index()
    {
        $areas = departamentosAreasModel::orderBy('NOMBRE', 'ASC')->get();
        
        return view('RH.organizacion.DPT', compact('areas'));
    }

  

    
    public function TablaDPT()
    {
        try {

            $tabla = formulariodptModel::get();

            foreach ($tabla as $key => $value) {

                $value->ELABORADO_POR =  $value->ELABORADO_NOMBRE_DPT . '<br>' . $value->ELABORADO_FECHA_DPT;
                $value->REVISADO_POR = is_null($value->REVISADO_NOMBRE_DPT) ? '<span class="badge text-bg-warning">Sin revisar</span>' : $value->REVISADO_NOMBRE_DPT . '<br>' . $value->REVISADO_FECHA_DPT;
                $value->AUTORIZADO_POR = is_null($value->AUTORIZADO_NOMBRE_DPT) ? '<span class="badge text-bg-danger">Sin autorizar</span>' : $value->AUTORIZADO_NOMBRE_DPT . '<br>' . $value->AUTORIZADO_FECHA_DPT; 



                // // Botones
                // if (auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Reconocimiento', 'CoordinadorHI'])  && ($recsensorial->recsensorial_bloqueado + 0) == 0) {

                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-danger btn-circle ELIMINAR"><i class="bi bi-trash3"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-circle EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DPT = '<button type="button" class="btn btn-success btn-circle DPT"><i class="bi bi-file-earmark-excel"></i></button>';
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
                case 1:
                    // Guardar Formulario DPT
                    if ($request->ID_FORMULARIO_DPT == 0) {
                        DB::statement('ALTER TABLE formulario_dpt AUTO_INCREMENT=1;');
                        $DPT = formulariodptModel::create($request->all());
                    } else {
                        $DPT = formulariodptModel::find($request->ID_FORMULARIO_DPT);
                        $DPT->update($request->all());
                    }

                    // Guardar Relaciones Internas
                 
                        if ($request->INTERNAS_CONQUIEN_DPT) {
                            foreach ($request->INTERNAS_CONQUIEN_DPT as $key => $value) {
                                if (isset($request->INTERNAS_PARAQUE_DPT[$key]) &&
                                    isset($request->INTERNAS_FRECUENCIA_DIARIAS_DPT[$key]) &&
                                    isset($request->INTERNAS_FRECUENCIA_SEMANAL_DPT[$key]) &&
                                    isset($request->INTERNAS_FRECUENCIA_MENSUAL_DPT[$key]) &&
                                    isset($request->INTERNAS_FRECUENCIA_SEMESTRAL_DPT[$key]) &&
                                    isset($request->INTERNAS_FRECUENCIA_ANUAL_DPT[$key])) {

                                    $guardar_internas = relacionesinternasModel::create([
                                        'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                        'INTERNAS_CONQUIEN_DPT' => $value,
                                        'INTERNAS_PARAQUE_DPT' => $request->INTERNAS_PARAQUE_DPT[$key],
                                        'INTERNAS_FRECUENCIA_DIARIAS_DPT' => $request->INTERNAS_FRECUENCIA_DIARIAS_DPT[$key],
                                        'INTERNAS_FRECUENCIA_SEMANAL_DPT' => $request->INTERNAS_FRECUENCIA_SEMANAL_DPT[$key],
                                        'INTERNAS_FRECUENCIA_MENSUAL_DPT' => $request->INTERNAS_FRECUENCIA_MENSUAL_DPT[$key],
                                        'INTERNAS_FRECUENCIA_SEMESTRAL_DPT' => $request->INTERNAS_FRECUENCIA_SEMESTRAL_DPT[$key],
                                        'INTERNAS_FRECUENCIA_ANUAL_DPT' => $request->INTERNAS_FRECUENCIA_ANUAL_DPT[$key]
                                    ]);
                                }
                            }
                        }

                    $request['FUNCIONES_CARGOS_DPT'] = $request->CARGOS;
                    $DPT->update($request->all());

                    $request['FUNCIONES_GESTION_DPT'] = $request->GESTION;
                    $DPT->update($request->all());


                    $response['code'] = 1;
                    $response['DPT'] = $DPT;
                    return response()->json($response);

                default:
                    $response['code'] = 2;
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar el Área');
        }
    }
}

