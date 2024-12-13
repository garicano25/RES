<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use App\Models\contratacion\contratacionModel;
use App\Models\contratacion\documentosoporteModel;
use App\Models\contratacion\contratosanexosModel;
use App\Models\contratacion\reciboscontratoModel;
use App\Models\contratacion\informacionmedicaModel;





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
        $tabla = contratacionModel::where('ACTIVO', 1)->get();

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
    


public function Tablacontratacion1()
{
    try {
        $tabla = contratacionModel::where('ACTIVO', 0)->get();

        foreach ($tabla as $value) {
            
         
        $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
        $value->BTN_ACTIVAR = '<label class="switch"><input type="checkbox" class="ACTIVAR"  data-id="' . $value->ID_FORMULARIO_CONTRATACION . '" ><span class="slider round"></span></label>';

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
    

public function verificarestadobloqueo(Request $request)
{
    $curp = $request->input('curpSeleccionada');

    if (!$curp) {
        return response()->json(['error' => 'CURP no proporcionada'], 400);
    }

    $registro = DB::table('formulario_contratacion')
        ->where('CURP', $curp)
        ->first();

    $bloqueodesactivado = $registro && $registro->ACTIVO == 0 ? 0 : 1;

    return response()->json(['bloqueodesactivado' => $bloqueodesactivado]);
}

public function activarColaborador(Request $request, $id)
{
    try {
        $colaborador = contratacionModel::findOrFail($id);

        if ($colaborador->ACTIVO == 1) {
            return response()->json([
                'msj' => 'El colaborador ya está activo',
                'status' => 'info'
            ]);
        }

        $colaborador->ACTIVO = 1;
        $colaborador->save();

        return response()->json([
            'msj' => 'El colaborador ha sido activado exitosamente',
            'status' => 'success'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error: ' . $e->getMessage(),
            'status' => 'error'
        ]);
    }
}



/////////////////////////////////////////// STEP 1  DATOS GENERALES //////////////////////////////////




public function mostrarfotocolaborador($colaborador_id)
{
    $foto = contratacionModel::findOrFail($colaborador_id);
    return Storage::response($foto->FOTO_USUARIO);
}


    

/////////////////////////////////////////// STEP 2 DOCUMENTOS DE SOPORTE //////////////////////////////////
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



public function obtenerguardados(Request $request)
{
    $curp = $request->input('CURP');
    $documentos = documentosoporteModel::where('CURP', $curp)
                  ->pluck('TIPO_DOCUMENTO')
                  ->toArray();

    return response()->json($documentos);
}



/////////////////////////////////////////// STEP 3  CONTRATOS Y ANEXOS //////////////////////////////////




public function Tablacontratosyanexos(Request $request)
{
    try {
        $curp = $request->get('curp');

        if (!$curp) {
            return response()->json([
                'msj' => 'CURP no proporcionada',
                'data' => []
            ], 400);
        }

        $tabla = DB::select("
            SELECT rec.*, cat.NOMBRE_CATEGORIA
            FROM contratos_anexos_contratacion rec
            LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = rec.NOMBRE_CARGO
            WHERE rec.CURP = ?
        ", [$curp]);

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-contratosyanexos" data-id="' . $value->ID_CONTRATOS_ANEXOS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-contratosyanexos" data-id="' . $value->ID_CONTRATOS_ANEXOS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                if ($value->TIPO_DOCUMENTO_CONTRATO == 3) {
                    $value->BTN_CONTRATO = '<button type="button" class="btn btn-success btn-custom rounded-pill informacion" id="contrato-' . $value->ID_CONTRATOS_ANEXOS . '"><i class="bi bi-eye"></i></button>';
                } else {
                    $value->BTN_CONTRATO = '<button type="button" class="btn btn-secondary btn-custom rounded-pill informacion" disabled><i class="bi bi-ban"></i></button>';
                }
            }
        }

        // Retornar respuesta JSON
        return response()->json([
            'data' => $tabla,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'msj' => 'Error: ' . $e->getMessage(),
            'data' => []
        ]);
    }
}



public function mostrarcontratosyanexos($id)
{
    $archivo = contratosanexosModel::findOrFail($id)->DOCUMENTO_CONTRATO;
    return Storage::response($archivo);
}





/////////////////////////////////////////// DOCUMENTOS DE CONTRATO //////////////////////////////////

// RECIBOS DE NOMINA 



public function Tablarecibonomina(Request $request)
{
    try {
        $contrato = $request->get('contrato');

        $tabla = reciboscontratoModel::where('CONTRATO_ID', $contrato)->get();


        // $tabla = documentosoporteModel::get();


        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-recibonomina" data-id="' . $value->ID_RECIBOS_NOMINA . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-recibonomina" data-id="' . $value->ID_RECIBOS_NOMINA . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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



public function mostrarecibosnomina($id)
{
    $archivo = reciboscontratoModel::findOrFail($id)->DOCUMENTO_RECIBO;
    return Storage::response($archivo);
}





/////////////////////////////////////////// STEP 4  CREACION DE CV´S  //////////////////////////////////






/////////////////////////////////////////// STORE //////////////////////////////////
public function store(Request $request)
{
    try {
        switch (intval($request->api)) {

             // STEP 1 DATOS GENERALES 

            case 1:
                if ($request->ID_FORMULARIO_CONTRATACION == 0) {

                    // Restablecer el auto_increment si es necesario
                    DB::statement('ALTER TABLE formulario_contratacion AUTO_INCREMENT=1;');
                
                    $data = $request->except(['FOTO_USUARIO', 'beneficiarios']);
                    $contratos = contratacionModel::create($data);
                
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
                        // Editar un contrato existente
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

                            $nombreArchivo =  preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO) . '.' . $documento->getClientOriginalExtension();

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

                                $nombreArchivo =  preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO) . '.' . $documento->getClientOriginalExtension();

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



                      // STEP 3 CONTRATOS Y ANEXOS 

                case 3:
                    if ($request->ID_CONTRATOS_ANEXOS == 0) {
                        DB::statement('ALTER TABLE contratos_anexos_contratacion AUTO_INCREMENT=1;');
                        $soportes = contratosanexosModel::create($request->except('DOCUMENTO_CONTRATO')); 

                        if ($request->hasFile('DOCUMENTO_CONTRATO')) {
                            $documento = $request->file('DOCUMENTO_CONTRATO');
                            $curp = $request->CURP;
                            $idDocumento = $soportes->ID_CONTRATOS_ANEXOS;

                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_CONTRATO) . '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de contratos y anexos/' . $idDocumento;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $soportes->DOCUMENTO_CONTRATO = $rutaCompleta;
                            $soportes->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $soportes = contratosanexosModel::where('ID_CONTRATOS_ANEXOS', $request['ID_CONTRATOS_ANEXOS'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Desactivada';
                            } else {
                                $soportes = contratosanexosModel::where('ID_CONTRATOS_ANEXOS', $request['ID_CONTRATOS_ANEXOS'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Activada';
                            }
                        } else {
                            $soportes = contratosanexosModel::find($request->ID_CONTRATOS_ANEXOS);
                            $soportes->update($request->except('DOCUMENTO_CONTRATO'));

                            if ($request->hasFile('DOCUMENTO_CONTRATO')) {
                                if ($soportes->DOCUMENTO_CONTRATO && Storage::exists($soportes->DOCUMENTO_CONTRATO)) {
                                    Storage::delete($soportes->DOCUMENTO_CONTRATO); 
                                }

                                $documento = $request->file('DOCUMENTO_CONTRATO');
                                $curp = $request->CURP;
                                $idDocumento = $soportes->ID_CONTRATOS_ANEXOS;

                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_CONTRATO) . '.' . $documento->getClientOriginalExtension();

                                $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de contratos y anexos/' . $idDocumento;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $soportes->DOCUMENTO_CONTRATO = $rutaCompleta;
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





                         // INFORMACION MEDICA

                         case 5:
                            if ($request->ID_INFORMACION_MEDICA == 0) {
                                DB::statement('ALTER TABLE informacion_medica_contrato AUTO_INCREMENT=1;');
                                $soportes = informacionmedicaModel::create($request->except('DOCUMENTO_INFORMACION_MEDICA')); 
                        
                                if ($request->hasFile('DOCUMENTO_INFORMACION_MEDICA')) {
                                    $documento = $request->file('DOCUMENTO_INFORMACION_MEDICA');
                                    $curp = $request->CURP;
                                    $idDocumento = $soportes->ID_INFORMACION_MEDICA;
                                    $contratoId = $soportes->CONTRATO_ID; 
                        
                                    $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_INFORMACION) . '.' . $documento->getClientOriginalExtension();
                        
                                    $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Información Medica/' . $idDocumento;
                                    $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                        
                                    $soportes->DOCUMENTO_INFORMACION_MEDICA = $rutaCompleta;
                                    $soportes->save();
                                }
                            } else {
                                if (isset($request->ELIMINAR)) {
                                    if ($request->ELIMINAR == 1) {
                                        $soportes = informacionmedicaModel::where('ID_INFORMACION_MEDICA', $request['ID_INFORMACION_MEDICA'])
                                            ->update(['ACTIVO' => 0]);
                                        $response['code'] = 1;
                                        $response['soporte'] = 'Desactivada';
                                    } else {
                                        $soportes = informacionmedicaModel::where('ID_INFORMACION_MEDICA', $request['ID_INFORMACION_MEDICA'])
                                            ->update(['ACTIVO' => 1]);
                                        $response['code'] = 1;
                                        $response['soporte'] = 'Activada';
                                    }
                                } else {
                                    $soportes = informacionmedicaModel::find($request->ID_INFORMACION_MEDICA);
                                    $soportes->update($request->except('DOCUMENTO_INFORMACION_MEDICA'));
                        
                                    if ($request->hasFile('DOCUMENTO_INFORMACION_MEDICA')) {
                                        if ($soportes->DOCUMENTO_INFORMACION_MEDICA && Storage::exists($soportes->DOCUMENTO_INFORMACION_MEDICA)) {
                                            Storage::delete($soportes->DOCUMENTO_INFORMACION_MEDICA); 
                                        }
                        
                                        $documento = $request->file('DOCUMENTO_INFORMACION_MEDICA');
                                        $curp = $request->CURP;
                                        $idDocumento = $soportes->ID_INFORMACION_MEDICA;
                                        $contratoId = $soportes->CONTRATO_ID; 
                        
                                        $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_INFORMACION) . '.' . $documento->getClientOriginalExtension();
                        
                                        $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Información Medica/' . $idDocumento;
                                        $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                        
                                        $soportes->DOCUMENTO_INFORMACION_MEDICA = $rutaCompleta;
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


                         // RECIBOS DE NOMINA  
                         case 8:
                            if ($request->ID_RECIBOS_NOMINA == 0) {
                                DB::statement('ALTER TABLE recibos_contrato AUTO_INCREMENT=1;');
                                $soportes = reciboscontratoModel::create($request->except('DOCUMENTO_RECIBO')); 
                        
                                if ($request->hasFile('DOCUMENTO_RECIBO')) {
                                    $documento = $request->file('DOCUMENTO_RECIBO');
                                    $curp = $request->CURP;
                                    $idDocumento = $soportes->ID_RECIBOS_NOMINA;
                                    $contratoId = $soportes->CONTRATO_ID; 
                        
                                    $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_RECIBO) . '.' . $documento->getClientOriginalExtension();
                        
                                    $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Recibos de nomina/' . $idDocumento;
                                    $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                        
                                    $soportes->DOCUMENTO_RECIBO = $rutaCompleta;
                                    $soportes->save();
                                }
                            } else {
                                if (isset($request->ELIMINAR)) {
                                    if ($request->ELIMINAR == 1) {
                                        $soportes = reciboscontratoModel::where('ID_RECIBOS_NOMINA', $request['ID_RECIBOS_NOMINA'])
                                            ->update(['ACTIVO' => 0]);
                                        $response['code'] = 1;
                                        $response['soporte'] = 'Desactivada';
                                    } else {
                                        $soportes = reciboscontratoModel::where('ID_RECIBOS_NOMINA', $request['ID_RECIBOS_NOMINA'])
                                            ->update(['ACTIVO' => 1]);
                                        $response['code'] = 1;
                                        $response['soporte'] = 'Activada';
                                    }
                                } else {
                                    $soportes = reciboscontratoModel::find($request->ID_RECIBOS_NOMINA);
                                    $soportes->update($request->except('DOCUMENTO_RECIBO'));
                        
                                    if ($request->hasFile('DOCUMENTO_RECIBO')) {
                                        if ($soportes->DOCUMENTO_RECIBO && Storage::exists($soportes->DOCUMENTO_RECIBO)) {
                                            Storage::delete($soportes->DOCUMENTO_RECIBO); 
                                        }
                        
                                        $documento = $request->file('DOCUMENTO_RECIBO');
                                        $curp = $request->CURP;
                                        $idDocumento = $soportes->ID_RECIBOS_NOMINA;
                                        $contratoId = $soportes->CONTRATO_ID; 
                        
                                        $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_RECIBO) . '.' . $documento->getClientOriginalExtension();
                        
                                        $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Recibos de nomina/' . $idDocumento;
                                        $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                        
                                        $soportes->DOCUMENTO_RECIBO = $rutaCompleta;
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
