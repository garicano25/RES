<?php

namespace App\Http\Controllers\seleccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\selección\seleccionModel;
use DB;


class seleccionController extends Controller
{
    

public function Tablaseleccion()
{
    try {
                $tabla = DB::select("
                SELECT vac.*, cat.NOMBRE_CATEGORIA,
                    DATEDIFF(vac.FECHA_EXPIRACION, CURDATE()) as DIAS_RESTANTES,
                    (CASE WHEN vac.FECHA_EXPIRACION < CURDATE() THEN 1 ELSE 0 END) as EXPIRADO
                FROM catalogo_vacantes vac
                LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
                WHERE vac.ACTIVO = 1
            ");
            

        foreach ($tabla as $value) {
            
         
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


}
