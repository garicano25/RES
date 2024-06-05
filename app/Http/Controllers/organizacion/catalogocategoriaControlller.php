<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\organizacion\catalogocategoriaModel;


use DB;


class catalogocategoriaControlller extends Controller
{
    public function Tablacategoria()
    {
        try {
            $tabla = catalogocategoriaModel::get();
    
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
                    if ($request->ID_CATALOGO_CATEGORIA == 0) {
                        DB::statement('ALTER TABLE catalogo_categorias AUTO_INCREMENT=1;');
                        $categorias = catalogocategoriaModel::create($request->all());
                    } else { 
                        if (!isset($request->ELIMINAR)) {
                            $categorias = catalogocategoriaModel::find($request->ID_CATALOGO_CATEGORIA);
                            $categorias->update($request->all());
                        } else {
                            $categorias = catalogocategoriaModel::where('ID_CATALOGO_CATEGORIA', $request['ID_CATALOGO_CATEGORIA'])->delete();
                            $response['code']  = 1;
                            $response['categoria']  = 'Eliminada';
                            return response()->json($response);
                        }
                    }
                    $response['code']  = 1;
                    $response['categoria']  = $categorias;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar la nueva categoría');
        }
    }
}
