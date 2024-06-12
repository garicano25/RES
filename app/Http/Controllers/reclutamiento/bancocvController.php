<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\reclutamiento\bancocvModel;

use DB;

class bancocvController extends Controller
{
    // public function Tablavacantes()
    // {
    //     try {
    //         $tabla = catalogovacantesModel::get();
    
    //         foreach ($tabla as $value) {
            
    //             // Botones
    //             $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-circle ELIMINAR"><i class="bi bi-power"></i></button>';
    //             $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-circle EDITAR"><i class="bi bi-pencil-square"></i></button>';
    //         }
    
    //         // Respuesta
    //         return response()->json([
    //             'data' => $tabla,
    //             'msj' => 'Información consultada correctamente'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'msj' => 'Error ' . $e->getMessage(),
    //             'data' => 0
    //         ]);
    //     }
    // }

    
    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_BANCO_CV == 0) {
                        DB::statement('ALTER TABLE formulario_bancocv AUTO_INCREMENT=1;');
                        $bancocvs = bancocvModel::create($request->all());
                    } else {
                        if (!isset($request->ELIMINAR)) {
                            $bancocvs = bancocvModel::find($request->ID_BANCO_CV);
                            $bancocvs->update($request->all());
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
