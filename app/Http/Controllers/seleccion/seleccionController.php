<?php

namespace App\Http\Controllers\seleccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\selección\seleccionModel;
use App\Models\selección\seleccionpptModel;
use App\Models\selección\cursospptseleccionModel;
use App\Models\selección\entrevistaseleccionModel;
use App\Models\selección\autorizacionseleccionModel;
use App\Models\selección\inteligenciaseleccionModel;
use App\Models\selección\buroseleccionModel;
use App\Models\selección\referenciaseleccionModel;
use App\Models\selección\referenciasempresasModel;






use Illuminate\Support\Facades\Storage;


use App\Models\organizacion\catalogoexperienciaModel;
use App\Models\selección\catalogopruebasconocimientosModel;

use DB;


class seleccionController extends Controller
{
    


    public function index()
    {
        $areas = DB::select("
        SELECT DISTINCT cat.ID_CATALOGO_CATEGORIA AS ID, cat.NOMBRE_CATEGORIA AS NOMBRE
        FROM catalogo_categorias cat
        INNER JOIN catalogo_vacantes vac ON vac.CATEGORIA_VACANTE = cat.ID_CATALOGO_CATEGORIA
        WHERE cat.ACTIVO = 1
    ");
    


        $puesto = catalogoexperienciaModel::orderBy('NOMBRE_PUESTO', 'ASC')->get();
        $pruebas = catalogopruebasconocimientosModel::orderBy('NOMBRE_PRUEBA', 'ASC')->get();


        return view('RH.Selección.seleccion', compact('areas','puesto','pruebas'));
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
            AND vac.FECHA_EXPIRACION >= CURDATE()");
        
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







public function Tablaentrevistaseleccion(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = entrevistaseleccionModel::where('CURP', $curp)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
            }
        }

        // Responder con la tabla y el mensaje de éxito
        return response()->json([
            'data' => $tabla,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (Exception $e) {
        // En caso de error, responder con el mensaje de error
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}


public function Tablaautorizacion(Request $request)
{
    try {
        $curp = $request->get('curp');
        $tabla = autorizacionseleccionModel::where('CURP', $curp)->get();

        foreach ($tabla as $value) {
         
                // Generar botón para abrir el archivo en un modal
                if ($value->ARCHIVO_AUTORIZACION) {
                    $value->BTN_ARCHIVO = '<button type="button" class="btn btn-info btn-custom rounded-pill btn-ver-pdf" data-curp="' . $value->CURP . '"><i class="bi bi-eye"></i> Ver archivo</button>';
                } else {
                    $value->BTN_ARCHIVO = '<button type="button" class="btn btn-secondary btn-custom rounded-pill" disabled><i class="bi bi-file-earmark-excel"></i> Sin archivo</button>';
                }
            
        }

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




public function visualizarArchivo($curp)
{
    // Buscar la autorización según la CURP
    $autorizacion = autorizacionseleccionModel::where('CURP', $curp)->first();

    // Verificar que se encontró la autorización y que el archivo existe
    if ($autorizacion && Storage::exists($autorizacion->ARCHIVO_AUTORIZACION)) {
        // Generar la ruta completa del archivo en el almacenamiento privado
        $filePath = storage_path('app/' . $autorizacion->ARCHIVO_AUTORIZACION);

        // Devolver el archivo para que se visualice en el navegador
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($filePath).'"'
        ]);
    } else {
        return response()->json(['error' => 'Archivo no encontrado'], 404);
    }
}




public function Tablainteligencia(Request $request)
{
    try {
        $curp = $request->get('curp');
        $tabla = inteligenciaseleccionModel::where('CURP', $curp)->get();

        foreach ($tabla as $value) {
            // Lógica para el botón de editar
            if ($value->ACTIVO == 0) {
                
                
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_COMPLETO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-completo" data-id="' . $value->ID_INTELIGENCIA_SELECCION . '" title="Ver COMPLETO"> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_COMPETENCIAS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-competencias" data-id="' . $value->ID_INTELIGENCIA_SELECCION . '" title="Ver COMPETENCIAS"> <i class="bi bi-filetype-pdf"></i></button>';
    
            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_COMPLETO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-completo" data-id="' . $value->ID_INTELIGENCIA_SELECCION . '" title="Ver COMPLETO"> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_COMPETENCIAS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-competencias" data-id="' . $value->ID_INTELIGENCIA_SELECCION . '" title="Ver COMPETENCIAS"> <i class="bi bi-filetype-pdf"></i></button>';
    
            }

            // Lógica para el campo de riesgo
            switch ($value->RIESGO_PORCENTAJE) {
                case 100:
                    $value->RIESGO = 'Bajo';
                    break;
                case 70:
                    $value->RIESGO = 'Medio';
                    break;
                case 40:
                    $value->RIESGO = 'Alto';
                    break;
                default:
                    $value->RIESGO = 'Desconocido';
                    break;
            }

        }

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


public function mostrarcompetencias($id)
{
    $archivo = inteligenciaseleccionModel::findOrFail($id)->ARCHIVO_COMPETENCIAS;
    return Storage::response($archivo);
}

public function mostrarcompleto($id)
{
    $archivo = inteligenciaseleccionModel::findOrFail($id)->ARCHIVO_COMPLETO;
    return Storage::response($archivo);
}




public function Tablaburo(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = buroseleccionModel::where('CURP', $curp)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-buro" data-id="' . $value->ID_BURO_SELECCION . '" title="Ver buro"> <i class="bi bi-filetype-pdf"></i></button>';

            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-buro" data-id="' . $value->ID_BURO_SELECCION . '" title="Ver buro"> <i class="bi bi-filetype-pdf"></i></button>';

            }
        }

        // Responder con la tabla y el mensaje de éxito
        return response()->json([
            'data' => $tabla,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (Exception $e) {
        // En caso de error, responder con el mensaje de error
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}


public function mostrarburo($id)
{
    $archivo = buroseleccionModel::findOrFail($id)->ARCHIVO_RESULTADO;
    return Storage::response($archivo);
}






// public function Tablareferencia(Request $request)
// {
//     try {
//         $curp = $request->get('curp');

//         // Obtener las referencias de selección
//         $tabla = referenciaseleccionModel::where('CURP', $curp)->get();

//         // Variable para almacenar las filas que se enviarán al DataTable
//         $rows = [];

//         // Recorrer cada fila de la tabla principal
//         foreach ($tabla as $value) {
//             // Obtener las referencias relacionadas
//             $referencias = referenciasempresasModel::where('SELECCION_REFERENCIA_ID', $value->ID_REFERENCIAS_SELECCION)->get();

//             // Preparar la información agrupada
//             $referenciasAgrupadas = [];
//             foreach ($referencias as $referencia) {
//                 $referenciasAgrupadas[] = [
//                     'NOMBRE_EMPRESA' => $referencia->NOMBRE_EMPRESA,
//                     'COMENTARIO' => $referencia->COMENTARIO,
//                     'CUMPLE' => $referencia->CUMPLE,
//                     'ARCHIVO_RESULTADO' => $referencia->ARCHIVO_RESULTADO
//                 ];
//             }

//             // Crear una fila para cada referencia de selección con sus referencias agrupadas
//             $rows[] = [
//                 'ID_REFERENCIAS_SELECCION' => $value->ID_REFERENCIAS_SELECCION,
//                 'EXPERIENCIA_LABORAL' => $value->EXPERIENCIA_LABORAL,
//                 'PORCENTAJE_TOTAL_REFERENCIAS' => $value->PORCENTAJE_TOTAL_REFERENCIAS,
//                 'REFERENCIAS' => $referenciasAgrupadas, // Incluye todas las referencias agrupadas
//                 'BTN_EDITAR' => ($value->ACTIVO == 0) ? 
//                     '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>' :
//                     '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
//             ];
//         }

//         return response()->json([
//             'data' => $rows,
//             'msj' => 'Información consultada correctamente'
//         ]);
//     } catch (Exception $e) {
//         return response()->json([
//             'msj' => 'Error ' . $e->getMessage(),
//             'data' => 0
//         ]);
//     }
// }

public function Tablareferencia(Request $request)
{
    try {
        $curp = $request->get('curp');

        // Obtener las referencias de selección
        $tabla = referenciaseleccionModel::where('CURP', $curp)->get();

        // Variable para almacenar las filas que se enviarán al DataTable
        $rows = [];

        // Recorrer cada fila de la tabla principal
        foreach ($tabla as $value) {
            // Obtener las referencias relacionadas
            $referencias = referenciasempresasModel::where('SELECCION_REFERENCIA_ID', $value->ID_REFERENCIAS_SELECCION)->get();

            // Preparar la información agrupada
            $referenciasAgrupadas = [];
            foreach ($referencias as $referencia) {
                $referenciasAgrupadas[] = [
                    'NOMBRE_EMPRESA' => $referencia->NOMBRE_EMPRESA,
                    'COMENTARIO' => $referencia->COMENTARIO,
                    'CUMPLE' => $referencia->CUMPLE,
                    'ARCHIVO_RESULTADO' => $referencia->ARCHIVO_RESULTADO,
                    'BTN_DOCUMENTO' => '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-referencias" data-id="' . $referencia->ID_LABORAL_SELECCION . '" title="Ver referencias"> <i class="bi bi-filetype-pdf"></i></button>'
                ];
            }

            // Crear una fila para cada referencia de selección con sus referencias agrupadas
            $rows[] = [
                'ID_REFERENCIAS_SELECCION' => $value->ID_REFERENCIAS_SELECCION,
                'EXPERIENCIA_LABORAL' => $value->EXPERIENCIA_LABORAL,
                'PORCENTAJE_TOTAL_REFERENCIAS' => $value->PORCENTAJE_TOTAL_REFERENCIAS,
                'REFERENCIAS' => $referenciasAgrupadas, // Incluye todas las referencias agrupadas
                'BTN_EDITAR' => ($value->ACTIVO == 0) ? 
                    '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>' :
                    '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
            ];
        }

        return response()->json([
            'data' => $rows,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}



public function mostrareferencias($id)
{
    $archivo = referenciasempresasModel::findOrFail($id)->ARCHIVO_RESULTADO;
    return Storage::response($archivo);
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
    


public function obtenerRequerimientos($categoriaId)
{
    try {
        // Consulta a la base de datos para obtener los requerimientos de la categoría seleccionada
        $requerimientos = DB::table('requerimientos_categorias')
            ->where('CATALOGO_CATEGORIAS_ID', $categoriaId)
            ->get();

        if ($requerimientos->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No hay requerimientos asociados a esta categoría.'
            ]);
        }

        return response()->json([
            'data' => $requerimientos
        ]);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'Error al obtener los requerimientos: ' . $e->getMessage()
        ], 500);
    }
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



public function mostrarPDF()
{
    $filePath = storage_path('app/Formatos/PS-RH-FO-02.pdf');
    
    if (file_exists($filePath)) {
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    } else {
        return response()->json(['error' => 'Archivo no encontrado'], 404);
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

                if ((!empty($request->CURSO_PPT[$key]))) {

                    $guardar_curso = cursospptseleccionModel::create([
                        'SELECCION_PPT_ID' => $PPT->ID_PPT_SELECCION,
                        'CURSO_PPT' => $value,
                        'CURSO_REQUERIDO' => isset($request->CURSO_REQUERIDO_PPT[$num]) ? $request->CURSO_REQUERIDO_PPT[$num] : null,
                        'CURSO_DESEABLE' => isset($request->CURSO_DESEABLE_PPT[$num]) ? $request->CURSO_DESEABLE_PPT[$num] : null,
                        'CURSO_CUMPLE_PPT' =>  isset($request->CURSO_CUMPLE_PPT[$num]) ? $request->CURSO_CUMPLE_PPT[$num] : null,
                    ]);
                }
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
                        'SELECCION_PPT_ID' => $PPT->ID_PPT_SELECCION,
                        'CURSO_PPT' => $value,
                        'CURSO_REQUERIDO' => isset($request->CURSO_REQUERIDO_PPT[$num]) ? $request->CURSO_REQUERIDO_PPT[$num] : null,
                        'CURSO_DESEABLE' => isset($request->CURSO_DESEABLE_PPT[$num]) ? $request->CURSO_DESEABLE_PPT[$num] : null,
                        'CURSO_CUMPLE_PPT' =>  isset($request->CURSO_CUMPLE_PPT[$num]) ? $request->CURSO_CUMPLE_PPT[$num] : null,
                    ]);
                }
            }
        }

        $response['code']  = 1;
        $response['PPT']  = $PPT;
        return response()->json($response);
    }

    break;

                
case 2:

    if ($request->ID_ENTREVISTA_SELECCION == 0) {
        DB::statement('ALTER TABLE seleccion_entrevista AUTO_INCREMENT=1;');
        $entrevistas = entrevistaseleccionModel::create($request->all());
    } else {
        if (!isset($request->ELIMINAR)) {
            $entrevistas = entrevistaseleccionModel::find($request->ID_ENTREVISTA_SELECCION);
            
            if ($request->hasFile('ARCHIVO_ENTREVISTA') && $entrevistas->ARCHIVO_ENTREVISTA) {
                Storage::delete($entrevistas->ARCHIVO_ENTREVISTA);
            }

            $entrevistas->update($request->all());
        } else {
            $entrevistas = entrevistaseleccionModel::where('ID_ENTREVISTA_SELECCION', $request['ID_ENTREVISTA_SELECCION'])->update(['ACTIVO' => 0]);
            $response['code'] = 1;
            $response['entrevista'] = 'Desactivada';
            return response()->json($response);
        }
    }

    if ($request->hasFile('ARCHIVO_ENTREVISTA')) {
        $curpFolder = 'reclutamiento/' . $request->CURP;
        $entrevistaFolder = $curpFolder . '/ENTREVISTA/';

        if (!Storage::exists($curpFolder)) {
            Storage::makeDirectory($curpFolder);
        }
        
        if (!Storage::exists($entrevistaFolder)) {
            Storage::makeDirectory($entrevistaFolder);
        }

        $entrevistaFile = $request->file('ARCHIVO_ENTREVISTA');
        $entrevistaFileName = 'ENTREVISTA_' . $request->CURP . '.' . $entrevistaFile->getClientOriginalExtension();
        $entrevistaFile->storeAs($entrevistaFolder, $entrevistaFileName);

        $entrevistas->ARCHIVO_ENTREVISTA = $entrevistaFolder . $entrevistaFileName;
        $entrevistas->save();
    }

    $response['code'] = 1;
    $response['entrevista'] = $entrevistas;
    return response()->json($response);

    break;


case 3:
    if ($request->ID_AUTORIZACION_SELECCION == 0) {
        DB::statement('ALTER TABLE seleccion_autorizacion AUTO_INCREMENT=1;');
        $autorizaciones = autorizacionseleccionModel::create($request->all());
    } else {
        if (!isset($request->ELIMINAR)) {
            $autorizaciones = autorizacionseleccionModel::find($request->ID_AUTORIZACION_SELECCION);
            
            if ($request->hasFile('ARCHIVO_AUTORIZACION') && $autorizaciones->ARCHIVO_AUTORIZACION) {
                Storage::delete($autorizaciones->ARCHIVO_AUTORIZACION);
            }

            $autorizaciones->update($request->all());
        } else {
            $autorizaciones = autorizacionseleccionModel::where('ID_AUTORIZACION_SELECCION', $request['ID_AUTORIZACION_SELECCION'])->update(['ACTIVO' => 0]);
            $response['code'] = 1;
            $response['autorizacion'] = 'Desactivada';
            return response()->json($response);
        }
    }

            if ($request->hasFile('ARCHIVO_AUTORIZACION')) {
            $curpFolder = 'reclutamiento/' . $request->CURP;
            $autorizacionFolder = $curpFolder . '/AUTORIZACION/';

            if (!Storage::exists($curpFolder)) {
                Storage::makeDirectory($curpFolder);
            }

            if (!Storage::exists($autorizacionFolder)) {
                Storage::makeDirectory($autorizacionFolder);
            }

            $autorizacionFile = $request->file('ARCHIVO_AUTORIZACION');
            $autorizacionFileName = 'AUTORIZACION_' . $request->CURP . '.' . $autorizacionFile->getClientOriginalExtension();
            $autorizacionFile->storeAs($autorizacionFolder, $autorizacionFileName);

            $autorizaciones->ARCHIVO_AUTORIZACION = $autorizacionFolder . $autorizacionFileName;
            $autorizaciones->save();
            }

            $response['code'] = 1;
            $response['autorizacion'] = $autorizaciones;
            return response()->json($response);

    break;
            

    case 4:
        if ($request->ID_INTELIGENCIA_SELECCION == 0) {
            DB::statement('ALTER TABLE seleccion_inteligencia AUTO_INCREMENT=1;');
            $inteligencias = inteligenciaseleccionModel::create($request->all());
        } else {
            if (!isset($request->ELIMINAR)) {
                $inteligencias = inteligenciaseleccionModel::find($request->ID_INTELIGENCIA_SELECCION);
                if ($request->hasFile('ARCHIVO_COMPLETO') && $inteligencias->ARCHIVO_COMPLETO) {
                    Storage::delete($inteligencias->ARCHIVO_COMPLETO);
                }
                if ($request->hasFile('ARCHIVO_COMPETENCIAS') && $inteligencias->ARCHIVO_COMPETENCIAS) {
                    Storage::delete($inteligencias->ARCHIVO_COMPETENCIAS);
                }
                $inteligencias->update($request->all());
            } else {
                $inteligencias = inteligenciaseleccionModel::where('ID_INTELIGENCIA_SELECCION', $request['ID_INTELIGENCIA_SELECCION'])->update(['ACTIVO' => 0]);
                $response['code'] = 1;
                $response['inteligencia'] = 'Desactivada';
                return response()->json($response);
            }
        }

        if ($request->hasFile('ARCHIVO_COMPLETO')) {
            $curpFolder = 'reclutamiento/' . $request->CURP . '/Inteligencia Laboral/';
            if (!Storage::exists($curpFolder)) {
                Storage::makeDirectory($curpFolder);
            }
            
            $completoFile = $request->file('ARCHIVO_COMPLETO');
            $completoFileName = 'COMPLETO_' . $request->CURP . '.' . $completoFile->getClientOriginalExtension();
            $completoFile->storeAs($curpFolder, $completoFileName);
            
            $inteligencias->ARCHIVO_COMPLETO = $curpFolder . $completoFileName;
        }

        if ($request->hasFile('ARCHIVO_COMPETENCIAS')) {
            $competenciasFile = $request->file('ARCHIVO_COMPETENCIAS');
            $competenciasFileName = 'COMPETENCIAS_' . $request->CURP . '.' . $competenciasFile->getClientOriginalExtension();
            $competenciasFile->storeAs($curpFolder, $competenciasFileName);
            
            $inteligencias->ARCHIVO_COMPETENCIAS = $curpFolder . $competenciasFileName;
        }

        $inteligencias->save();

        $response['code'] = 1;
        $response['inteligencia'] = $inteligencias;
        return response()->json($response);

        break;

        case 5:

            if ($request->ID_BURO_SELECCION == 0) {
                DB::statement('ALTER TABLE seleccion_buro_laboral AUTO_INCREMENT=1;');
                $autorizaciones = buroseleccionModel::create($request->all());
            } else {
                if (!isset($request->ELIMINAR)) {
                    $autorizaciones = buroseleccionModel::find($request->ID_BURO_SELECCION);
                    
                    if ($request->hasFile('ARCHIVO_RESULTADO') && $autorizaciones->ID_BURO_SELECCION) {
                        Storage::delete($autorizaciones->ARCHIVO_RESULTADO);
                    }
        
                    $autorizaciones->update($request->all());
                } else {
                    $autorizaciones = buroseleccionModel::where('ID_BURO_SELECCION', $request['ID_BURO_SELECCION'])->update(['ACTIVO' => 0]);
                    $response['code'] = 1;
                    $response['autorizacion'] = 'Desactivada';
                    return response()->json($response);
                }
            }
        
            if ($request->hasFile('ARCHIVO_RESULTADO')) {
                $curpFolder = 'reclutamiento/' . $request->CURP;
                $autorizacionFolder = $curpFolder . '/Buro Laboral/';
                
                if (!Storage::exists($curpFolder)) {
                    Storage::makeDirectory($curpFolder);
                }
                
                if (!Storage::exists($autorizacionFolder)) {
                    Storage::makeDirectory($autorizacionFolder);
                }
        
                $autorizacionFile = $request->file('ARCHIVO_RESULTADO');
                $autorizacionFileName = 'BURO_LABORAL_' . $request->CURP . '.' . $autorizacionFile->getClientOriginalExtension();
                $autorizacionFile->storeAs($autorizacionFolder, $autorizacionFileName);
        
                $autorizaciones->ARCHIVO_RESULTADO = $autorizacionFolder . $autorizacionFileName;
                $autorizaciones->save();
            }
        
            $response['code'] = 1;
            $response['autorizacion'] = $autorizaciones;
            return response()->json($response);
        
            break;
    

                    
        
            case 6:
                DB::beginTransaction();
            
                if ($request->ID_REFERENCIAS_SELECCION == 0) {
                    DB::statement('ALTER TABLE seleccion_referencias_laboral AUTO_INCREMENT=1;');
                    $vacante = referenciaseleccionModel::create($request->all());
                } else {
                    $vacante = referenciaseleccionModel::find($request->ID_REFERENCIAS_SELECCION);
            
                    $vacante->update($request->all());
                }
            
                if ($request->has('NOMBRE_EMPRESA')) {
                    foreach ($request->NOMBRE_EMPRESA as $index => $nombreEmpresa) {
                        $comentario = isset($request->COMENTARIO[$index]) ? $request->COMENTARIO[$index] : null;
            
                        $cumpleKey = "CUMPLE_" . ($index + 1);
                        $cumple = $request->input($cumpleKey) ?? null;
            
                        $referencia = referenciasempresasModel::where('SELECCION_REFERENCIA_ID', $vacante->ID_REFERENCIAS_SELECCION)
                            ->where('NOMBRE_EMPRESA', $nombreEmpresa)
                            ->first();
            
                        if ($referencia) {
                            $archivoAnterior = $referencia->ARCHIVO_RESULTADO;
            
                            if ($request->hasFile("ARCHIVO_RESULTADO.$index")) {
                                if ($archivoAnterior) {
                                    Storage::delete($archivoAnterior);
                                }
            
                                $curpFolder = 'reclutamiento/' . $request->CURP;
                                $referenciaFolder = $curpFolder . '/Referencias Laborales/';
            
                                if (!Storage::exists($curpFolder)) {
                                    Storage::makeDirectory($curpFolder);
                                }
            
                                if (!Storage::exists($referenciaFolder)) {
                                    Storage::makeDirectory($referenciaFolder);
                                }
            
                                $archivoFile = $request->file("ARCHIVO_RESULTADO.$index");
                                $archivoFileName = $nombreEmpresa . '_' . $request->CURP . '.' . $archivoFile->getClientOriginalExtension();
                                $archivoFile->storeAs($referenciaFolder, $archivoFileName);
            
                                $referencia->ARCHIVO_RESULTADO = $referenciaFolder . $archivoFileName;
                            } else {
                                $referencia->ARCHIVO_RESULTADO = $archivoAnterior;
                            }
            
                            $referencia->NOMBRE_EMPRESA = $nombreEmpresa;
                            $referencia->COMENTARIO = $comentario;
                            $referencia->CUMPLE = $cumple;
                            $referencia->save();
                        } else {
                            $referencia = referenciasempresasModel::create([
                                'SELECCION_REFERENCIA_ID' => $vacante->ID_REFERENCIAS_SELECCION,
                                'NOMBRE_EMPRESA' => $nombreEmpresa,
                                'COMENTARIO' => $comentario,
                                'CUMPLE' => $cumple,
                            ]);
            
                            if ($request->hasFile("ARCHIVO_RESULTADO.$index")) {
                                $curpFolder = 'reclutamiento/' . $request->CURP;
                                $referenciaFolder = $curpFolder . '/Referencias Laborales/';
            
                                if (!Storage::exists($curpFolder)) {
                                    Storage::makeDirectory($curpFolder);
                                }
            
                                if (!Storage::exists($referenciaFolder)) {
                                    Storage::makeDirectory($referenciaFolder);
                                }
            
                                $archivoFile = $request->file("ARCHIVO_RESULTADO.$index");
                                $archivoFileName = $nombreEmpresa . '_' . $request->CURP . '.' . $archivoFile->getClientOriginalExtension();
                                $archivoFile->storeAs($referenciaFolder, $archivoFileName);
            
                                $referencia->ARCHIVO_RESULTADO = $referenciaFolder . $archivoFileName;
                                $referencia->save();
                            }
                        }
                    }
                }
            
                $response['code']  = 1;
                $response['vacantes']  = $vacante;
                DB::commit();
                return response()->json($response);
                break;
            


        
                        
                        

                            






            default:

                $response['code']  = 2;
                return response()->json($response);
        }
    } catch (Exception $e) {

        return response()->json('Error al guardar');
    }
}

}





