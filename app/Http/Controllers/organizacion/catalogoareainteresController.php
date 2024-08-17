<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\organizacion\cataloareainteresModel;

use DB;





class catalogoareainteresController extends Controller
{
    


    
public function Tablaareainteres()
{
    try {
        $tabla = cataloareainteresModel::get();

        foreach ($tabla as $value) {
            
            // Asignar el texto correspondiente al valor de TIPO_AREA
            if ($value->TIPO_AREA == 1) {
                $value->TIPO_AREA_TEXTO = 'Administrativas';
            } elseif ($value->TIPO_AREA == 2) {
                $value->TIPO_AREA_TEXTO = 'Operativas';
            } else {
                $value->TIPO_AREA_TEXTO = 'Desconocido';
            }

            // Configuración de los botones
            if ($value->ACTIVO == 0) {
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill ELIMINAR" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill ELIMINAR"><i class="bi bi-power"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
            }
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
                    if ($request->ID_CATALOGO_AREAINTERES == 0) {
                        DB::statement('ALTER TABLE catalogo_areainteres AUTO_INCREMENT=1;');
                        $areas = cataloareainteresModel::create($request->all());
                    } else { 

                        if (!isset($request->ELIMINAR)) {
                        $areas = cataloareainteresModel::find($request->ID_CATALOGO_AREAINTERES);
                        $areas->update($request->all());
                        
                    } else {
                        $areas = cataloareainteresModel::where('ID_CATALOGO_AREAINTERES', $request['ID_CATALOGO_AREAINTERES'])->update(['ACTIVO' => 0]);
                        $response['code']  = 1;
                        $response['area']  = '    ';
                        return response()->json($response);
                    }
                    }
                    $response['code']  = 1;
                    $response['area']  = $areas;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar el area');
        }
    }




}
