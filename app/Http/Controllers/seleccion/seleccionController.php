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
            AND vac.FECHA_EXPIRACION >= CURDATE()
        ");
        
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

public function getRelatedData($categoriaVacanteId)
{
    $relatedData = DB::table('formulario_seleccion')
        ->where('CATEGORIA_VACANTE', $categoriaVacanteId)
        ->where('ACTIVO', 1)  // Filtrar solo los registros que tienen ACTIVO = 1
        ->get();
        
    if ($relatedData->isEmpty()) {
        return response()->json([
            'data' => [],
            'message' => 'No hay información relacionada para esta categoría.'
        ]);
    }
    
    return response()->json([
        'data' => $relatedData
    ]);
}
    

    


}
