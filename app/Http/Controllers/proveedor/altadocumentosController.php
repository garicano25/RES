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

use App\Models\proveedor\altadocumentosModel;
use App\Models\proveedor\catalogodocumentoproveedorModel;

class altadocumentosController extends Controller
{


    public function index()
    {
        $documetoscatalogo = catalogodocumentoproveedorModel::all();

        return view('compras.proveedores.altadocumentosoporte', compact('documetoscatalogo'));
    }


    public function Tabladocumentosproveedores()
    {
        try {
            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $tabla = altadocumentosModel::where('RFC_PROVEEDOR', $userRFC)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-caratula" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-caratula" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
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
                    if ($request->ID_FORMULARIO_DOCUMENTOSPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altadocumentoproveedores AUTO_INCREMENT=1;');

                        $requestData = $request->all();
                        $requestData['RFC_PROVEEDOR'] = Auth::user()->RFC_PROVEEDOR;

                        $cuentas = altadocumentosModel::create($requestData);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $cuentas = altadocumentosModel::where('ID_FORMULARIO_DOCUMENTOSPROVEEDOR', $request['ID_FORMULARIO_DOCUMENTOSPROVEEDOR'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['cuenta'] = 'Desactivada';
                            } else {
                                $cuentas = altadocumentosModel::where('ID_FORMULARIO_DOCUMENTOSPROVEEDOR', $request['ID_FORMULARIO_DOCUMENTOSPROVEEDOR'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['cuenta'] = 'Activada';
                            }
                        } else {
                            $cuentas = altadocumentosModel::find($request->ID_FORMULARIO_DOCUMENTOSPROVEEDOR);
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
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'API no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar'], 500);
        }
    }


}
