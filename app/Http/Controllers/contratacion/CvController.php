<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;


use App\Models\contratacion\cvModel;



use DB;

class CvController extends Controller
{





      
// public function store(Request $request)
// {
//     try {
//         switch (intval($request->api)) {
//             case 1:
//                 if ($request->ID_CV_CONTRATACION == 0) {
//                     DB::statement('ALTER TABLE cv_contratacion AUTO_INCREMENT=1;');
//                     $cvs = cvModel::create($request->all());
//                 } else { 

//                     if (isset($request->ELIMINAR)) {
//                         if ($request->ELIMINAR == 1) {
//                             $cvs = cvModel::where('ID_CV_CONTRATACION', $request['ID_CV_CONTRATACION'])->update(['ACTIVO' => 0]);
//                             $response['code'] = 1;
//                             $response['cv'] = 'Desactivada';
//                         } else {
//                             $cvs = cvModel::where('ID_CV_CONTRATACION', $request['ID_CV_CONTRATACION'])->update(['ACTIVO' => 1]);
//                             $response['code'] = 1;
//                             $response['cv'] = 'Activada';
//                         }
//                     } else {
//                         $cvs = cvModel::find($request->ID_CV_CONTRATACION);
//                         $cvs->update($request->all());
//                         $response['code'] = 1;
//                         $response['cv'] = 'Actualizada';
//                     }
//                     return response()->json($response);

//                 }
//                 $response['code']  = 1;
//                 $response['cv']  = $cvs;
//                 return response()->json($response);
//                 break;
//             default:
//                 $response['code']  = 1;
//                 $response['msj']  = 'Api no encontrada';
//                 return response()->json($response);
//         }
//     } catch (Exception $e) {
//         return response()->json('Error al guardar el cv');
//     }
// }




public function store(Request $request)
{
    try {
        DB::beginTransaction();
        $curp = $request->CURP;

        switch (intval($request->api)) {
            case 1:
                if ($request->ID_CV_CONTRATACION == 0) {
                    // Crear un nuevo registro
                    DB::statement('ALTER TABLE cv_contratacion AUTO_INCREMENT=1;');
                    $cv = cvModel::create($request->all());

                    // Procesar datos adicionales
                    $this->guardarDatosAdicionales($cv, $request, $curp);
                } else {
                    // Actualizar registro existente
                    $cv = cvModel::find($request->ID_CV_CONTRATACION);

                    if (isset($request->ELIMINAR)) {
                        $cv->update(['ACTIVO' => $request->ELIMINAR == 1 ? 0 : 1]);
                        $mensaje = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                        DB::commit();
                        return response()->json(['code' => 1, 'cv' => $mensaje]);
                    }

                    $cv->update($request->all());
                    $this->guardarDatosAdicionales($cv, $request, $curp);
                }

                DB::commit();
                return response()->json(['code' => 1, 'cv' => $cv]);
                break;

            default:
                return response()->json(['code' => 1, 'msj' => 'Api no encontrada']);
        }
    } catch (Exception $e) {
        DB::rollBack();
        return response()->json(['code' => 0, 'msj' => 'Error al guardar el CV', 'error' => $e->getMessage()]);
    }
}

/**
 * Guardar datos adicionales, incluyendo documentos y arreglos
 */
private function guardarDatosAdicionales($cv, $request, $curp)
{
    // Guardar foto
    if ($request->hasFile('FOTO_CV')) {
        $imagen = $request->file('FOTO_CV');
        $rutaCarpeta = 'reclutamiento/' . $curp . '/documentos CV/foto_usuario';
        $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
        $rutaCompleta = $imagen->storeAs($rutaCarpeta, $nombreArchivo);
        $cv->FOTO_CV = $rutaCompleta;
        $cv->save();
    }

    // Guardar documentos específicos
    if ($request->hasFile('DOCUMENTO_CEDULA_CV')) {
        $documentoCedula = $request->file('DOCUMENTO_CEDULA_CV');
        $rutaCarpeta = 'reclutamiento/' . $curp . '/documentos CV/Documentos Cedula/Cedula';
        $nombreArchivo = 'cedula_' . uniqid() . '.' . $documentoCedula->getClientOriginalExtension();
        $cv->DOCUMENTO_CEDULA_CV = $documentoCedula->storeAs($rutaCarpeta, $nombreArchivo);
        $cv->save();
    }

    if ($request->hasFile('DOCUMENTO_VALCEDULA_CV')) {
        $documentoValCedula = $request->file('DOCUMENTO_VALCEDULA_CV');
        $rutaCarpeta = 'reclutamiento/' . $curp . '/documentos CV/Documentos Cedula/Validacion Cedula';
        $nombreArchivo = 'validacion_cedula_' . uniqid() . '.' . $documentoValCedula->getClientOriginalExtension();
        $cv->DOCUMENTO_VALCEDULA_CV = $documentoValCedula->storeAs($rutaCarpeta, $nombreArchivo);
        $cv->save();
    }

    // Guardar formación académica como JSON
    if ($request->has('FORMACION_ACADEMICA_CV')) {
        $formacionAcademica = collect($request->FORMACION_ACADEMICA_CV)->map(function ($item) use ($request) {
            $item['ACTIVO'] = isset($request->ACTIVO_FORMACION[$item['ID']]) ? 1 : 0;
            return $item;
        })->toArray();
        $cv->FORMACION_ACADEMICA_CV = json_encode($formacionAcademica);
        $cv->save();
    }

    // Guardar experiencia laboral como JSON
    if ($request->has('EXPERIENCIA_LABORAL_CV')) {
        $experienciaLaboral = collect($request->EXPERIENCIA_LABORAL_CV)->map(function ($item) use ($curp, $request) {
            if (isset($item['DOCUMENTO']) && $item['DOCUMENTO']->isValid()) {
                $rutaCarpeta = 'reclutamiento/' . $curp . '/documentos CV/Documentos experiencia laboral';
                $nombreArchivo = 'experiencia_' . uniqid() . '.' . $item['DOCUMENTO']->getClientOriginalExtension();
                $item['DOCUMENTO'] = $item['DOCUMENTO']->storeAs($rutaCarpeta, $nombreArchivo);
            }
            $item['ACTIVO'] = isset($request->ACTIVO_EXPERIENCIA[$item['ID']]) ? 1 : 0;
            return $item;
        })->toArray();
        $cv->EXPERIENCIA_LABORAL_CV = json_encode($experienciaLaboral);
        $cv->save();
    }

    // Guardar educación continua como JSON
    if ($request->has('EDUCACION_CONTINUA_CV')) {
        $educacionContinua = collect($request->EDUCACION_CONTINUA_CV)->map(function ($item) use ($curp, $request) {
            if (isset($item['DOCUMENTO']) && $item['DOCUMENTO']->isValid()) {
                $rutaCarpeta = 'reclutamiento/' . $curp . '/documentos CV/Documentos educacion continua';
                $nombreArchivo = 'educacion_' . uniqid() . '.' . $item['DOCUMENTO']->getClientOriginalExtension();
                $item['DOCUMENTO'] = $item['DOCUMENTO']->storeAs($rutaCarpeta, $nombreArchivo);
            }
            $item['ACTIVO'] = isset($request->ACTIVO_CONTINUA[$item['ID']]) ? 1 : 0;
            return $item;
        })->toArray();
        $cv->EDUCACION_CONTINUA_CV = json_encode($educacionContinua);
        $cv->save();
    }
}




}
