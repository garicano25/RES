<?php

namespace App\Http\Controllers\matrizcomparativa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\matrizcomparativa\matrizModel;


use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;

class matrizController extends Controller
{



    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.ordencompra.matrizcomparativa', compact('proveedoresOficiales', 'proveedoresTemporales'));


    }



    public function index1()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.ordencompra.aprobacionmatriz', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }


    public function Tablamatrizcomparativa()
    {
        try {
            $tabla = matrizModel::get();

            foreach ($tabla as $value) {
                // BOTONES
                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                // BADGE DE ESTADO
                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->ESTADO_BADGE = '<span class="badge bg-success">Aprobado</span>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {
                    $value->ESTADO_BADGE = '<span class="badge bg-danger">Rechazado</span>';
                } elseif ($value->SOLICITAR_VERIFICACION == 'Sí') {
                    $value->ESTADO_BADGE = '<span class="badge bg-warning text-dark">En revisión</span>';
                } else {
                    $value->ESTADO_BADGE = ''; // vacío u opcional
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


    //// APROBACION DE MATRIS


    public function Tablamatirzaprobada()
    {
        try {
            $tabla = matrizModel::where('SOLICITAR_VERIFICACION', 'Sí')
                ->where(function ($query) {
                    $query->whereNull('ESTADO_APROBACION')
                        ->orWhereNotIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
                })
              
                ->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->SOLICITAR_VERIFICACION == 'Sí') {
                    $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">En revisión</span>';
                } elseif ($value->DAR_BUENO == 1) {
                    $value->ESTADO_REVISION = '<span class="badge bg-success">✔</span>';
                } elseif ($value->DAR_BUENO == 2) {
                    $value->ESTADO_REVISION = '<span class="badge bg-danger">✖</span>';
                } else {
                    $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
                }

                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->ESTATUS = '<span class="badge bg-success">Aprobado</span>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {
                    $value->ESTATUS = '<span class="badge bg-danger">Rechazado</span>';
                } else {
                    $value->ESTATUS = '<span class="badge bg-secondary">Aprobar</span>';
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
                    if ($request->ID_FORMULARIO_MATRIZ == 0) {
                        DB::statement('ALTER TABLE formulario_matrizcomparativa AUTO_INCREMENT=1;');
                        $matrizes = matrizModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $matrizes = matrizModel::where('ID_FORMULARIO_MATRIZ', $request['ID_FORMULARIO_MATRIZ'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['matriz'] = 'Desactivada';
                            } else {
                                $matrizes = matrizModel::where('ID_FORMULARIO_MATRIZ', $request['ID_FORMULARIO_MATRIZ'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['matriz'] = 'Activada';
                            }
                        } else {
                            $matrizes = matrizModel::find($request->ID_FORMULARIO_MATRIZ);
                            $matrizes->update($request->all());
                            $response['code'] = 1;
                            $response['matriz'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['matriz']  = $matrizes;
                    return response()->json($response);
                    break;



                case 2:
                    if ($request->ID_FORMULARIO_MATRIZ == 0) {
                        DB::statement('ALTER TABLE formulario_matrizcomparativa AUTO_INCREMENT=1;');
                        $matrizes = matrizModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $matrizes = matrizModel::where('ID_FORMULARIO_MATRIZ', $request['ID_FORMULARIO_MATRIZ'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['matriz'] = 'Desactivada';
                            } else {
                                $matrizes = matrizModel::where('ID_FORMULARIO_MATRIZ', $request['ID_FORMULARIO_MATRIZ'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['matriz'] = 'Activada';
                            }
                        } else {
                            $matrizes = matrizModel::find($request->ID_FORMULARIO_MATRIZ);
                            $matrizes->update($request->all());
                            $response['code'] = 1;
                            $response['matriz'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['matriz']  = $matrizes;
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
