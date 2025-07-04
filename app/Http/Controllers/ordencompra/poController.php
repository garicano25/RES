<?php

namespace App\Http\Controllers\ordencompra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;

use App\Models\ordencompra\poModel; 
use App\Models\HojaTrabajo;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;



class poController extends Controller
{



    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.ordencompra.ordencompra', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }

    public function index1()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.ordencompra.aprobacionorden', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }


    public function Tablaordencompra()
    {
        try {
            $tabla = poModel::get();

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
                } elseif ($value->SOLICITAR_AUTORIZACION == 'Sí') {
                    $value->ESTADO_BADGE = '<span class="badge bg-warning text-dark">En revisión</span>';
                } else {
                    $value->ESTADO_BADGE = '<span class="badge bg-secondary">Sin estatus</span>'; // vacío u opcional
                }
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



    public function Tablaordencompraprobacion()
    {
        try {
            $tabla = poModel::where('SOLICITAR_AUTORIZACION', 'Sí')
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

                if ($value->SOLICITAR_AUTORIZACION == 'Sí') {
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








    public function obtenerNombreUsuario($id)
    {
        $usuario = DB::table('usuarios')
            ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
            ->where('ID_USUARIO', $id)
            ->first();

        if ($usuario) {
            $nombreCompleto = trim("{$usuario->EMPLEADO_NOMBRE} {$usuario->EMPLEADO_APELLIDOPATERNO} {$usuario->EMPLEADO_APELLIDOMATERNO}");
            return response()->json(['nombre_completo' => $nombreCompleto]);
        } else {
            return response()->json(['nombre_completo' => ''], 404);
        }
    }





    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {

                case 1:
                    if ($request->ID_FORMULARIO_PO == 0) {
                        // NUEVO REGISTRO
                        DB::statement('ALTER TABLE formulario_ordencompra AUTO_INCREMENT=1;');

                        if ($request->SOLICITAR_AUTORIZACION === 'Sí') {
                            $request->merge(['USUARIO_ID' => auth()->user()->ID_USUARIO]);
                        }

                        $compras = poModel::create($request->all());
                        $response['code']  = 1;
                        $response['compra'] = $compras;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['compra'] = 'Desactivada';
                            } else {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['compra'] = 'Activada';
                            }
                        } else {
                            $compras = poModel::find($request->ID_FORMULARIO_PO);

                            if ($request->SOLICITAR_AUTORIZACION === 'Sí' && !$compras->USUARIO_ID) {
                                $request->merge(['USUARIO_ID' => auth()->user()->ID_USUARIO]);
                            }

                            $compras->update($request->all());
                            $response['code'] = 1;
                            $response['compra'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    break;




                case 2:
                    if ($request->ID_FORMULARIO_PO == 0) {
                        DB::statement('ALTER TABLE formulario_ordencompra AUTO_INCREMENT=1;');
                        $compras = poModel::create($request->all());

                        $response['code']  = 1;
                        $response['compra']  = $compras;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['compra'] = 'Desactivada';
                            } else {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['compra'] = 'Activada';
                            }
                        } else {
                            $compras = poModel::find($request->ID_FORMULARIO_PO);

                            if (
                                in_array($request->ESTADO_APROBACION, ['Aprobada', 'Rechazada']) &&
                                empty($compras->APROBO_ID)
                            ) {
                                $compras->APROBO_ID = auth()->user()->ID_USUARIO;
                            }

                            $compras->update($request->all());

                            $response['code'] = 1;
                            $response['compra'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

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