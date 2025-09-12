<?php

namespace App\Http\Controllers\recursosempleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;


use App\Models\recempleados\recemplaedosModel;


class recempleadoController extends Controller
{



    public function obtenerDatosPermiso()
    {
        try {
            $curp = auth()->user()->CURP;

            // Cargo
            $cargo = DB::table('contratos_anexos_contratacion as cac')
                ->join('catalogo_categorias as cc', 'cc.ID_CATALOGO_CATEGORIA', '=', 'cac.NOMBRE_CARGO')
                ->where('cac.CURP', $curp)
                ->orderBy('cac.ID_CONTRATOS_ANEXOS', 'desc')
                ->select('cc.NOMBRE_CATEGORIA')
                ->first();

            $empleado = DB::table('formulario_contratacion')
                ->where('CURP', $curp)
                ->select('NUMERO_EMPLEADO')
                ->first();

            return response()->json([
                'cargo' => $cargo ? $cargo->NOMBRE_CATEGORIA : 'No disponible',
                'numero_empleado' => $empleado ? $empleado->NUMERO_EMPLEADO : 'No disponible'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener datos: ' . $e->getMessage()
            ], 500);
        }
    }


    public function Tablarecempleados()
    {
        try {
            $userid = Auth::user()->ID_USUARIO;

            $tabla = recemplaedosModel::where('USUARIO_ID', $userid)->get();

            foreach ($tabla as $value) {

              
              
              
                if ($value->TIPO_SOLICITUD == 1) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Aviso de ausencia y/o permiso';
                } elseif ($value->TIPO_SOLICITUD == 2) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Salida de almacén de materiales y/o equipos';
                } else {
                    $value->TIPO_SOLICITUD_TEXTO = 'Solicitud de Vacaciones';
                }


                if ($value->DAR_BUENO == 1) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->DAR_BUENO == 0) {
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
                    $value->ESTATUS = '<span class="badge bg-secondary">Sin estatus</span>';
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




    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_RECURSOS_EMPLEADOS == 0) {
                        DB::statement('ALTER TABLE formulario_recempleados AUTO_INCREMENT=1;');

                    

                       
                        $materialesJson = is_string($request->MATERIALES_JSON)
                            ? $request->MATERIALES_JSON
                            : json_encode($request->MATERIALES_JSON, JSON_UNESCAPED_UNICODE);

                        $mrs = recemplaedosModel::create(array_merge(
                            $request->except(['MATERIALES_JSON']),
                            [
                               
                                'USUARIO_ID' => auth()->user()->ID_USUARIO,
                                'CURP' => auth()->user()->CURP,

                                'MATERIALES_JSON' => $materialesJson
                            ]
                        ));

                        return response()->json([
                            'code' => 1,
                            'mr' => $mrs
                        ]);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            recemplaedosModel::where('ID_FORMULARIO_RECURSOS_EMPLEADOS', $request->ID_FORMULARIO_RECURSOS_EMPLEADOS)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'mr' => $estado == 0 ? 'Desactivada' : 'Activada'
                            ]);
                        } else {
                            $mrs = recemplaedosModel::find($request->ID_FORMULARIO_RECURSOS_EMPLEADOS);
                            if ($mrs) {
                                $datos = $request->except(['USUARIO_ID','CURP']);

                                if (isset($datos['MATERIALES_JSON'])) {
                                    $datos['MATERIALES_JSON'] = is_string($datos['MATERIALES_JSON'])
                                        ? $datos['MATERIALES_JSON']
                                        : json_encode($datos['MATERIALES_JSON'], JSON_UNESCAPED_UNICODE);
                                }

                                $mrs->update($datos);

                                return response()->json([
                                    'code' => 1,
                                    'mr' => 'Actualizada'
                                ]);
                            }

                            return response()->json([
                                'code' => 0,
                                'msj' => 'MR no encontrada'
                            ], 404);
                        }
                    }
                    break;

                default:
                    return response()->json([
                        'code' => 1,
                        'msj' => 'Api no encontrada'
                    ]);
            }
        } catch (Exception $e) {
            Log::error("Error al guardar  " . $e->getMessage());
            return response()->json([
                'code' => 0,
                'error' => 'Error al guardar la MR'
            ], 500);
        }
    }

}
