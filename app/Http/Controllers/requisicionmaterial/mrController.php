<?php

namespace App\Http\Controllers\requisicionmaterial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;


use App\Models\requisicionmaterial\mrModel;
use App\Models\organizacion\catalogocategoriaModel;


class mrController extends Controller
{



    public function Tablamr()
    {
        try {
            $userid = Auth::user()->ID_USUARIO;

            $tabla = mrModel::where('USUARIO_ID', $userid)->get();

            foreach ($tabla as $value) {



                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                // Estado según DAR_BUENO
                if ($value->DAR_BUENO == 0) {
                    $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">En revisión</span>';
                } elseif ($value->DAR_BUENO == 1) {
                    $value->ESTADO_REVISION = '<span class="badge bg-success">Aprobada </span>';
                } elseif ($value->DAR_BUENO == 2) {
                    $value->ESTADO_REVISION = '<span class="badge bg-danger">Rechazada por jefe inmediato</span>';
                } else {
                    $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
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



    public function Tablarequsicionaprobada()
    {
        try {
            $tabla = mrModel::get();

            foreach ($tabla as $value) {



                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                // Estado según DAR_BUENO
                if ($value->DAR_BUENO == 0) {
                    $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">En revisión</span>';
                } elseif ($value->DAR_BUENO == 1) {
                    $value->ESTADO_REVISION = '<span class="badge bg-success">Aprobada </span>';
                } elseif ($value->DAR_BUENO == 2) {
                    $value->ESTADO_REVISION = '<span class="badge bg-danger">Rechazada por jefe inmediato</span>';
                } else {
                    $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
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



    public function guardarYDarVistoBueno(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:formulario_requisiconmaterial,ID_FORMULARIO_MR',
            'prioridad' => 'required|string',
            'observaciones' => 'required|string',
            'linea_negocios' => 'required|string',
            'fecha_visto' => 'required|date',
            'visto_bueno' => 'required|string',
            'materiales_json' => 'required|string',

        ]);

        $formulario = mrModel::find($request->id);
        $formulario->PRIORIDAD_MR = $request->prioridad;
        $formulario->OBSERVACIONES_MR = $request->observaciones;
        $formulario->LINEA_NEGOCIOS_MR = $request->linea_negocios;
        $formulario->FECHA_VISTO_MR = $request->fecha_visto;
        $formulario->VISTO_BUENO = $request->visto_bueno;
        $formulario->MATERIALES_JSON = $request->materiales_json;
        $formulario->DAR_BUENO = 1;
        $formulario->save();

        return response()->json(['success' => true, 'message' => 'Formulario actualizado con visto bueno.']);
    }


    public function rechazar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:formulario_requisiconmaterial,ID_FORMULARIO_MR',
            'motivo' => 'required|string|max:1000',
            'prioridad' => 'required|string',
            'observaciones' => 'required|string',
            'linea_negocios' => 'required|string',
            'fecha_visto' => 'required|date',
            'visto_bueno' => 'required|string',
            'materiales_json' => 'required|string',

        ]);

        $formulario = mrModel::find($request->id);
        $formulario->PRIORIDAD_MR = $request->prioridad;
        $formulario->OBSERVACIONES_MR = $request->observaciones;
        $formulario->LINEA_NEGOCIOS_MR = $request->linea_negocios;
        $formulario->FECHA_VISTO_MR = $request->fecha_visto;
        $formulario->VISTO_BUENO = $request->visto_bueno;
        $formulario->DAR_BUENO = 2;
        $formulario->MOTIVO_RECHAZO_JEFE = $request->motivo;
        $formulario->MATERIALES_JSON = $request->materiales_json;

        $formulario->save();

        return response()->json(['success' => true, 'message' => 'Formulario rechazado correctamente.']);
    }




    public function Tablarequisicion()
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

            $tabla = mrModel::whereIn('USUARIO_ID', $usuariosACargo)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->DAR_BUENO == 0) {
                    $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">Revisar</span>';
                } elseif ($value->DAR_BUENO == 1) {
                    $value->ESTADO_REVISION = '<span class="badge bg-success">Aprobada</span>';
                } elseif ($value->DAR_BUENO == 2) {
                    $value->ESTADO_REVISION = '<span class="badge bg-danger">Rechazada</span>';
                } else {
                    $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
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




    // public function store(Request $request)
    // {
    //     try {
    //         switch (intval($request->api)) {
    //             case 1:
    //                 if ($request->ID_FORMULARIO_MR == 0) {
    //                     DB::statement('ALTER TABLE formulario_requisiconmaterial AUTO_INCREMENT=1;');

    //                     $year = date('y'); 
    //                     $lastMR = mrModel::where('NO_MR', 'like', "RES-MR$year-%")
    //                     ->orderBy('NO_MR', 'desc')
    //                         ->first();

    //                     $nextNumber = $lastMR ? intval(substr($lastMR->NO_MR, -3)) + 1 : 1;
    //                     $noMR = sprintf("RES-MR%s-%03d", $year, $nextNumber);

    //                     $mrs = mrModel::create(array_merge($request->all(), [
    //                         'NO_MR' => $noMR
    //                     ]));

    //                     return response()->json([
    //                         'code' => 1,
    //                         'mr' => $mrs
    //                     ]);
    //                 } else {
    //                     if (isset($request->ELIMINAR)) {
    //                         $estado = $request->ELIMINAR == 1 ? 0 : 1;
    //                         mrModel::where('ID_FORMULARIO_MR', $request->ID_FORMULARIO_MR)
    //                             ->update(['ACTIVO' => $estado]);

    //                         return response()->json([
    //                             'code' => 1,
    //                             'mr' => $estado == 0 ? 'Desactivada' : 'Activada'
    //                         ]);
    //                     } else {
    //                         $mrs = mrModel::find($request->ID_FORMULARIO_MR);
    //                         if ($mrs) {
    //                             $mrs->update($request->all());
    //                             return response()->json([
    //                                 'code' => 1,
    //                                 'mr' => 'Actualizada'
    //                             ]);
    //                         }
    //                         return response()->json([
    //                             'code' => 0,
    //                             'msj' => 'MR no encontrada'
    //                         ], 404);
    //                     }
    //                 }
    //                 break;
    //             default:
    //                 return response()->json([
    //                     'code' => 1,
    //                     'msj' => 'Api no encontrada'
    //                 ]);
    //         }
    //     } catch (Exception $e) {
    //         Log::error("Error al guardar MR: " . $e->getMessage());
    //         return response()->json([
    //             'code' => 0,
    //             'error' => 'Error al guardar la MR'
    //         ], 500);
    //     }
    // }



    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_MR == 0) {
                        DB::statement('ALTER TABLE formulario_requisiconmaterial AUTO_INCREMENT=1;');

                        $year = date('y');
                        $lastMR = mrModel::where('NO_MR', 'like', "RES-MR$year-%")
                            ->orderBy('NO_MR', 'desc')
                            ->first();

                        $nextNumber = $lastMR ? intval(substr($lastMR->NO_MR, -3)) + 1 : 1;
                        $noMR = sprintf("RES-MR%s-%03d", $year, $nextNumber);

                        // Creamos el formulario nuevo con MATERIALES_JSON y USUARIO_ID
                        $mrs = mrModel::create(array_merge(
                            $request->all(),
                            [
                                'NO_MR' => $noMR,
                                'USUARIO_ID' => auth()->user()->ID_USUARIO, 
                                'MATERIALES_JSON' => $request->MATERIALES_JSON
                            ]
                        ));

                        return response()->json([
                            'code' => 1,
                            'mr' => $mrs
                        ]);
                    } else {
                        // EDICIÓN
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            mrModel::where('ID_FORMULARIO_MR', $request->ID_FORMULARIO_MR)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'mr' => $estado == 0 ? 'Desactivada' : 'Activada'
                            ]);
                        } else {
                            $mrs = mrModel::find($request->ID_FORMULARIO_MR);
                            if ($mrs) {
                                // No se actualiza USUARIO_ID, pero sí MATERIALES_JSON
                                $mrs->update($request->except(['USUARIO_ID']));

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
            Log::error("Error al guardar MR: " . $e->getMessage());
            return response()->json([
                'code' => 0,
                'error' => 'Error al guardar la MR'
            ], 500);
        }
    }
}
