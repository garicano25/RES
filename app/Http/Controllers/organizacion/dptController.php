<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\organizacion\formulariodptModel;
use App\Models\organizacion\relacionesinternasModel;
use App\Models\organizacion\relacionesexternasModel;
use App\Models\organizacion\catalogojerarquiaModel;
use App\Models\organizacion\catalogorelacionesexternaModel;
use App\Models\organizacion\catalogofuncionescargoModel;
use App\Models\organizacion\catalogofuncionesgestionModel;


use DB;

class dptController extends Controller
{
            public function index()
        {
            $areas = DB::select("
            SELECT NOMBRE, ID_DEPARTAMENTO_AREA as ID, LUGAR_TRABAJO_CATEGORIA AS LUGAR, PROPOSITO_FINALIDAD_CATEGORIA AS PROPOSITO, 0 AS LIDER
            FROM departamentos_areas
            WHERE ACTIVO = 1
            UNION
            SELECT NOMBRE_CARGO AS NOMBRE, ID_ENCARGADO_AREA AS ID, LUGAR_TRABAJO_LIDER AS LUGAR, PROPOSITO_FINALIDAD_LIDER AS PROPOSITO, 1 AS LIDER
            FROM encargados_areas
            ");


            $nivel = catalogojerarquiaModel::orderBy('NOMBRE_JERARQUIA', 'ASC')->get();
            $externo = catalogorelacionesexternaModel::orderBy('NOMBRE_RELACIONEXTERNA', 'ASC')->get();
            $cargo = catalogofuncionescargoModel::orderBy('DESCRIPCION_FUNCION_CARGO', 'ASC')->get();
            $gestion = catalogofuncionesgestionModel::orderBy('DESCRIPCION_FUNCION_GESTION', 'ASC')->get();
            return view('RH.organizacion.DPT', compact('areas','nivel','externo','cargo','gestion'));
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
                $value->BTN_DPT = '<button type="button" class="btn btn-success btn-circle DPT"><i class="bi bi-file-earmark-excel-fill"></i></button>';
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
    


    public function infoReportan($ID, $LIDER)
    {
        try {

            $funciones = DB::select("SELECT ID_CATALOGO_FUNCIONESCARGO ID, DESCRIPCION_FUNCION_CARGO DESCRIPCION, TIPO_FUNCION_CARGO TIPO
            FROM catalogo_funcionescargos
            WHERE CATEGORIAS_CARGO = ? OR TIPO_FUNCION_CARGO = 'generica'
            ORDER BY TIPO_FUNCION_CARGO", [$ID]);


            $gestiones = DB::select("SELECT ID_CATALOGO_FUNCIONESGESTION ID, DESCRIPCION_FUNCION_GESTION DESCRIPCION, TIPO_FUNCION_GESTION TIPO
            FROM catalogo_funcionesgestiones
            WHERE CATEGORIAS_GESTION = ? OR TIPO_FUNCION_GESTION = 'generica'
            ORDER BY TIPO_FUNCION_GESTION",[$ID]);

            if ($LIDER == 1) {

                $info = DB::select("SELECT GROUP_CONCAT(dep.NOMBRE SEPARATOR ', ') AS REPORTAN
                                    FROM encargados_areas encargado
                                    LEFT JOIN departamentos_areas dep ON dep.ENCARGADO_AREA_ID = encargado.ID_ENCARGADO_AREA
                                    WHERE encargado.ID_ENCARGADO_AREA = ?", [$ID]);

            
                // Respuesta
                $response['code'] = 1;
                $response['REPORTAN'] = $info;
                $response['REPORTA'] = 'Director';
                $response['FUNCIONES'] = $funciones;
                $response['GESTIONES'] = $gestiones;
                return response()->json($response);
            } else if  ($LIDER == 0){

                $info = DB::select("SELECT IF(dep.TIENE_ENCARGADO = 1, encargado.NOMBRE_CARGO , 'Director') REPORTA
                                    FROM departamentos_areas dep
                                    LEFT JOIN encargados_areas  encargado ON encargado.ID_ENCARGADO_AREA = dep.ENCARGADO_AREA_ID
                                    WHERE dep.ID_DEPARTAMENTO_AREA = ?", [$ID]);


              
                // Respuesta
                $response['code'] = 1;
                $response['REPORTAN'] = 'Ninguno';
                $response['REPORTA'] = $info;
                $response['FUNCIONES'] = $funciones;
                $response['GESTIONES'] = $gestiones;

                return response()->json($response);

            } else {


                $info = DB::select("SELECT GROUP_CONCAT(NOMBRE_CARGO SEPARATOR ', ') AS REPORTAN FROM encargados_areas");

                // Respuesta
                $response['code'] = 1;
                $response['REPORTAN'] = $info;
                $response['REPORTA'] = 'Ninguno';
                $response['FUNCIONES'] = $funciones;
                $response['GESTIONES'] = $gestiones;

                return response()->json($response);

            }

        } catch (Exception $e) {

            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0,
                'code' => 0
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
                        $funciones_cargo = $request->FUNCIONES_CARGO_DPT ? implode(',', $request->FUNCIONES_CARGO_DPT) : '';
                        $funciones_gestion = $request->FUNCIONES_GESTION_DPT ? implode(',', $request->FUNCIONES_GESTION_DPT) : '';
    
                        $puestos_interactuan = $request->PUESTOS_INTERACTUAN_DPT;
    
                        DB::statement('ALTER TABLE formulario_dpt AUTO_INCREMENT=1;');
                        $DPT = formulariodptModel::create(array_merge($request->all(), [
                            'FUNCIONES_CARGO_DPT' => $funciones_cargo,
                            'FUNCIONES_GESTION_DPT' => $funciones_gestion,
                            'PUESTOS_INTERACTUAN_DPT' => !empty($puestos_interactuan) ? implode(',', $puestos_interactuan) : ''
                        ]));
    
                        // Verifica si existen relaciones internas y las guarda
                        if ($request->INTERNAS_CONQUIEN_DPT) {
                            foreach ($request->INTERNAS_CONQUIEN_DPT as $key => $value) {
                                $paraque = $request->INTERNAS_PARAQUE_DPT[$key] ?? '';
                                $frecuencia = $request->INTERNAS_FRECUENCIA_DPT[$key] ?? '';
                                
                                // Verifica si ya existe una relación interna con este ID
                                $relacion_interna = relacionesinternasModel::find($key);
                                
                                // Si ya existe la relación, actualízala; de lo contrario, créala
                                if ($relacion_interna) {
                                    $relacion_interna->update([
                                        'INTERNAS_CONQUIEN_DPT' => $value,
                                        'INTERNAS_PARAQUE_DPT' => $paraque,
                                        'INTERNAS_FRECUENCIA_DPT' => $frecuencia,
                                    ]);
                                } else {
                                    relacionesinternasModel::create([
                                        'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                        'INTERNAS_CONQUIEN_DPT' => $value,
                                        'INTERNAS_PARAQUE_DPT' => $paraque,
                                        'INTERNAS_FRECUENCIA_DPT' => $frecuencia,
                                    ]);
                                }
                            }
                        }

                        // Actualiza relaciones externas si existen y se han modificado
                        if ($request->EXTERNAS_CONQUIEN_DPT) {
                            foreach ($request->EXTERNAS_CONQUIEN_DPT as $key => $value) {
                                $paraque = $request->EXTERNAS_PARAQUE_DPT[$key] ?? '';
                                $frecuencia = $request->EXTERNAS_FRECUENCIA_DPT[$key] ?? '';
                                
                                // Verifica si ya existe una relación externa con este ID
                                $relacion_externa = relacionesexternasModel::find($key);
                                
                                // Si ya existe la relación, actualízala; de lo contrario, créala
                                if ($relacion_externa) {
                                    $relacion_externa->update([
                                        'EXTERNAS_CONQUIEN_DPT' => $value,
                                        'EXTERNAS_PARAQUE_DPT' => $paraque,
                                        'EXTERNAS_FRECUENCIA_DPT' => $frecuencia,
                                    ]);
                                } else {
                                    relacionesexternasModel::create([
                                        'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                        'EXTERNAS_CONQUIEN_DPT' => $value,
                                        'EXTERNAS_PARAQUE_DPT' => $paraque,
                                        'EXTERNAS_FRECUENCIA_DPT' => $frecuencia,
                                    ]);
                                }
                            }
                        }
                        $response['code'] = 1;
                        $response['DPT'] = $DPT;
                        return response()->json($response);
    
                    } else {
                            $DPT = formulariodptModel::find($request->ID_FORMULARIO_DPT);
                            $funciones_cargo = $request->FUNCIONES_CARGO_DPT ? implode(',', $request->FUNCIONES_CARGO_DPT) : '';
                            $funciones_gestion = $request->FUNCIONES_GESTION_DPT ? implode(',', $request->FUNCIONES_GESTION_DPT) : '';
        
                            $puestos_interactuan = $request->PUESTOS_INTERACTUAN_DPT;
        
                                $DPT->update(array_merge($request->all(), [
                                'FUNCIONES_CARGO_DPT' => $funciones_cargo,
                                'FUNCIONES_GESTION_DPT' => $funciones_gestion,
                                'PUESTOS_INTERACTUAN_DPT' => !empty($puestos_interactuan) ? implode(',', $puestos_interactuan) : ''
                            ]));
        
                           // Verifica si existen relaciones internas y las guarda
                        if ($request->INTERNAS_CONQUIEN_DPT) {
                            foreach ($request->INTERNAS_CONQUIEN_DPT as $key => $value) {
                                $paraque = $request->INTERNAS_PARAQUE_DPT[$key] ?? '';
                                $frecuencia = $request->INTERNAS_FRECUENCIA_DPT[$key] ?? '';
                                
                                // Verifica si ya existe una relación interna con este ID
                                $relacion_interna = relacionesinternasModel::find($key);
                                
                                // Si ya existe la relación, actualízala; de lo contrario, créala
                                if ($relacion_interna) {
                                    $relacion_interna->update([
                                        'INTERNAS_CONQUIEN_DPT' => $value,
                                        'INTERNAS_PARAQUE_DPT' => $paraque,
                                        'INTERNAS_FRECUENCIA_DPT' => $frecuencia,
                                    ]);
                                } else {
                                    relacionesinternasModel::create([
                                        'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                        'INTERNAS_CONQUIEN_DPT' => $value,
                                        'INTERNAS_PARAQUE_DPT' => $paraque,
                                        'INTERNAS_FRECUENCIA_DPT' => $frecuencia,
                                    ]);
                                }
                            }
                        }

                        // Actualiza relaciones externas si existen y se han modificado
                        if ($request->EXTERNAS_CONQUIEN_DPT) {
                            foreach ($request->EXTERNAS_CONQUIEN_DPT as $key => $value) {
                                $paraque = $request->EXTERNAS_PARAQUE_DPT[$key] ?? '';
                                $frecuencia = $request->EXTERNAS_FRECUENCIA_DPT[$key] ?? '';
                                
                                // Verifica si ya existe una relación externa con este ID
                                $relacion_externa = relacionesexternasModel::find($key);
                                
                                // Si ya existe la relación, actualízala; de lo contrario, créala
                                if ($relacion_externa) {
                                    $relacion_externa->update([
                                        'EXTERNAS_CONQUIEN_DPT' => $value,
                                        'EXTERNAS_PARAQUE_DPT' => $paraque,
                                        'EXTERNAS_FRECUENCIA_DPT' => $frecuencia,
                                    ]);
                                } else {
                                    relacionesexternasModel::create([
                                        'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                        'EXTERNAS_CONQUIEN_DPT' => $value,
                                        'EXTERNAS_PARAQUE_DPT' => $paraque,
                                        'EXTERNAS_FRECUENCIA_DPT' => $frecuencia,
                                    ]);
                                }
                            }
                        }


                            $response['code'] = 1;
                            $response['DPT'] = $DPT;
                            return response()->json($response);
                        }
        
                default:
                    $response['code'] = 2;
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json(['code' => 0, 'message' => 'Error al guardar el Área', 'error' => $e->getMessage()]);
        }
    }
    

}