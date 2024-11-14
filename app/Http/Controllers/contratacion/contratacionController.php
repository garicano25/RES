<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Models\contratacion\contratacionModel;
use App\Models\contratacion\documentosoporteModel;




use DB;



class contratacionController extends Controller
{
    

    public function index()
    {
        $areas = DB::select("
        SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE, LUGAR_CATEGORIA AS LUGAR, PROPOSITO_CATEGORIA AS PROPOSITO, ES_LIDER_CATEGORIA AS LIDER
        FROM catalogo_categorias
        WHERE ACTIVO = 1
        ");




        return view('RH.contratacion.contratacion', compact('areas'));
    }



    
public function Tablacontratacion()
{
    try {
        $tabla = contratacionModel::get();

        foreach ($tabla as $value) {
            
         
                       $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                // $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
        
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
    

// STEP 1 DATOS GENERALES


public function mostrarfotocolaborador($colaborador_id)
{
    $foto = contratacionModel::findOrFail($colaborador_id);
    return Storage::response($foto->FOTO_USUARIO);
}


    

// STEP 2 DOCUMENTOS SOPORTE
public function Tabladocumentosoporte(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = documentosoporteModel::where('CURP', $curp)->get();


        // $tabla = documentosoporteModel::get();


        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_DOCUMENTO_SOPORTE . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_DOCUMENTO_SOPORTE . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';




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



public function mostrardocumentosoporte($id)
{
    $archivo = documentosoporteModel::findOrFail($id)->DOCUMENTO_SOPORTE;
    return Storage::response($archivo);
}





// STEP 3 
// STEP 4 
// STEP 5 
// STEP 6  
// STEP 7 
// STEP 8  






public function store(Request $request)
{
    try {
        switch (intval($request->api)) {

             // STEP 1 DATOS GENERALES 

            case 1:
                if ($request->ID_FORMULARIO_CONTRATACION == 0) {

                    DB::statement('ALTER TABLE formulario_contratacion AUTO_INCREMENT=1;');
                    $contratos = contratacionModel::create($request->except('FOTO_USUARIO')); 


                    $contratos = contratacionModel::create($request->except('beneficiarios'));


                    if ($request->hasFile('FOTO_USUARIO')) {
                        $imagen = $request->file('FOTO_USUARIO');
                        
                        $curp = $request->CURP;
                        $rutaCarpeta = 'reclutamiento/' . $curp . '/IMAGEN COLABORADOR';
                        $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                        
                        $rutaCompleta = $imagen->storeAs($rutaCarpeta, $nombreArchivo);
                        
                        $contratos->FOTO_USUARIO = $rutaCompleta;
                        $contratos->save();
                    }

                } else {

                    if (isset($request->ELIMINAR)) {
                        if ($request->ELIMINAR == 1) {
                            $contratos = contratacionModel::where('ID_FORMULARIO_CONTRATACION', $request['ID_FORMULARIO_CONTRATACION'])->update(['ACTIVO' => 0]);
                            $response['code'] = 1;
                            $response['contrato'] = 'Desactivada';
                        } else {
                            $contratos = contratacionModel::where('ID_FORMULARIO_CONTRATACION', $request['ID_FORMULARIO_CONTRATACION'])->update(['ACTIVO' => 1]);
                            $response['code'] = 1;
                            $response['contrato'] = 'Activada';
                        }
                    } else {
                        $contratos = contratacionModel::find($request->ID_FORMULARIO_CONTRATACION);
                        $contratos->update($request->except('FOTO_USUARIO'));

                        if ($request->hasFile('FOTO_USUARIO')) {
                            if ($contratos->FOTO_USUARIO && Storage::exists($contratos->FOTO_USUARIO)) {
                                Storage::delete($contratos->FOTO_USUARIO);
                            }

                            $imagen = $request->file('FOTO_USUARIO');
                            $curp = $request->CURP;
                            $rutaCarpeta = 'reclutamiento/' . $curp . '/IMAGEN COLABORADOR';
                            $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                            $rutaCompleta = $imagen->storeAs($rutaCarpeta, $nombreArchivo);

                            $contratos->FOTO_USUARIO = $rutaCompleta;
                            $contratos->save();
                        }

                        $response['code'] = 1;
                        $response['contrato'] = 'Actualizada';
                    }
                }

                $response['code'] = 1;
                $response['contrato'] = $contratos;
                return response()->json($response);
                break;


                // STEP 2 DOCUMENTOS SOPORTE

                case 2:
                    if ($request->ID_DOCUMENTO_SOPORTE == 0) {
                        DB::statement('ALTER TABLE documentos_soporte_contratacion AUTO_INCREMENT=1;');
                        $soportes = documentosoporteModel::create($request->except('DOCUMENTO_SOPORTE')); 

                        if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                            $documento = $request->file('DOCUMENTO_SOPORTE');
                            $curp = $request->CURP;
                            $idDocumento = $soportes->ID_DOCUMENTO_SOPORTE;

                            $nombreArchivo = preg_replace('/[^A-Za-z0-9\-]/', '_', $request->NOMBRE_DOCUMENTO) . '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de soporte/' . $idDocumento;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $soportes->DOCUMENTO_SOPORTE = $rutaCompleta;
                            $soportes->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $soportes = documentosoporteModel::where('ID_DOCUMENTO_SOPORTE', $request['ID_DOCUMENTO_SOPORTE'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Desactivada';
                            } else {
                                $soportes = documentosoporteModel::where('ID_DOCUMENTO_SOPORTE', $request['ID_DOCUMENTO_SOPORTE'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Activada';
                            }
                        } else {
                            $soportes = documentosoporteModel::find($request->ID_DOCUMENTO_SOPORTE);
                            $soportes->update($request->except('DOCUMENTO_SOPORTE'));

                            if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                                if ($soportes->DOCUMENTO_SOPORTE && Storage::exists($soportes->DOCUMENTO_SOPORTE)) {
                                    Storage::delete($soportes->DOCUMENTO_SOPORTE); 
                                }

                                $documento = $request->file('DOCUMENTO_SOPORTE');
                                $curp = $request->CURP;
                                $idDocumento = $soportes->ID_DOCUMENTO_SOPORTE;

                                $nombreArchivo = preg_replace('/[^A-Za-z0-9\-]/', '_', $request->NOMBRE_DOCUMENTO) . '.' . $documento->getClientOriginalExtension();

                                $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de soporte/' . $idDocumento;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $soportes->DOCUMENTO_SOPORTE = $rutaCompleta;
                                $soportes->save();
                            }

                            $response['code'] = 1;
                            $response['soporte'] = 'Actualizada';
                        }
                    }

                    $response['code'] = 1;
                    $response['soporte'] = $soportes;
                    return response()->json($response);
                    break;




                
                
                    


            default:
                $response['code'] = 1;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json('Error al guardar el contrato');
    }
}



}
