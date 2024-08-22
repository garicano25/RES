<?php

namespace App\Http\Controllers\seleccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\selección\seleccionModel;


class seleccionController extends Controller
{
    

public function Tablaseleccion()
{
    try {
        $tabla = seleccionModel::select(
                'formulario_seleccion.*', 
                'catalogo_categorias.NOMBRE_CATEGORIA'
            )
            ->join('catalogo_categorias', 'formulario_seleccion.CATEGORIA_VACANTE', '=', 'catalogo_categorias.ID_CATALOGO_CATEGORIA')
            ->get();

        foreach ($tabla as $value) {
            $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
            $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill ELIMINAR"><i class="bi bi-power"></i></button>';
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


}
