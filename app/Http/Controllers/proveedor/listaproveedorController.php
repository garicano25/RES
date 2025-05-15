<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\proveedor\altacontactos;
use App\Models\proveedor\catalogofuncionesproveedorModel;
use App\Models\proveedor\catalogotituloproveedorModel;
use App\Models\proveedor\catalogodocumentoproveedorModel;

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

        $documetoscatalogo = catalogodocumentoproveedorModel::all();

        return view('compras.listaproveedor.listaproveedores', compact('funcionesCuenta', 'titulosCuenta', 'documetoscatalogo'));
    }


    public function Tablalistaproveedores()
{
    try {
        $tabla = altaproveedorModel::get();

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

            // Botones comunes
            $btnVisualizar = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
            $btnEditar = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
            $btnEditarDisabled = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            $btnEliminarChecked = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" checked><span class="slider round"></span></label>';
            $btnEliminarUnchecked = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '"><span class="slider round"></span></label>';

            // Botones PDF por tipo
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

            // Armar botón de documentos según tipo
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

            // Botones generales según estado
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
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar ');
        }
    }


}
