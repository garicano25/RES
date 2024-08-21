<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Models\reclutamiento\bancocvModel;
use App\Models\reclutamiento\catalogovacantesModel;
use App\Models\reclutamiento\requerimientoModel;
use App\Models\organizacion\catalogogeneroModel;
use App\Models\organizacion\cataloareainteresModel;



use DB;

class bancocvController extends Controller
{


public function index()
{
    $vacantes = catalogovacantesModel::where('LA_VACANTES_ES', 'Privada')->get();
    $generos = catalogogeneroModel::where('ACTIVO', 1)->get();
    $administrativas = cataloareainteresModel::where('TIPO_AREA', 1)->get();
    $operativas = cataloareainteresModel::where('TIPO_AREA', 2)->get();

    return view('RH.reclutamiento.reclutamiento', compact('vacantes','generos','administrativas','operativas'));
}


public function index1()
{
    $generos = catalogogeneroModel::where('ACTIVO', 1)->get();

    

    $administrativas = cataloareainteresModel::where('TIPO_AREA', 1)->get();
    $operativas = cataloareainteresModel::where('TIPO_AREA', 2)->get();


    return view('RH.reclutamiento.formulario_bancocv', compact('generos','administrativas','operativas'));
}



public function Tablabancocv()
{
    try {
        $tabla = bancocvModel::get();

        foreach ($tabla as $value) {
        
            // Botones
            $value->BTN_ELIMINAR = '<button type="button" class="btn btn-danger btn-custom rounded-pill ELIMINAR"><i class="bi bi-trash3-fill"></i></button>';
            $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye-fill"></i></button>';
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



public function Tablapostulaciones()
{
    try {
        // Se modifica la consulta SQL para incluir el conteo de postulantes por vacante
        $tabla = DB::select("
            SELECT vac.*, 
                    cat.NOMBRE_CATEGORIA, 
                    (SELECT COUNT(lp.VACANTES_ID) 
                    FROM lista_postulantes lp 
                    WHERE lp.VACANTES_ID = vac.ID_CATALOGO_VACANTE) AS TOTAL_POSTULANTES
            FROM catalogo_vacantes vac
            LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
            WHERE vac.ACTIVO = 1
        ");

        foreach ($tabla as $value) {
            $value->REQUERIMIENTO = requerimientoModel::where('CATALOGO_VACANTES_ID', $value->ID_CATALOGO_VACANTE)->get();

            // Se asignan botones según el estado ACTIVO ya filtrado
            $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar registro"><i class="bi bi-eye"></i></button>';

            // Crear el botón para TOTAL_POSTULANTES
            $value->TOTAL_POSTULANTES = '<button type="button" class="btn btn-info btn-custom rounded-pill TOTAL_POSTULANTES" onclick="TotalPostulantes(' . $value->ID_CATALOGO_VACANTE . ')">' . $value->TOTAL_POSTULANTES . '</button>';
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
    





public function informacionpostulantes($idVacante)
{
    try {
        // Consulta para obtener los datos únicos de los postulantes
        $postulantes = DB::select("
            SELECT 
                fb.NOMBRE_CV,
                fb.PRIMER_APELLIDO_CV,
                fb.SEGUNDO_APELLIDO_CV,
                fb.CURP_CV,
                fb.CORREO_CV,
                fb.TELEFONO1,
                fb.TELEFONO2,
                fb.ARCHIVO_CV,
                lp.VACANTES_ID
            FROM lista_postulantes lp
            LEFT JOIN formulario_bancocv fb ON lp.CURP = fb.CURP_CV
            WHERE lp.VACANTES_ID = ?
            GROUP BY fb.CURP_CV, lp.VACANTES_ID, fb.NOMBRE_CV, fb.PRIMER_APELLIDO_CV, fb.SEGUNDO_APELLIDO_CV, fb.CORREO_CV, fb.TELEFONO1, fb.TELEFONO2, fb.ARCHIVO_CV
        ", [$idVacante]);

        $requerimientos = DB::select("
            SELECT 
                rv.NOMBRE_REQUERIMINETO
            FROM requerimientos_vacantes rv
            WHERE rv.CATALOGO_VACANTES_ID = ?
        ", [$idVacante]);

        return response()->json([
            'postulantes' => $postulantes,
            'requerimientos' => $requerimientos,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}

public function getCV($filename)
{
    $path = storage_path('app/Reclutamiento/CV/' . $filename . '.pdf');  // Asumiendo que los archivos tienen extensión .pdf

    if (!file_exists($path)) {
        abort(404, 'El archivo no fue encontrado.');
    }

    return response()->file($path);
}







    
public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:
                if ($request->ID_BANCO_CV == 0) {

                    $interes_admon = $request->INTERES_ADMINISTRATIVA ? $request->INTERES_ADMINISTRATIVA : [];
                    $interes_ope = $request->INTERES_OPERATIVAS ? $request->INTERES_OPERATIVAS : [];

                    // DB::statement('ALTER TABLE formulario_bancocv AUTO_INCREMENT=1;');
                    // $bancocvs = bancocvModel::create($request->all());

                    DB::statement('ALTER TABLE formulario_bancocv AUTO_INCREMENT=1;');
                    $bancocvs = bancocvModel::create(array_merge($request->all(), [
                        'INTERES_ADMINISTRATIVA' => $interes_admon,
                        'INTERES_OPERATIVAS' => $interes_ope,
                    ])); 



                } else {

                    
                    if (!isset($request->ELIMINAR)) {


                        // $bancocvs = bancocvModel::find($request->ID_BANCO_CV);

                        // $bancocvs->update($request->all());


                        $DPT = bancocvModel::find($request->ID_BANCO_CV);

                        $interes_admon = $request->INTERES_ADMINISTRATIVA ? $request->INTERES_ADMINISTRATIVA : [];
                        $interes_ope = $request->INTERES_OPERATIVAS ? $request->INTERES_OPERATIVAS : [];
                        
                        $DPT->update(array_merge($request->all(), [
                            'INTERES_ADMINISTRATIVA' => $interes_admon,
                            'INTERES_OPERATIVAS' => $interes_ope,
                        ]));
                        

                    } else {


                        $bancocvs = bancocvModel::where('ID_BANCO_CV', $request->ID_BANCO_CV)->delete();
                        $response['code']  = 1;
                        $response['bancocv']  = 'Eliminada';
                        return response()->json($response);
                    }
                }

                // Guardar el archivo CURP
                if ($request->hasFile('ARCHIVO_CURP_CV')) {
                    $curpFile = $request->file('ARCHIVO_CURP_CV');
                    $curpFileName = $request->CURP_CV . '.' . $curpFile->getClientOriginalExtension();
                    $curpFilePath = 'reclutamiento/CURP/' . $curpFileName;
                    $curpFile->storeAs('reclutamiento/CURP', $curpFileName);
                    $bancocvs->ARCHIVO_CURP_CV = $curpFilePath;
                }

                // Guardar el archivo CV
                if ($request->hasFile('ARCHIVO_CV')) {
                    $cvFile = $request->file('ARCHIVO_CV');
                    $cvFileName = $request->CURP_CV . '.' . $cvFile->getClientOriginalExtension();
                    $cvFilePath = 'reclutamiento/CV/' . $cvFileName;
                    $cvFile->storeAs('reclutamiento/CV', $cvFileName);
                    $bancocvs->ARCHIVO_CV = $cvFilePath;
                }

                $bancocvs->save();

                $response['code']  = 1;
                $response['bancocv']  = $bancocvs;
                return response()->json($response);
                break;
            default:
                $response['code']  = 0;
                $response['msj']  = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json(['code' => 0, 'msj' => 'Error al guardar la información', 'error' => $e->getMessage()]);
    }
}
    
}
