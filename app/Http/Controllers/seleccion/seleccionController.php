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
                $value->DOC_COMPETENCIAS = '<button class="btn btn-danger btn-custom rounded-pill DOC_COMPETENCIAS"> <i class="bi bi-file-pdf-fill"></i></button>';
            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->DOC_COMPETENCIAS = '<button class="btn btn-danger btn-custom rounded-pill  "> <i class="bi bi-file-pdf-fill"></i></button>';
            
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

            // Botones para documentos (Documento Competencias y Documento Completo)
            $value->DOC_COMPLETO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button" data-pdf="/completo/' . $value->ARCHIVO_COMPLETO . '"> <i class="bi bi-file-pdf-fill"></i></button>';
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

public function mostrarpdfcompetencias($documento_id)
{
    $documento = inteligenciaseleccionModel::findOrFail($documento_id);

    if (Storage::exists($documento->ARCHIVO_COMPETENCIAS)) {
        return Storage::response($documento->ARCHIVO_COMPETENCIAS);
    } else {
        abort(404, 'Archivo no encontrado');
    }
}






public function Tablaburo(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = buroseleccionModel::where('CURP', $curp)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button" data-pdf="/competencias/' . $value->ARCHIVO_RESULTADO . '"> <i class="bi bi-file-pdf-fill"></i></button>';

            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button" data-pdf="/competencias/' . $value->ARCHIVO_RESULTADO . '"> <i class="bi bi-file-pdf-fill"></i></button>';

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

//             // Para cada referencia, creamos una fila separada en $rows
//             foreach ($referencias as $referencia) {
//                 $rows[] = [
//                     'NOMBRE_EMPRESA' => $referencia->NOMBRE_EMPRESA,
//                     'COMENTARIO' => $referencia->COMENTARIO,
//                     'ARCHIVO_RESULTADO' => $referencia->ARCHIVO_RESULTADO,
//                     'BTN_EDITAR' => ($value->ACTIVO == 0) ? 
//                         '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>' :
//                         '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
//                     'BTN_DOCUMENTO' => '<button class="btn btn-danger btn-custom rounded-pill pdf-button" data-pdf="/competencias/' . $referencia->ARCHIVO_RESULTADO . '"> <i class="bi bi-file-pdf-fill"></i></button>'
//                 ];
//             }
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
                    'ARCHIVO_RESULTADO' => $referencia->ARCHIVO_RESULTADO
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
            
                // Verificar si es un nuevo registro o una actualización
                if ($request->ID_REFERENCIAS_SELECCION == 0) {
                    // Crear un nuevo registro en la tabla `referenciaseleccionModel`
                    DB::statement('ALTER TABLE seleccion_referencias_laboral AUTO_INCREMENT=1;');
                    $vacante = referenciaseleccionModel::create($request->all());
                } else {
                    // Obtener el registro actual para conservar los valores antiguos
                    $vacante = referenciaseleccionModel::find($request->ID_REFERENCIAS_SELECCION);
            
                    // Actualizar el registro existente en lugar de eliminarlo
                    $vacante->update($request->all());
                }
            
                // Guardar o actualizar las referencias de las empresas
                if ($request->has('NOMBRE_EMPRESA')) {
                    foreach ($request->NOMBRE_EMPRESA as $index => $nombreEmpresa) {
                        $comentario = isset($request->COMENTARIO[$index]) ? $request->COMENTARIO[$index] : null;
            
                        $cumpleKey = "CUMPLE_" . ($index + 1);
                        $cumple = $request->input($cumpleKey) ?? null;
            
                        // Verificar si ya existe una referencia para actualizar
                        $referencia = referenciasempresasModel::where('SELECCION_REFERENCIA_ID', $vacante->ID_REFERENCIAS_SELECCION)
                            ->where('NOMBRE_EMPRESA', $nombreEmpresa)
                            ->first();
            
                        if ($referencia) {
                            // Mantener la ruta del archivo anterior si no se sube uno nuevo
                            $archivoAnterior = $referencia->ARCHIVO_RESULTADO;
            
                            // Verificar si se subió un nuevo archivo
                            if ($request->hasFile("ARCHIVO_RESULTADO.$index")) {
                                // Si ya existe un archivo para esta referencia, eliminar el anterior
                                if ($archivoAnterior) {
                                    Storage::delete($archivoAnterior);
                                }
            
                                // Generar la ruta de guardado del nuevo archivo
                                $curpFolder = 'reclutamiento/' . $request->CURP;
                                $referenciaFolder = $curpFolder . '/Referencias Laborales/';
            
                                if (!Storage::exists($curpFolder)) {
                                    Storage::makeDirectory($curpFolder);
                                }
            
                                if (!Storage::exists($referenciaFolder)) {
                                    Storage::makeDirectory($referenciaFolder);
                                }
            
                                // Guardar el nuevo archivo
                                $archivoFile = $request->file("ARCHIVO_RESULTADO.$index");
                                $archivoFileName = $nombreEmpresa . '_' . $request->CURP . '.' . $archivoFile->getClientOriginalExtension();
                                $archivoFile->storeAs($referenciaFolder, $archivoFileName);
            
                                // Actualizar el registro de la empresa con la nueva ruta del archivo
                                $referencia->ARCHIVO_RESULTADO = $referenciaFolder . $archivoFileName;
                            } else {
                                // Mantener el archivo anterior si no se subió uno nuevo
                                $referencia->ARCHIVO_RESULTADO = $archivoAnterior;
                            }
            
                            // Actualizar el resto de la referencia
                            $referencia->NOMBRE_EMPRESA = $nombreEmpresa;
                            $referencia->COMENTARIO = $comentario;
                            $referencia->CUMPLE = $cumple;
                            $referencia->save();
                        } else {
                            // Crear una nueva referencia si no existe
                            $referencia = referenciasempresasModel::create([
                                'SELECCION_REFERENCIA_ID' => $vacante->ID_REFERENCIAS_SELECCION,
                                'NOMBRE_EMPRESA' => $nombreEmpresa,
                                'COMENTARIO' => $comentario,
                                'CUMPLE' => $cumple,
                            ]);
            
                            // Manejar el archivo para la nueva referencia
                            if ($request->hasFile("ARCHIVO_RESULTADO.$index")) {
                                $curpFolder = 'reclutamiento/' . $request->CURP;
                                $referenciaFolder = $curpFolder . '/Referencias Laborales/';
            
                                if (!Storage::exists($curpFolder)) {
                                    Storage::makeDirectory($curpFolder);
                                }
            
                                if (!Storage::exists($referenciaFolder)) {
                                    Storage::makeDirectory($referenciaFolder);
                                }
            
                                // Guardar el nuevo archivo
                                $archivoFile = $request->file("ARCHIVO_RESULTADO.$index");
                                $archivoFileName = $nombreEmpresa . '_' . $request->CURP . '.' . $archivoFile->getClientOriginalExtension();
                                $archivoFile->storeAs($referenciaFolder, $archivoFileName);
            
                                // Actualizar el registro con la nueva ruta del archivo
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





