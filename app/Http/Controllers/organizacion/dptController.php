<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\formulariodptModel;
use App\Models\organizacion\relacionesinternasModel;
use App\Models\organizacion\relacionesexternasModel;
use DB;

class dptController extends Controller
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

            return view('RH.organizacion.DPT', compact('areas'));
        }
  

    
    public function TablaDPT()
    {
        try {
            $tabla = formulariodptModel::get();
    
            foreach ($tabla as $value) {
                // Obtención de relaciones internas y externas
                $value->INTERNAS = relacionesinternasModel::where('FORMULARIO_DPT_ID', $value->ID_FORMULARIO_DPT)->get();
                $value->EXTERNAS = relacionesexternasModel::where('FORMULARIO_DPT_ID', $value->ID_FORMULARIO_DPT)->get();
    
                // Formato de campos de usuario
                $value->ELABORADO_POR = $value->ELABORADO_NOMBRE_DPT . '<br>' . $value->ELABORADO_FECHA_DPT;
                $value->REVISADO_POR = is_null($value->REVISADO_NOMBRE_DPT) ? '<span class="badge text-bg-warning">Sin revisar</span>' : $value->REVISADO_NOMBRE_DPT . '<br>' . $value->REVISADO_FECHA_DPT;
                $value->AUTORIZADO_POR = is_null($value->AUTORIZADO_NOMBRE_DPT) ? '<span class="badge text-bg-danger">Sin autorizar</span>' : $value->AUTORIZADO_NOMBRE_DPT . '<br>' . $value->AUTORIZADO_FECHA_DPT;
    
                // Botones
                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-danger btn-circle ELIMINAR"><i class="bi bi-trash3"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-circle EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DPT = '<button type="button" class="btn btn-success btn-circle DPT"><i class="bi bi-file-earmark-excel"></i></button>';
                $value->BTN_ACCION = '<button type="button" class="btn btn-primary btn-circle ACCION"><i class="bi bi-eye"></i></button>';
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
                    // Guardar área
                    if ($request->ID_FORMULARIO_DPT == 0) {


                    // Guardar Formulario DPT

                        DB::statement('ALTER TABLE formulario_dpt AUTO_INCREMENT=1;');
                        $DPT = formulariodptModel::create($request->all());


                        // Verifica si existen relaciones internas y las guarda
                if ($request->INTERNAS_CONQUIEN_DPT) {
                    foreach ($request->INTERNAS_CONQUIEN_DPT as $key => $value) {
                        if (isset($request->INTERNAS_PARAQUE_DPT[$key]) &&
                            isset($request->INTERNAS_FRECUENCIA_DPT[$key])) {

                            $guardar_internas = relacionesinternasModel::create([
                                'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                'INTERNAS_CONQUIEN_DPT' => $value,
                                'INTERNAS_PARAQUE_DPT' => $request->INTERNAS_PARAQUE_DPT[$key],
                                'INTERNAS_FRECUENCIA_DPT' => $request->INTERNAS_FRECUENCIA_DPT[$key],
                            ]);
                        }
                    }
                } 

                // Verifica si existen relaciones externas y las guarda
                if ($request->EXTERNAS_CONQUIEN_DPT) {
                    foreach ($request->EXTERNAS_CONQUIEN_DPT as $key => $value) {
                        if (isset($request->EXTERNAS_PARAQUE_DPT[$key]) &&
                            isset($request->EXTERNAS_FRECUENCIA_DPT[$key])) {

                            $guardar_EXTERNAS = relacionesexternasModel::create([
                                'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                'EXTERNAS_CONQUIEN_DPT' => $value,
                                'EXTERNAS_PARAQUE_DPT' => $request->EXTERNAS_PARAQUE_DPT[$key],
                                'EXTERNAS_FRECUENCIA_DPT' => $request->EXTERNAS_FRECUENCIA_DPT[$key]
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


                }
                 else {
                    $DPT = formulariodptModel::find($request->ID_FORMULARIO_DPT);
                    $DPT->update($request->all());


                    if ($request->INTERNAS_CONQUIEN_DPT) {
                        foreach ($request->INTERNAS_CONQUIEN_DPT as $key => $value) {
                            if (isset($request->INTERNAS_PARAQUE_DPT[$key]) &&
                                isset($request->INTERNAS_FRECUENCIA_DPT[$key])) {
    
                                $guardar_internas = relacionesinternasModel::create([
                                    'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                    'INTERNAS_CONQUIEN_DPT' => $value,
                                    'INTERNAS_PARAQUE_DPT' => $request->INTERNAS_PARAQUE_DPT[$key],
                                    'INTERNAS_FRECUENCIA_DPT' => $request->INTERNAS_FRECUENCIA_DPT[$key],
                                ]);
                            }
                        }
                    } 
    
    
                    // Verifica si existen relaciones externas y las guarda
                    if ($request->EXTERNAS_CONQUIEN_DPT) {
                        foreach ($request->EXTERNAS_CONQUIEN_DPT as $key => $value) {
                            if (isset($request->EXTERNAS_PARAQUE_DPT[$key]) &&
                                isset($request->EXTERNAS_FRECUENCIA_DPT[$key])) {
    
                                $guardar_EXTERNAS = relacionesexternasModel::create([
                                    'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                    'EXTERNAS_CONQUIEN_DPT' => $value,
                                    'EXTERNAS_PARAQUE_DPT' => $request->EXTERNAS_PARAQUE_DPT[$key],
                                    'EXTERNAS_FRECUENCIA_DPT' => $request->EXTERNAS_FRECUENCIA_DPT[$key]
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
                        
                }
             
                default:
                    $response['code'] = 2;
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar el Área');
        }
    }
}
