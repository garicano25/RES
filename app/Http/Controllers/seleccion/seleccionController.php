<?php

namespace App\Http\Controllers\seleccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\selección\seleccionModel;
use App\Models\organizacion\catalogoexperienciaModel;

use DB;


class seleccionController extends Controller
{
    


    public function index()
    {
        $areas = DB::select("
        SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE
        FROM catalogo_categorias
        WHERE ACTIVO = 1
        ");


        $puesto = catalogoexperienciaModel::orderBy('NOMBRE_PUESTO', 'ASC')->get();


        return view('RH.Selección.seleccion', compact('areas','puesto'));
    }




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

public function consultarSeleccion($categoriaVacanteId)
{
    $consultar = DB::table('formulario_seleccion')
        ->where('CATEGORIA_VACANTE', $categoriaVacanteId)
        ->where('ACTIVO', 1)  
        ->get();
        
    if ($consultar->isEmpty()) {
        return response()->json([
            'data' => [],
            'message' => 'No hay información relacionada para esta categoría.'
        ]);
    }
    
    return response()->json([
        'data' => $consultar
    ]);
}
    


// public function getFormularioPPT($departamentoAreaId)
// {
//     // Buscar los datos en la tabla formulario_ppt por el ID de departamento
//     $formulario = DB::table('formulario_ppt')
//                     ->where('DEPARTAMENTO_AREA_ID', $departamentoAreaId)
//                     ->first();

//     if ($formulario) {
//         // Retornar la información en formato JSON
//         return response()->json($formulario);
//     } else {
//         // Si no hay resultados, devolver un error
//         return response()->json(['error' => 'No se encontró información.'], 404);
//     }
// }




public function getFormularioPPT($departamentoAreaId)
{
    $formulario = DB::table('formulario_ppt')
                    ->where('DEPARTAMENTO_AREA_ID', $departamentoAreaId)
                    ->first();

    if ($formulario) {
        $cursos = DB::table('cursos_ppt')
                    ->where('FORMULARIO_PPT_ID', $formulario->ID_FORMULARIO_PPT)
                    ->get();

        return response()->json([
            'formulario' => $formulario,
            'cursos' => $cursos
        ]);
    } else {
        return response()->json(['error' => 'No se encontró información.'], 404);
    }
}

    


}
