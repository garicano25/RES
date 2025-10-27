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
use App\Models\organizacion\catalogocategoriaModel;


class recempleadoController extends Controller
{



    public function obtenerDatosPermiso()
    {
        try {
            $curp = auth()->user()->CURP;

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


    public function obtenerDatosVacaciones()
    {
        try {
            $curp = auth()->user()->CURP;

            // Obtener datos del empleado
            $empleado = DB::table('formulario_contratacion')
                ->where('CURP', $curp)
                ->select('NUMERO_EMPLEADO', 'FECHA_INGRESO')
                ->first();

            if (!$empleado) {
                return response()->json([
                    'error' => 'No se encontró información del empleado.'
                ], 404);
            }

            $fechaIngreso = new \DateTime($empleado->FECHA_INGRESO);
            $fechaActual = new \DateTime();

            $aniosServicio = $fechaIngreso->diff($fechaActual)->y;

            if ($aniosServicio == 0) {
                $aniosServicio = 1;
            }

            if ($aniosServicio == 1) {
                $diasCorresponden = 12;
            } elseif ($aniosServicio == 2) {
                $diasCorresponden = 14;
            } elseif ($aniosServicio == 3) {
                $diasCorresponden = 16;
            } elseif ($aniosServicio == 4) {
                $diasCorresponden = 18;
            } elseif ($aniosServicio == 5) {
                $diasCorresponden = 20;
            } elseif ($aniosServicio >= 6 && $aniosServicio <= 10) {
                $diasCorresponden = 22;
            } elseif ($aniosServicio >= 11 && $aniosServicio <= 15) {
                $diasCorresponden = 24;
            } elseif ($aniosServicio >= 16 && $aniosServicio <= 20) {
                $diasCorresponden = 26;
            } elseif ($aniosServicio >= 21 && $aniosServicio <= 25) {
                $diasCorresponden = 28;
            } else {
                $diasCorresponden = 30;
            }

            $fechaDesde = (clone $fechaIngreso)->modify('+' . ($aniosServicio - 1) . ' years');
            $fechaHasta = (clone $fechaIngreso)->modify('+' . $aniosServicio . ' years -1 day');

            $anioServicioFormateado = str_pad($aniosServicio, 2, '0', STR_PAD_LEFT);

            return response()->json([
                
                'numero_empleado' => $empleado->NUMERO_EMPLEADO,
                'fecha_ingreso' => $empleado->FECHA_INGRESO,
                'anios_servicio' => $anioServicioFormateado,
                'dias_corresponden' => $diasCorresponden,
                'desde_anio_vacaciones' => $fechaDesde->format('Y-m-d'),
                'hasta_anio_vacaciones' => $fechaHasta->format('Y-m-d'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener datos: ' . $e->getMessage()
            ], 500);
        }
    }



    public function obtenerAreaSolicitante()
    {
        $usuario = auth()->user();

        $rol = $usuario->roles()
            ->whereNotIn('NOMBRE_ROL', ['Superusuario', 'Administrador'])
            ->first();

        if (!$rol) {
            return response()->json(['area' => null]);
        }

        $categoria = CatalogocategoriaModel::where('NOMBRE_CATEGORIA', $rol->NOMBRE_ROL)->first();
        if (!$categoria) {
            return response()->json(['area' => null]);
        }

        $area = DB::table('areas as a')
            ->leftJoin('lideres_categorias as lc', 'lc.AREA_ID', '=', 'a.ID_AREA')
            ->leftJoin('areas_lideres as al', 'al.AREA_ID', '=', 'a.ID_AREA')
            ->where(function ($query) use ($categoria) {
                $query->where('lc.CATEGORIA_ID', $categoria->ID_CATALOGO_CATEGORIA)
                    ->orWhere('al.LIDER_ID', $categoria->ID_CATALOGO_CATEGORIA);
            })
            ->select('a.NOMBRE')
            ->first();

        return response()->json([
            'area' => $area ? $area->NOMBRE : null
        ]);
    }


    public function obtenerUltimoContrato($curp)
    {
        try {
            $contrato = DB::table('contratos_anexos_contratacion')
                ->where('CURP', $curp)
                ->orderBy('FECHAI_CONTRATO', 'desc') 
                ->select('ID_CONTRATOS_ANEXOS', 'NOMBRE_DOCUMENTO_CONTRATO', 'FECHAI_CONTRATO', 'VIGENCIA_CONTRATO')
                ->first();

            if ($contrato) {
                return response()->json([
                    'success' => true,
                    'contrato' => $contrato
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se encontraron contratos para esta CURP.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function obtenerContratoPorId($id)
    {
        try {
            $contrato = DB::table('contratos_anexos_contratacion')
                ->where('ID_CONTRATOS_ANEXOS', $id)
                ->select('ID_CONTRATOS_ANEXOS', 'NOMBRE_DOCUMENTO_CONTRATO', 'FECHAI_CONTRATO', 'VIGENCIA_CONTRATO')
                ->first();

            if ($contrato) {
                return response()->json(['success' => true, 'contrato' => $contrato]);
            } else {
                return response()->json(['success' => false, 'mensaje' => 'Contrato no encontrado.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }


    public function Tablarecempleados()
    {
        try {
            $userid = Auth::user()->ID_USUARIO;

            $tabla = recemplaedosModel::where('USUARIO_ID', $userid)
                ->orderBy('FECHA_SALIDA', 'asc') 
                ->get();
           

            foreach ($tabla as $value) {

                if ($value->TIPO_SOLICITUD == 1) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Aviso de ausencia y/o permiso';
                } elseif ($value->TIPO_SOLICITUD == 2) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Salida de almacén de materiales y/o equipos';
                } else {
                    $value->TIPO_SOLICITUD_TEXTO = 'Solicitud de Vacaciones';
                }

                if ($value->TIPO_SOLICITUD == 2) {
                    if ($value->ESTADO_APROBACION == 'Aprobada') {
                        $value->ESTADO_REVISION = '<span class="badge bg-success">✔</span>';
                        $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                        $value->BTN_ELIMINAR   = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"><span class="slider round"></span></label>';
                        $value->BTN_EDITAR     = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    } elseif ($value->ESTADO_APROBACION == 'Rechazada') {
                        $value->ESTADO_REVISION = '<span class="badge bg-danger">✖</span>';
                        $value->BTN_ELIMINAR   = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" checked><span class="slider round"></span></label>';
                        $value->BTN_EDITAR     = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                        $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    } else {
                        $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
                        $value->BTN_ELIMINAR   = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" checked><span class="slider round"></span></label>';
                        $value->BTN_EDITAR     = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                        $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    }
                } else {
                    if ($value->DAR_BUENO == 1) {
                        $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                        $value->BTN_ELIMINAR   = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"><span class="slider round"></span></label>';
                        $value->BTN_EDITAR     = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                        $value->ESTADO_REVISION = '<span class="badge bg-success">✔</span>';
                    } elseif ($value->DAR_BUENO == 2) {
                        $value->BTN_ELIMINAR   = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" checked><span class="slider round"></span></label>';
                        $value->BTN_EDITAR     = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                        $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                        $value->ESTADO_REVISION = '<span class="badge bg-danger">✖</span>';
                    } elseif ($value->DAR_BUENO == 0) {
                        $value->BTN_ELIMINAR   = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" checked><span class="slider round"></span></label>';
                        $value->BTN_EDITAR     = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                        $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                        $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">En revisión</span>';
                    } else {
                        $value->BTN_ELIMINAR   = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" checked><span class="slider round"></span></label>';
                        $value->BTN_EDITAR     = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                        $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                        $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
                    }
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


    //////////////////////////// SOLICITUDES PARA Vo.Bo ////////////////////////////


    public function Tablarecempleadovobo()
    {
        try {
            $usuario = Auth::user();
            $idUsuario = $usuario->ID_USUARIO;

            $roles = $usuario->roles()->pluck('NOMBRE_ROL')->toArray();

            $esDirector = in_array('Director', $roles);

            $categoriasLideradas = DB::table('lideres_categorias as lc')
                ->join('catalogo_categorias as cc', 'cc.ID_CATALOGO_CATEGORIA', '=', 'lc.LIDER_ID')
                ->whereIn('cc.NOMBRE_CATEGORIA', $roles)
                ->pluck('lc.CATEGORIA_ID')
                ->toArray();

            $usuariosACargo = DB::table('asignar_rol')
                ->whereIn('NOMBRE_ROL', function ($query) use ($categoriasLideradas) {
                    $query->select('NOMBRE_CATEGORIA')
                        ->from('catalogo_categorias')
                        ->whereIn('ID_CATALOGO_CATEGORIA', $categoriasLideradas);
                })
                ->pluck('USUARIO_ID')
                ->toArray();

            if ($esDirector) {
                $usuariosSinLider = DB::table('asignar_rol as ar')
                    ->leftJoin('catalogo_categorias as cc', 'cc.NOMBRE_CATEGORIA', '=', 'ar.NOMBRE_ROL')
                    ->leftJoin('lideres_categorias as lc', 'lc.CATEGORIA_ID', '=', 'cc.ID_CATALOGO_CATEGORIA')
                    ->whereNull('lc.LIDER_ID')
                    ->pluck('ar.USUARIO_ID')
                    ->toArray();

                $usuariosACargo = array_merge($usuariosACargo, $usuariosSinLider);
            }

            $usuariosACargo = array_unique($usuariosACargo);

            if (empty($usuariosACargo)) {
                return response()->json([
                    'data' => [],
                    'msj' => 'No tiene registros a su cargo.'
                ]);
            }

            $tabla = recemplaedosModel::whereIn('USUARIO_ID', $usuariosACargo)
                ->where('DAR_BUENO', 0)
                ->whereIn('TIPO_SOLICITUD', [1, 3])
                ->orderBy('FECHA_SALIDA', 'asc') 
                ->get();


            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }


                if ($value->TIPO_SOLICITUD == 1) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Aviso de ausencia y/o permiso';
                } elseif ($value->TIPO_SOLICITUD == 2) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Salida de almacén de materiales y/o equipos';
                } else {
                    $value->TIPO_SOLICITUD_TEXTO = 'Solicitud de Vacaciones';
                }


                
                if ($value->DAR_BUENO == 0) {
                    $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">Revisar</span>';
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


    //////////////////////////// SOLICITUDES PARA aprobación  ////////////////////////////


    public function Tablarecempleadoaprobacion()
    {
        try {
            $tabla = recemplaedosModel::where('DAR_BUENO', 1)
                ->where(function ($query) {
                    $query->whereNull('SUBIR_DOCUMENTO')
                        ->orWhereNotIn('SUBIR_DOCUMENTO', ['Sí']);
                })
                ->where(function ($query) {
                    $query->whereNull('JEFE_ID')
                        ->orWhere('JEFE_ID', '!=', Auth::id());
                })
                ->get();

          
          
            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }


                if ($value->TIPO_SOLICITUD == 1) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Aviso de ausencia y/o permiso';
                } elseif ($value->TIPO_SOLICITUD == 2) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Salida de almacén de materiales y/o equipos';
                } else {
                    $value->TIPO_SOLICITUD_TEXTO = 'Solicitud de Vacaciones';
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
                    $value->ESTATUS = '<span class="badge bg-secondary">Aprobar</span>';
                }


                // $value->DESCARGAR_FORMATOS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button " data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" title="Descargar"><i class="bi bi-filetype-pdf"></i></button>';


                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->DESCARGAR_FORMATOS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button" 
                    data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" 
                    data-tipo="' . $value->TIPO_SOLICITUD . '" 
                    title="Descargar"><i class="bi bi-filetype-pdf"></i></button>';

                } else {
                    $value->DESCARGAR_FORMATOS = '<button type="button" class="btn btn-secondary btn-custom rounded-pill " disabled><i class="bi bi-ban"></i></button>';
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



                case 2:
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
                                $datos = $request->except(['USUARIO_ID', 'CURP']);

                                if (isset($datos['MATERIALES_JSON'])) {
                                    $datos['MATERIALES_JSON'] = is_string($datos['MATERIALES_JSON'])
                                        ? $datos['MATERIALES_JSON']
                                        : json_encode($datos['MATERIALES_JSON'], JSON_UNESCAPED_UNICODE);
                                }

                                $datos['JEFE_ID'] = auth()->user()->ID_USUARIO;


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


                case 3:
                    if ($request->ID_FORMULARIO_RECURSOS_EMPLEADOS == 0) {
                        DB::statement('ALTER TABLE formulario_recempleados AUTO_INCREMENT=1;');

                        $materialesJson = is_string($request->MATERIALES_JSON)
                            ? $request->MATERIALES_JSON
                            : json_encode($request->MATERIALES_JSON, JSON_UNESCAPED_UNICODE);

                        $mrs = recemplaedosModel::create(array_merge(
                            $request->except(['MATERIALES_JSON', 'DOCUMENTO_SOLICITUD']),
                            [
                                'USUARIO_ID' => auth()->user()->ID_USUARIO,
                                'CURP' => auth()->user()->CURP,
                                'MATERIALES_JSON' => $materialesJson
                            ]
                        ));

                        if ($request->hasFile('DOCUMENTO_SOLICITUD')) {
                            $documento = $request->file('DOCUMENTO_SOLICITUD');
                            $curp = auth()->user()->CURP;
                            $idDocumento = $mrs->ID_FORMULARIO_RECURSOS_EMPLEADOS;

                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME))
                                . '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta = 'reclutamiento/' . $curp . '/Formatos de solicitud/' . $idDocumento;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $mrs->DOCUMENTO_SOLICITUD = $rutaCompleta;
                            $mrs->save();
                        }

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
                                $datos = $request->except(['USUARIO_ID', 'CURP', 'DOCUMENTO_SOLICITUD']);

                                if (isset($datos['MATERIALES_JSON'])) {
                                    $datos['MATERIALES_JSON'] = is_string($datos['MATERIALES_JSON'])
                                        ? $datos['MATERIALES_JSON']
                                        : json_encode($datos['MATERIALES_JSON'], JSON_UNESCAPED_UNICODE);
                                }

                                $datos['AUTORIZO_ID'] = auth()->user()->ID_USUARIO;

                                $mrs->update($datos);

                                if ($request->hasFile('DOCUMENTO_SOLICITUD')) {
                                    if ($mrs->DOCUMENTO_SOLICITUD && Storage::exists($mrs->DOCUMENTO_SOLICITUD)) {
                                        Storage::delete($mrs->DOCUMENTO_SOLICITUD);
                                    }

                                    $documento = $request->file('DOCUMENTO_SOLICITUD');
                                    $curp = $mrs->CURP;
                                    $idDocumento = $mrs->ID_FORMULARIO_RECURSOS_EMPLEADOS;

                                    $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME))
                                        . '.' . $documento->getClientOriginalExtension();

                                    $rutaCarpeta = 'reclutamiento/' . $curp . '/Formatos de solicitud/' . $idDocumento;
                                    $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                    $mrs->DOCUMENTO_SOLICITUD = $rutaCompleta;
                                    $mrs->save();
                                }

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



                case 4:
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
                                $datos = $request->except(['USUARIO_ID', 'CURP']);

                                if (isset($datos['MATERIALES_JSON'])) {
                                    $datos['MATERIALES_JSON'] = is_string($datos['MATERIALES_JSON'])
                                        ? $datos['MATERIALES_JSON']
                                        : json_encode($datos['MATERIALES_JSON'], JSON_UNESCAPED_UNICODE);
                                }

                                $datos['AUTORIZO_ID'] = auth()->user()->ID_USUARIO;


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
