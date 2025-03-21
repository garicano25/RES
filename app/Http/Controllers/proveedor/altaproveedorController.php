<?php

namespace App\Http\Controllers\proveedor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB; 

use App\Models\proveedor\directorioModel;
use App\Models\proveedor\altaproveedorModel;

use App\Models\proveedor\altacontactos;

class altaproveedorController extends Controller
{
    public function obtenerDatosProveedor()
{
    $rfcProveedor = Auth::user()->RFC_PROVEEDOR;

    $proveedor = directorioModel::where('RFC_PROVEEDOR', $rfcProveedor)->first();

    if (!$proveedor) {
        return response()->json(['error' => 'No se encontraron datos'], 404);
    }

    return response()->json([
        'TIPO_PERSONA_ALTA' => $proveedor->TIPO_PERSONA,
        'RAZON_SOCIAL_ALTA' => $proveedor->RAZON_SOCIAL,
        'RFC_ALTA' => $proveedor->RFC_PROVEEDOR,
        'ACTVIDAD_COMERCIAL' => $proveedor->GIRO_PROVEEDOR,
        'CODIGO_POSTAL' => $proveedor->CODIGO_POSTAL,
        'TIPO_VIALIDAD_EMPRESA' => $proveedor->TIPO_VIALIDAD_EMPRESA,
        'NOMBRE_VIALIDAD_EMPRESA' => $proveedor->NOMBRE_VIALIDAD_EMPRESA,
        'NUMERO_EXTERIOR_EMPRESA' => $proveedor->NUMERO_EXTERIOR_EMPRESA,
        'NUMERO_INTERIOR_EMPRESA' => $proveedor->NUMERO_INTERIOR_EMPRESA,
        'NOMBRE_COLONIA_EMPRESA' => $proveedor->NOMBRE_COLONIA_EMPRESA,
        'NOMBRE_LOCALIDAD_EMPRESA' => $proveedor->NOMBRE_LOCALIDAD_EMPRESA,
        'NOMBRE_MUNICIPIO_EMPRESA' => $proveedor->NOMBRE_MUNICIPIO_EMPRESA,
        'NOMBRE_ENTIDAD_EMPRESA' => $proveedor->NOMBRE_ENTIDAD_EMPRESA,
        'PAIS_EMPRESA' => $proveedor->PAIS_EMPRESA,
        'ENTRE_CALLE_EMPRESA' => $proveedor->ENTRE_CALLE_EMPRESA,
        'ENTRE_CALLE2_EMPRESA' => $proveedor->ENTRE_CALLE2_EMPRESA,
        'DOMICILIO_EXTRANJERO' => $proveedor->DOMICILIO_EXTRANJERO,
        'CODIGO_EXTRANJERO' => $proveedor->CODIGO_EXTRANJERO,
        'CIUDAD_EXTRANJERO' => $proveedor->CIUDAD_EXTRANJERO,
        'ESTADO_EXTRANJERO' => $proveedor->ESTADO_EXTRANJERO,
        'PAIS_EXTRANJERO' => $proveedor->PAIS_EXTRANJERO,
        'DEPARTAMENTO_EXTRANJERO' => $proveedor->DEPARTAMENTO_EXTRANJERO
    ]);
}



    public function Tablacontactosproveedor()
    {
        try {
            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $tabla = altacontactos::where('RFC_PROVEEDOR', $userRFC)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
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
                        $altas = altaproveedorModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $altas = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['alta'] = 'Desactivada';
                            } else {
                                $altas = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['alta'] = 'Activada';
                            }
                        } else {
                            $altas = altaproveedorModel::find($request->ID_FORMULARIO_ALTA);
                            $altas->update($request->all());
                            $response['code'] = 1;
                            $response['alta'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['alta']  = $altas;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar');
        }
    }
}
