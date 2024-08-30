<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\organizacion\catalogogeneroModel;
use App\Models\organizacion\cataloareainteresModel;
use App\Models\reclutamiento\bancocvModel;
use App\Models\reclutamiento\listapostulacionesModel;


use DB;

class PuestoController extends Controller
{


    public function index()
    {
        $today = now()->toDateString(); 
    

        $vacantes = DB::select("SELECT vac.*, cat.NOMBRE_CATEGORIA
                                FROM catalogo_vacantes vac
                                LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
                                WHERE vac.LA_VACANTES_ES = 'Pública' 
                                AND vac.FECHA_EXPIRACION > ? 
                                AND vac.ACTIVO = 1", [$today]);
    
        foreach ($vacantes as $vacante) {

            $requerimientos = DB::table('requerimientos_vacantes')
                                ->where('CATALOGO_VACANTES_ID', $vacante->ID_CATALOGO_VACANTE)
                                ->pluck('NOMBRE_REQUERIMINETO');
    
            $vacante->requerimientos = $requerimientos;
        }
    
        $generos = catalogogeneroModel::where('ACTIVO', 1)->get();
    
        $administrativas = cataloareainteresModel::where('TIPO_AREA', 1)->get();
        $operativas = cataloareainteresModel::where('TIPO_AREA', 2)->get();
    
        return view('RH.reclutamiento.VacantesExterna', compact('vacantes', 'generos', 'administrativas', 'operativas'));
    }
    
    
public function getCvInfo(Request $request)
{
    $curp = $request->input('curp');
    $cvInfo = bancocvModel::where('CURP_CV', $curp)->first();

    if ($cvInfo) {
        return response()->json($cvInfo);
    } else {
        return response()->json(['message' => 'No se encontró la CURP.'], 404);
    }
}



// public function store(Request $request)
// {
//     try {
//         switch (intval($request->api)) {
//             case 1:
//                 $bancocvs = bancocvModel::where('CURP_CV', $request->CURP_CV)->first();

//                 if ($bancocvs) {
//                     $interes_admon = $request->INTERES_ADMINISTRATIVA ? $request->INTERES_ADMINISTRATIVA : $bancocvs->INTERES_ADMINISTRATIVA;
//                     $interes_ope = $request->INTERES_OPERATIVAS ? $request->INTERES_OPERATIVAS : $bancocvs->INTERES_OPERATIVAS;

//                     $bancocvs->update(array_merge($bancocvs->toArray(), $request->except(['ARCHIVO_CURP_CV', 'ARCHIVO_CV']), [
//                         'INTERES_ADMINISTRATIVA' => $interes_admon,
//                         'INTERES_OPERATIVAS' => $interes_ope,
//                     ]));

//                     if ($request->hasFile('ARCHIVO_CURP_CV')) {
//                         $curpFile = $request->file('ARCHIVO_CURP_CV');
//                         $curpFileName = $request->CURP_CV . '.' . $curpFile->getClientOriginalExtension();
//                         $curpFilePath = 'reclutamiento/CURP/' . $curpFileName;
//                         $curpFile->storeAs('reclutamiento/CURP', $curpFileName);
//                         $bancocvs->ARCHIVO_CURP_CV = $curpFilePath;
//                     }

//                     if ($request->hasFile('ARCHIVO_CV')) {
//                         $cvFile = $request->file('ARCHIVO_CV');
//                         $cvFileName = $request->CURP_CV . '.' . $cvFile->getClientOriginalExtension();
//                         $cvFilePath = 'reclutamiento/CV/' . $cvFileName;
//                         $cvFile->storeAs('reclutamiento/CV', $cvFileName);
//                         $bancocvs->ARCHIVO_CV = $cvFilePath;
//                     }

//                     $bancocvs->save();

//                     listapostulacionesModel::create([
//                         'VACANTES_ID' => $request->VACANTES_ID,
//                         'CURP' => $request->CURP_CV,
//                     ]);

//                     $response['code'] = 1;
//                     $response['bancocv'] = $bancocvs;
//                     return response()->json($response);
//                 } else {
//                     $response['code'] = 0;
//                     $response['msj'] = 'No se encontró un registro con esa CURP';
//                     return response()->json($response);
//                 }

//             default:
//                 $response['code'] = 0;
//                 $response['msj'] = 'Api no encontrada';
//                 return response()->json($response);
//         }
//     } catch (Exception $e) {
//         return response()->json(['code' => 0, 'msj' => 'Error al actualizar la información', 'error' => $e->getMessage()]);
//     }
// }


    public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:
                // Lógica existente para la API 1
                $bancocvs = bancocvModel::where('CURP_CV', $request->CURP_CV)->first();

                if ($bancocvs) {
                    $interes_admon = $request->INTERES_ADMINISTRATIVA ? $request->INTERES_ADMINISTRATIVA : $bancocvs->INTERES_ADMINISTRATIVA;
                    $interes_ope = $request->INTERES_OPERATIVAS ? $request->INTERES_OPERATIVAS : $bancocvs->INTERES_OPERATIVAS;

                    $bancocvs->update(array_merge($bancocvs->toArray(), $request->except(['ARCHIVO_CURP_CV', 'ARCHIVO_CV']), [
                        'INTERES_ADMINISTRATIVA' => $interes_admon,
                        'INTERES_OPERATIVAS' => $interes_ope,
                    ]));

                    if ($request->hasFile('ARCHIVO_CURP_CV')) {
                        $curpFile = $request->file('ARCHIVO_CURP_CV');
                        $curpFileName = $request->CURP_CV . '.' . $curpFile->getClientOriginalExtension();
                        $curpFilePath = 'reclutamiento/CURP/' . $curpFileName;
                        $curpFile->storeAs('reclutamiento/CURP', $curpFileName);
                        $bancocvs->ARCHIVO_CURP_CV = $curpFilePath;
                    }

                    if ($request->hasFile('ARCHIVO_CV')) {
                        $cvFile = $request->file('ARCHIVO_CV');
                        $cvFileName = $request->CURP_CV . '.' . $cvFile->getClientOriginalExtension();
                        $cvFilePath = 'reclutamiento/CV/' . $cvFileName;
                        $cvFile->storeAs('reclutamiento/CV', $cvFileName);
                        $bancocvs->ARCHIVO_CV = $cvFilePath;
                    }

                    $bancocvs->save();

                    listapostulacionesModel::create([
                        'VACANTES_ID' => $request->VACANTES_ID,
                        'CURP' => $request->CURP_CV,
                    ]);

                    $response['code'] = 1;
                    $response['bancocv'] = $bancocvs;
                    return response()->json($response);
                } else {
                    $response['code'] = 0;
                    $response['msj'] = 'No se encontró un registro con esa CURP';
                    return response()->json($response);
                }
            
            case 2:
                // Nueva lógica para la API 2
                $curp = $request->CURP_CV;
                $vacantesId = $request->VACANTES_ID;

                // Guardar la postulación en la tabla lista_postulantes
                listapostulacionesModel::create([
                    'VACANTES_ID' => $vacantesId,
                    'CURP' => $curp,
                    'ACTIVO' => 1 // Suponiendo que ACTIVO es un campo booleano para activar la postulación
                ]);

                $response['code'] = 1;
                $response['msj'] = 'Postulación registrada correctamente';
                return response()->json($response);

            default:
                $response['code'] = 0;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json(['code' => 0, 'msj' => 'Error al realizar la postulación', 'error' => $e->getMessage()]);
    }
}


}
