<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


use App\Models\proveedor\altacontactos;
use App\Models\proveedor\catalogofuncionesproveedorModel;
use App\Models\proveedor\catalogotituloproveedorModel;
use App\Models\proveedor\catalogodocumentoproveedorModel;
use App\Models\proveedor\catalogoverificacionproveedorModel;


use App\Models\proveedor\altacertificacionModel;
use App\Models\proveedor\altacuentaModel;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\altareferenciasModel;
use App\Models\proveedor\altadocumentosModel;


use DB;


class listaproveedorController extends Controller
{
    public function index()
    {
        $funcionesCuenta = catalogofuncionesproveedorModel::all();
        $titulosCuenta = catalogotituloproveedorModel::where('ACTIVO', 1)->get();
        $documetoscatalogo = catalogodocumentoproveedorModel::where('ACTIVO', 1)->get();
        $verificacioncatalogo = catalogoverificacionproveedorModel::where('ACTIVO', 1)
            ->orderBy('NOMBRE_VERIFICACION')
            ->get();


        return view('compras.listaproveedor.listaproveedores', compact('funcionesCuenta', 'titulosCuenta', 'documetoscatalogo', 'verificacioncatalogo'));
    }



    public function Tablalistaproveedores()
    {
        try {
            $tabla = altaproveedorModel::select('*')->get();

            foreach ($tabla as $value) {

                if ((int) $value->VERIFICACION_SOLICITADA === 1) {
                    $value->ESTATUS_DATOS = '<span class="badge bg-success">Completo</span>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = ''; 
                    continue;
                }

                $mensajes = [];
                $rfc = $value->RFC_ALTA;
                $tipoPersona = $value->TIPO_PERSONA_ALTA;
                $tipoPersonaOpcion = $value->TIPO_PERSONA_OPCION;

                if (!DB::table('formulario_altacontactoproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Falta agregar contactos.';
                }

                if (!DB::table('formulario_altacuentaproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Falta agregar cuentas bancarias.';
                }

                if (!DB::table('formulario_altareferenciasproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Faltan agregar referencias comerciales.';
                }

                $documentosObligatorios = DB::table('catalogo_documentosproveedor')
                    ->where('ACTIVO', 1)
                    ->where('TIPO_DOCUMENTO', 1)
                    ->where(function ($q) use ($tipoPersona) {
                        $q->where('TIPO_PERSONA', $tipoPersona)
                            ->orWhere('TIPO_PERSONA', 3);
                    })
                    ->where(function ($q) use ($tipoPersonaOpcion) {
                        $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)
                            ->orWhere('TIPO_PERSONA_OPCION', 3);
                    })
                    ->get();

                $documentosSubidos = DB::table('formulario_altadocumentoproveedores')
                    ->where('RFC_PROVEEDOR', $rfc)
                    ->pluck('TIPO_DOCUMENTO_PROVEEDOR')
                    ->toArray();

                foreach ($documentosObligatorios as $doc) {
                    if (!in_array($doc->ID_CATALOGO_DOCUMENTOSPROVEEDOR, $documentosSubidos)) {
                        $mensajes[] = 'Falta el documento: ' . $doc->NOMBRE_DOCUMENTO;
                    }
                }

                $value->ESTATUS_DATOS = empty($mensajes)
                    ? '<span class="badge bg-success">Completo</span>'
                    : implode('<br>', array_map(fn($msg) => "<span class='text-danger'>$msg</span>", $mensajes));

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';

                $value->BTN_CORREO = empty($mensajes)
                    ? ''
                    : '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" data-id="' . $value->ID_FORMULARIO_ALTA . '"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
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



    public function enviarCorreoFaltantes($idFormularioAlta)
    {
        $proveedor = altaproveedorModel::findOrFail($idFormularioAlta);
        $rfc = $proveedor->RFC_ALTA;

      

        $correo = DB::table('formulario_altaproveedor')
            ->where('RFC_ALTA', $rfc)
            ->value('CORREO_DIRECTORIO');


        if (!$correo) {
            return response()->json(['status' => 'error', 'message' => 'No se encontró un correo asociado al proveedor.']);
        }

        $faltantes = [];

        if (!DB::table('formulario_altacontactoproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
            $faltantes[] = 'Falta agregar contactos.';
        }

        if (!DB::table('formulario_altacuentaproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
            $faltantes[] = 'Falta agregar cuentas bancarias.';
        }

        if (!DB::table('formulario_altareferenciasproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
            $faltantes[] = 'Faltan agregar referencias comerciales.';
        }

        $tipoPersona = $proveedor->TIPO_PERSONA_ALTA;
        $tipoPersonaOpcion = $proveedor->TIPO_PERSONA_OPCION;

        $documentosObligatorios = DB::table('catalogo_documentosproveedor')
            ->where('ACTIVO', 1)
            ->where('TIPO_DOCUMENTO', 1)
            ->where(function ($q) use ($tipoPersona) {
                $q->where('TIPO_PERSONA', $tipoPersona)->orWhere('TIPO_PERSONA', 3);
            })
            ->where(function ($q) use ($tipoPersonaOpcion) {
                $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)->orWhere('TIPO_PERSONA_OPCION', 3);
            })
            ->get();

        $documentosSubidos = DB::table('formulario_altadocumentoproveedores')
            ->where('RFC_PROVEEDOR', $rfc)
            ->pluck('TIPO_DOCUMENTO_PROVEEDOR')
            ->toArray();

        foreach ($documentosObligatorios as $doc) {
            if (!in_array($doc->ID_CATALOGO_DOCUMENTOSPROVEEDOR, $documentosSubidos)) {
                $faltantes[] = 'Falta el documento: ' . $doc->NOMBRE_DOCUMENTO;
            }
        }

        if (empty($faltantes)) {
            return response()->json(['status' => 'ok', 'message' => 'Proveedor completo. No se envió correo.']);
        }

        $hora = now()->format('H');
        $saludo = $hora < 12 ? 'Buenos días' : 'Buenas tardes';

        Mail::send('emails.faltantes_proveedor', [
            'saludo' => $saludo,
            'razonSocial' => $proveedor->RAZON_SOCIAL_ALTA,
            'faltantes' => $faltantes
        ], function ($message) use ($correo) {
            $message->to($correo)
                ->subject('ERP Results - Faltan datos en su registro');
        });

        return response()->json(['status' => 'success', 'message' => 'Correo enviado correctamente.']);
    }




    public function actualizarVerificacionSolicitada(Request $request)
    {
        $rfc = $request->input('rfc');

        if (!$rfc) {
            return response()->json(['success' => false, 'message' => 'RFC no proporcionado.'], 400);
        }

        try {
            $actualizado = DB::table('formulario_altaproveedor')
                ->where('RFC_ALTA', $rfc)
                ->update(['VERIFICACION_SOLICITADA' => 1]);

            if ($actualizado) {
                return response()->json(['success' => true, 'message' => 'Verificación solicitada correctamente.']);
            } else {
                return response()->json(['success' => false, 'message' => 'No se encontró proveedor con ese RFC.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }



    public function verificarEstadoVerificacion(Request $request)
    {
        $rfc = $request->input('rfc');

        if (!$rfc) {
            return response()->json(['success' => false, 'message' => 'RFC no proporcionado.'], 400);
        }

        try {
            $registro = DB::table('formulario_altaproveedor')
                ->select('VERIFICACION_SOLICITADA')
                ->where('RFC_ALTA', $rfc)
                ->first();

            if (!$registro) {
                return response()->json(['success' => false, 'message' => 'Proveedor no encontrado.'], 404);
            }

            if ((int)$registro->VERIFICACION_SOLICITADA === 1) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'No se ha solicitado la verificación.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }






    public function documentosProveedorAdmin($rfc)
    {
        $proveedor = altaproveedorModel::where('RFC_ALTA', $rfc)->first();

        if (!$proveedor) {
            return response()->json(['status' => 'error', 'message' => 'Proveedor no encontrado']);
        }

        $tipoProveedor = $proveedor->TIPO_PERSONA_ALTA;
        $tipoPersonaOpcion = $proveedor->TIPO_PERSONA_OPCION;

        $catalogo = catalogodocumentoproveedorModel::where('ACTIVO', 1)
            ->where(function ($q) use ($tipoProveedor) {
                $q->where('TIPO_PERSONA', $tipoProveedor)
                    ->orWhere('TIPO_PERSONA', 3);
            })
            ->where(function ($q) use ($tipoPersonaOpcion) {
                $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)
                    ->orWhere('TIPO_PERSONA_OPCION', 3);
            })
            ->get();

        $registrados = DB::table('formulario_altadocumentoproveedores')
            ->where('RFC_PROVEEDOR', $rfc)
            ->where('ACTIVO', 1)
            ->pluck('TIPO_DOCUMENTO_PROVEEDOR');

        return response()->json([
            'catalogo' => $catalogo,
            'registrados' => $registrados,
        ]);
    }




    // TABLA DE CUENTAS


    public function Tablacuentas(Request $request)
{
    try {
        $rfc = $request->get('rfc');

        $tabla = altacuentaModel::where('RFC_PROVEEDOR', $rfc)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-caratula" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" checked><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-caratula" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
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

// TABLA CONTACTOS


public function Tablacontactos(Request $request)
{
    try {
        $rfc = $request->get('rfc');

        $tabla = altacontactos::where('RFC_PROVEEDOR', $rfc)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONTACTOPROVEEDOR . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONTACTOPROVEEDOR . '" checked><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
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


// TABLA CERTIFICACION


public function Tablacertificaciones(Request $request)
{
    try {
        $rfc = $request->get('rfc');

        $tabla = altacertificacionModel::where('RFC_PROVEEDOR', $rfc)->get();

            foreach ($tabla as $value) {
                $value->BTN_EDITAR = '';
                $value->BTN_ELIMINAR = '';
                $value->BTN_VISUALIZAR = '';
                $value->BTN_DOCUMENTO = 'N/A';

                $btnVisualizar = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $btnEditar = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $btnEditarDisabled = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $btnEliminarChecked = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" checked><span class="slider round"></span></label>';
                $btnEliminarUnchecked = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '"><span class="slider round"></span></label>';

                $btnCertificacion = $value->DOCUMENTO_CERTIFICACION
                    ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-certificación" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver certificación"><i class="bi bi-filetype-pdf"></i></button>'
                    : '';

                $btnAcreditacion = $value->DOCUMENTO_ACREDITACION
                    ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-acreditacion" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver acreditación"><i class="bi bi-filetype-pdf"></i></button>'
                    : '';

                $btnAutorizacion = $value->DOCUMENTO_AUTORIZACION
                    ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-autorizacion" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver autorización"><i class="bi bi-filetype-pdf"></i></button>'
                    : '';

                $btnMembresia = $value->DOCUMENTO_MEMBRESIA
                    ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-membresia" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver membresía"><i class="bi bi-filetype-pdf"></i></button>'
                    : '';

                switch ($value->TIPO_DOCUMENTO) {
                    case 'Certificación':
                        $value->BTN_DOCUMENTO = $btnCertificacion ?: 'N/A';
                        break;
                    case 'Acreditación':
                        $botones = [];
                        if ($btnAcreditacion) {
                            $botones[] = '<div class="text-center"><small>Acreditación</small><br>' . $btnAcreditacion . '</div>';
                        }
                        if ($btnAutorizacion) {
                            $botones[] = '<div class="text-center"><small>Autorización</small><br>' . $btnAutorizacion . '</div>';
                        }
                        $value->BTN_DOCUMENTO = count($botones) ? implode('&nbsp;&nbsp;', $botones) : 'N/A';
                        break;

                    case 'Membresía':
                        $value->BTN_DOCUMENTO = $btnMembresia ?: 'N/A';
                        break;
                    default:
                        $value->BTN_DOCUMENTO = 'N/A';
                        break;
                }

                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = $btnVisualizar;
                    $value->BTN_ELIMINAR = $btnEliminarUnchecked;
                    $value->BTN_EDITAR = $btnEditarDisabled;
                } else {
                    $value->BTN_VISUALIZAR = $btnVisualizar;
                    $value->BTN_ELIMINAR = $btnEliminarChecked;
                    $value->BTN_EDITAR = $btnEditar;
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

// TABLA REFERENCIAS 


public function Tablareferencias(Request $request)
{
    try {
        $rfc = $request->get('rfc');

        $tabla = altareferenciasModel::where('RFC_PROVEEDOR', $rfc)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_REFERENCIASPROVEEDOR . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_REFERENCIASPROVEEDOR . '" checked><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
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



    // TABLA DOCUMENTOS DE SOPORTE


    public function Tabladocumentosoporteproveedores(Request $request)
    {
        try {
            $rfc = $request->get('rfc');

            $tabla = altadocumentosModel::where('RFC_PROVEEDOR', $rfc)->get();


            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
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









    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_ALTA == 0) {
                        DB::statement('ALTER TABLE formulario_altaproveedor AUTO_INCREMENT=1;');
                        $funciones = altaproveedorModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {

                                $funciones = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['funcion'] = 'Desactivada';
                            } else {
                                $funciones = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['funcion'] = 'Activada';
                            }
                        } else {
                            $funciones = altaproveedorModel::find($request->ID_FORMULARIO_ALTA);
                            $funciones->update($request->all());
                            $response['code'] = 1;
                            $response['funcion'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['funcion']  = $funciones;
                    return response()->json($response);
                    break;


                case 2:
                    $requestData = $request->all();
                    $rfc = $requestData['RFC_PROVEEDOR'] ?? null; 

                    if ($request->ID_FORMULARIO_CUENTAPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altacuentaproveedor AUTO_INCREMENT=1;');

                        $cuentas = altacuentaModel::create($requestData);

                        if ($request->hasFile('CARATULA_BANCARIA')) {
                            $file = $request->file('CARATULA_BANCARIA');
                            $folderPath = "proveedores/{$rfc}/Caratula de cuentas/{$cuentas->ID_FORMULARIO_CUENTAPROVEEDOR}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);

                            $cuentas->CARATULA_BANCARIA = $filePath;
                            $cuentas->save();
                        }
                    } else {
                        $cuentas = altacuentaModel::find($request->ID_FORMULARIO_CUENTAPROVEEDOR);

                        if (isset($request->ELIMINAR)) {
                            $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                            $cuentas->save();

                            $response['code'] = 1;
                            $response['cuenta'] = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                            return response()->json($response);
                        }

                        if ($request->hasFile('CARATULA_BANCARIA')) {
                            if ($cuentas->CARATULA_BANCARIA && Storage::exists($cuentas->CARATULA_BANCARIA)) {
                                Storage::delete($cuentas->CARATULA_BANCARIA);
                            }

                            $file = $request->file('CARATULA_BANCARIA');
                            $folderPath = "proveedores/{$rfc}/Caratula de cuentas/{$cuentas->ID_FORMULARIO_CUENTAPROVEEDOR}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);

                            $requestData['CARATULA_BANCARIA'] = $filePath;
                        }

                        $cuentas->update(collect($requestData)->except('RFC_PROVEEDOR')->toArray());

                        $response['code'] = 1;
                        $response['cuenta'] = 'Actualizada';
                        return response()->json($response);
                    }

                    $response['code']  = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);
                    break;



                case 3:

                    $requestData = $request->all();

                    if ($request->has('FUNCIONES_CUENTA') && is_array($request->FUNCIONES_CUENTA)) {
                        $requestData['FUNCIONES_CUENTA'] = json_encode($request->FUNCIONES_CUENTA);
                    } else {
                        $requestData['FUNCIONES_CUENTA'] = null;
                    }

                    $rfc = $request->RFC_PROVEEDOR ?? null;
                    $requestData['RFC_PROVEEDOR'] = $rfc;

                    if ($request->ID_FORMULARIO_CONTACTOPROVEEDOR == 0) {

                        DB::statement('ALTER TABLE formulario_altacontactoproveedor AUTO_INCREMENT = 1;');

                        $cuentas = altacontactos::create($requestData);

                        return response()->json([
                            'code' => 1,
                            'cuenta' => $cuentas
                        ]);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;

                            altacontactos::where('ID_FORMULARIO_CONTACTOPROVEEDOR', $request->ID_FORMULARIO_CONTACTOPROVEEDOR)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'cuenta' => ['status' => $estado == 0 ? 'Desactivada' : 'Activada']
                            ]);
                        }

                        $cuentas = altacontactos::find($request->ID_FORMULARIO_CONTACTOPROVEEDOR);

                        if (!$cuentas) {
                            return response()->json([
                                'code' => 0,
                                'error' => 'Formulario no encontrado.'
                            ], 404);
                        }

                        $requestData = $request->except('RFC_PROVEEDOR');

                        if ($request->has('FUNCIONES_CUENTA') && is_array($request->FUNCIONES_CUENTA)) {
                            $requestData['FUNCIONES_CUENTA'] = json_encode($request->FUNCIONES_CUENTA);
                        } else {
                            $requestData['FUNCIONES_CUENTA'] = null;
                        }

                        $cuentas->update($requestData);

                        return response()->json([
                            'code' => 1,
                            'cuenta' => $cuentas
                        ]);
                    }

                    break;


                case 4:

                    $rfc = $request->RFC_PROVEEDOR ?? null;

                    if (!$rfc) {
                        return response()->json([
                            'code' => 0,
                            'error' => 'RFC_PROVEEDOR es requerido.'
                        ], 400);
                    }

                    $requestData = collect($request->except([
                        'DOCUMENTO_CERTIFICACION',
                        'DOCUMENTO_ACREDITACION',
                        'DOCUMENTO_AUTORIZACION',
                        'DOCUMENTO_MEMBRESIA'
                    ]))->toArray();

                    $requestData['RFC_PROVEEDOR'] = $rfc;

                    if ($request->ID_FORMULARIO_CERTIFICACIONPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altacertificacionproveedor AUTO_INCREMENT=1;');

                        $yaExiste = altacertificacionModel::where('RFC_PROVEEDOR', $rfc)
                            ->whereNotNull('DOCUMENTO_ACREDITACION')
                            ->first();

                        if ($yaExiste && $request->hasFile('DOCUMENTO_AUTORIZACION') && !$request->hasFile('DOCUMENTO_ACREDITACION')) {
                            $cuentas = $yaExiste;
                        } else {
                            $cuentas = altacertificacionModel::create($requestData);
                            $cuentas->refresh();
                        }

                        $cuentas = $this->guardarArchivos($request, $cuentas, $rfc);
                    } else {
                        $cuentas = altacertificacionModel::find($request->ID_FORMULARIO_CERTIFICACIONPROVEEDOR);

                        if (!$cuentas) {
                            return response()->json([
                                'code' => 0,
                                'error' => 'Registro no encontrado.'
                            ], 404);
                        }

                        if (isset($request->ELIMINAR)) {
                            $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                            $cuentas->save();

                            return response()->json([
                                'code' => 1,
                                'cuenta' => $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada'
                            ]);
                        }

                        $cuentas = $this->guardarArchivos($request, $cuentas, $rfc);

                        $cuentas->update($requestData);

                        return response()->json([
                            'code' => 1,
                            'cuenta' => 'Actualizada'
                        ]);
                    }

                    return response()->json([
                        'code' => 1,
                        'cuenta' => $cuentas
                    ]);


                    break;


                case 5:

                    if ($request->ID_FORMULARIO_REFERENCIASPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altareferenciasproveedor AUTO_INCREMENT=1;');

                        $requestData = $request->all();

                        $rfc = $requestData['RFC_PROVEEDOR'] ?? null;

                        if (!$rfc) {
                            return response()->json([
                                'code' => 0,
                                'error' => 'RFC_PROVEEDOR es requerido.'
                            ], 400);
                        }

                        $requestData['RFC_PROVEEDOR'] = $rfc;

                        $cuentas = altareferenciasModel::create($requestData);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;

                            $cuentas = altareferenciasModel::where('ID_FORMULARIO_REFERENCIASPROVEEDOR', $request['ID_FORMULARIO_REFERENCIASPROVEEDOR'])
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['cuenta'] = $estado == 0 ? 'Desactivada' : 'Activada';
                        } else {
                            $cuentas = altareferenciasModel::find($request->ID_FORMULARIO_REFERENCIASPROVEEDOR);

                            if (!$cuentas) {
                                return response()->json([
                                    'code' => 0,
                                    'error' => 'Registro no encontrado.'
                                ], 404);
                            }

                            $cuentas->update($request->except('RFC_PROVEEDOR'));

                            $response['code'] = 1;
                            $response['cuenta'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    $response['code']  = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);

                    break;

                case 6:

                    if ($request->ID_FORMULARIO_DOCUMENTOSPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altadocumentoproveedores AUTO_INCREMENT=1;');

                        $requestData = $request->all();

                        $rfc = $requestData['RFC_PROVEEDOR'] ?? null;

                        if (!$rfc) {
                            return response()->json([
                                'code' => 0,
                                'error' => 'RFC_PROVEEDOR es requerido.'
                            ], 400);
                        }

                        $requestData['RFC_PROVEEDOR'] = $rfc;

                        $cuentas = altadocumentosModel::create($requestData);

                        if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                            $file = $request->file('DOCUMENTO_SOPORTE');
                            $folderPath = "proveedores/{$rfc}/Documento de soporte/{$cuentas->ID_FORMULARIO_DOCUMENTOSPROVEEDOR}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);

                            $cuentas->DOCUMENTO_SOPORTE = $filePath;
                            $cuentas->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;

                            $cuentas = altadocumentosModel::where('ID_FORMULARIO_DOCUMENTOSPROVEEDOR', $request['ID_FORMULARIO_DOCUMENTOSPROVEEDOR'])
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['cuenta'] = $estado == 0 ? 'Desactivada' : 'Activada';
                        } else {
                            $cuentas = altadocumentosModel::find($request->ID_FORMULARIO_DOCUMENTOSPROVEEDOR);

                            if (!$cuentas) {
                                return response()->json([
                                    'code' => 0,
                                    'error' => 'Registro no encontrado.'
                                ], 404);
                            }

                            $rfc = $request->RFC_PROVEEDOR ?? null;

                            if (!$rfc) {
                                return response()->json([
                                    'code' => 0,
                                    'error' => 'RFC_PROVEEDOR es requerido.'
                                ], 400);
                            }

                            $cuentas->update($request->except('RFC_PROVEEDOR'));

                            if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                                if ($cuentas->DOCUMENTO_SOPORTE && Storage::exists($cuentas->DOCUMENTO_SOPORTE)) {
                                    Storage::delete($cuentas->DOCUMENTO_SOPORTE);
                                }

                                $file = $request->file('DOCUMENTO_SOPORTE');
                                $folderPath = "proveedores/{$rfc}/Documento de soporte/{$cuentas->ID_FORMULARIO_DOCUMENTOSPROVEEDOR}";
                                $fileName = $file->getClientOriginalName();
                                $filePath = $file->storeAs($folderPath, $fileName);

                                $cuentas->DOCUMENTO_SOPORTE = $filePath;
                                $cuentas->save();
                            }

                            $response['code'] = 1;
                            $response['cuenta'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    $response['code']  = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);

                    break;


                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar ');
        }
    }




    private function guardarArchivos(Request $request, $cuentas, $rfc)
    {
        $documentos = [
            'DOCUMENTO_CERTIFICACION' => 'certificacion',
            'DOCUMENTO_ACREDITACION' => 'acreditacion',
            'DOCUMENTO_AUTORIZACION' => 'autorizacion',
            'DOCUMENTO_MEMBRESIA' => 'membresia',
        ];

        foreach ($documentos as $input => $carpeta) {
            if ($request->hasFile($input)) {
                if ($cuentas->$input && Storage::exists($cuentas->$input)) {
                    Storage::delete($cuentas->$input);
                }

                $file = $request->file($input);
                $folderPath = "proveedores/{$rfc}/{$cuentas->ID_FORMULARIO_CERTIFICACIONPROVEEDOR}/{$carpeta}";
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs($folderPath, $fileName);

                $cuentas->$input = $filePath;
            }
        }

        $cuentas->save();
        return $cuentas;
    }



}
