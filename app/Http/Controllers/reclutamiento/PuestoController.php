<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\reclutamiento\catalogovacantesModel;
use App\Models\organizacion\catalogogeneroModel;
use App\Models\organizacion\cataloareainteresModel;
use App\Models\reclutamiento\bancocvModel;

use DB;

class PuestoController extends Controller
{


    public function index()
    {
        $today = now()->toDateString(); 
    
        $vacantes = catalogovacantesModel::where('LA_VACANTES_ES', 'Pública')
                                         ->whereDate('FECHA_EXPIRACION', '>', $today)
                                         ->where('ACTIVO', 1)  
                                         ->get();
    
        foreach ($vacantes as $vacante) {
            $requerimientos = DB::table('requerimientos_vacantes')
                                ->where('CATALOGO_VACANTES_ID', $vacante->ID_CATALOGO_VACANTE)
                                ->pluck('NOMBRE_REQUERIMINETO');
    
            $vacante->requerimientos = $requerimientos;
        }
    


        $generos = catalogogeneroModel::where('ACTIVO', 1)->get();

        

        $administrativas = cataloareainteresModel::where('TIPO_AREA', 1)->get();
        $operativas = cataloareainteresModel::where('TIPO_AREA', 2)->get();



        return view('RH.reclutamiento.VacantesExterna', compact('vacantes','generos','administrativas','operativas'));
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


public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:

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

                    $response['code']  = 1;
                    $response['bancocv']  = $bancocvs;
                    return response()->json($response);
                } else {
                    
                    $response['code']  = 0;
                    $response['msj']  = 'No se encontró un registro con esa CURP';
                    return response()->json($response);
                }

            default:
                $response['code']  = 0;
                $response['msj']  = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json(['code' => 0, 'msj' => 'Error al actualizar la información', 'error' => $e->getMessage()]);
    }
}


    

}
