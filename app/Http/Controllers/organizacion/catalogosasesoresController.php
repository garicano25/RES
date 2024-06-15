<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\organizacion\catalogoasesorModel;

use DB;


class catalogosasesoresController extends Controller
{
    

    public function Tablaasesores()
    {
        try {
            $tabla = catalogoasesorModel::get();
    
            foreach ($tabla as $value) {
            
                // Botones
                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill ELIMINAR"><i class="bi bi-power"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
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
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar el asesor');
        }
    }
}
