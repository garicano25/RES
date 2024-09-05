<?php

namespace App\Http\Controllers\seleccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\selección\seleccionModel;
use App\Models\selección\seleccionpptModel;
use App\Models\selección\cursospptseleccionModel;



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






public function Tablapptseleccion(Request $request)
{
    try {

        $curp = $request->get('curp');

        $tabla = DB::select('SELECT ppt.*, cat.NOMBRE_CATEGORIA
                             FROM seleccion_ppt ppt
                             LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = ppt.DEPARTAMENTO_AREA_ID
                             WHERE ppt.CURP = ?', [$curp]);

        foreach ($tabla as $key => $value) {
            // Obtener los cursos del formulario
            $cursos = cursospptseleccionModel::where('SELECCION_PPT_ID', $value->ID_PPT_SELECCION)->get();
            $value->CURSOS = $cursos;

            if ($value->ACTIVO == 0) {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
            }
        }

        $dato['data'] = $tabla;
        $dato["msj"] = 'Información consultada correctamente';
        return response()->json($dato);
    } catch (Exception $e) {
        $dato["msj"] = 'Error ' . $e->getMessage();
        $dato['data'] = 0;
        return response()->json($dato);
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
    







public function consultarformppt($departamentoAreaId)
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

    




public function store(Request $request)
{

    try {
        switch (intval($request->api)) {
                //Guardar Area
            case 1:

                //Guardamos Area
                if ($request->ID_PPT_SELECCION == 0) {

                    //GUARDAR EL FORMULARIO
                    DB::statement('ALTER TABLE seleccion_ppt AUTO_INCREMENT=1;');
                    $PPT = seleccionpptModel::create($request->all());

                    // GUARDAR LOS CURSOS


                    if ($request->CURSO_PPT) {
                        foreach ($request->CURSO_PPT as $key => $value) {
                    
                            $num = $key + 1;
                    
                            // Se permite guardar aunque el campo CURSO_PPT esté vacío
                            $guardar_curso = cursospptseleccionModel::create([
                                'SELECCION_PPT_ID' => $PPT->ID_PPT_SELECCION,
                                'CURSO_PPT' => $value ?? null, 
                                'CURSO_REQUERIDO' => isset($request->CURSO_REQUERIDO_PPT[$num]) ? $request->CURSO_REQUERIDO_PPT[$num] : null,
                                'CURSO_DESEABLE' => isset($request->CURSO_DESEABLE_PPT[$num]) ? $request->CURSO_DESEABLE_PPT[$num] : null,
                                'CURSO_CUMPLE_PPT' => isset($request->CURSO_CUMPLE_PPT[$num]) ? $request->CURSO_CUMPLE_PPT[$num] : null,
                            ]);
                        }
                    }
                    

                    $response['code']  = 1;
                    $response['PPT']  = $PPT;
                    return response()->json($response);
                } else { //Editamos el ppt y eliminar ppt



                    $eliminar_ppt = seleccionpptModel::where('ID_PPT_SELECCION', $request->ID_PPT_SELECCION)->delete();

                    $PPT = seleccionpptModel::create($request->all());

                    //ELIMINAMOS LOS CURSOS ANTERIORES
                    $eliminar_cursos = cursospptseleccionModel::where('SELECCION_PPT_ID', $request["ID_PPT_SELECCION"])->delete();


                    // GUARDAR LOS CURSOS
                    if ($request->CURSO_PPT) {
                        foreach ($request->CURSO_PPT as $key => $value) {

                            $num = $key + 1;

                            if ((!empty($request->CURSO_PPT[$key]))) {

                                $guardar_curso = cursospptseleccionModel::create([
                                    'FORMULARIO_PPT_ID' => $PPT->ID_FORMULARIO_PPT,
                                    'CURSO_PPT' => $value,
                                    'CURSO_REQUERIDO' => isset($request->CURSO_REQUERIDO_PPT[$num]) ? $request->CURSO_REQUERIDO_PPT[$num] : null,
                                    'CURSO_DESEABLE' => isset($request->CURSO_DESEABLE_PPT[$num]) ? $request->CURSO_DESEABLE_PPT[$num] : null,
                                    'CURSO_CUMPLE_PPT' => isset($request->CURSO_CUMPLE_PPT[$num]) ? $request->CURSO_CUMPLE_PPT[$num] : null,                                ]);
                            }
                        }
                    }

                    $response['code']  = 1;
                    $response['PPT']  = $PPT;
                    return response()->json($response);
                }

                break;

                

            default:

                $response['code']  = 2;
                return response()->json($response);
        }
    } catch (Exception $e) {

        return response()->json('Error al guardar el Area');
    }
}



}
