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

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;



// BITACORA


use App\Models\HojaTrabajo;


class mrController extends Controller
{




    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP','NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.requisicionesmaterial.bitacora', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }


    public function Tablamr()
    {
        try {
            $userid = Auth::user()->ID_USUARIO;

            $tabla = mrModel::where('USUARIO_ID', $userid)->get();

            foreach ($tabla as $value) {



                if ($value->DAR_BUENO == 1) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
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



    // public function Tablarequsicionaprobada()
    // {
    //     try {
    //         $tabla = mrModel::where('DAR_BUENO', 1)
    //             ->where(function ($query) {
    //                 $query->whereNull('ESTADO_APROBACION')
    //                     ->orWhereNotIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
    //             })
    //             ->get();

    //         foreach ($tabla as $value) {



    //             if ($value->ACTIVO == 0) {
    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
    //             } else {
    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
    //             }

    //             if ($value->DAR_BUENO == 0) {
    //                 $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">En revisión</span>';
    //             } elseif ($value->DAR_BUENO == 1) {
    //                 $value->ESTADO_REVISION = '<span class="badge bg-success">✔</span>';
    //             } elseif ($value->DAR_BUENO == 2) {
    //                 $value->ESTADO_REVISION = '<span class="badge bg-danger">✖</span>';
    //             } else {
    //                 $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
    //             }

    //             if ($value->ESTADO_APROBACION == 'Aprobada') {
    //                 $value->ESTATUS = '<span class="badge bg-success">Aprobado</span>';
    //             } elseif ($value->ESTADO_APROBACION == 'Rechazada') {
    //                 $value->ESTATUS = '<span class="badge bg-danger">Rechazado</span>';
    //             } else {
    //                 $value->ESTATUS = '<span class="badge bg-secondary">Aprobar</span>';
    //             }
    //         }

    //         // Respuesta
    //         return response()->json([
    //             'data' => $tabla,
    //             'msj' => 'Información consultada correctamente'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'msj' => 'Error ' . $e->getMessage(),
    //             'data' => 0
    //         ]);
    //     }
    // }

    public function Tablarequsicionaprobada()
    {
        try {
            $tabla = mrModel::where('DAR_BUENO', 1)
                ->where(function ($query) {
                    $query->whereNull('ESTADO_APROBACION')
                        ->orWhereNotIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
                })
                ->where(function ($query) {
                    $query->whereNull('JEFEINMEDIATO_ID')
                        ->orWhere('JEFEINMEDIATO_ID', '!=', Auth::id()); // <<--- Aquí filtramos
                })
                ->get();

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
            'observaciones' => 'nullable|string',
            'fecha_visto' => 'required|date',
            'visto_bueno' => 'required|string',
            'materiales_json' => 'required|string',
        ]);

        $formulario = mrModel::find($request->id);
        $formulario->PRIORIDAD_MR = $request->prioridad;
        $formulario->OBSERVACIONES_MR = $request->observaciones;
        $formulario->FECHA_VISTO_MR = $request->fecha_visto;
        $formulario->VISTO_BUENO = $request->visto_bueno;
        $formulario->MATERIALES_JSON = $request->materiales_json;
        $formulario->DAR_BUENO = 1;
        $formulario->JEFEINMEDIATO_ID = Auth::id(); 
        $formulario->save();

        return response()->json(['success' => true, 'message' => 'Formulario actualizado con visto bueno.']);
    }


    public function rechazar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:formulario_requisiconmaterial,ID_FORMULARIO_MR',
            'motivo' => 'required|string|max:1000',
            'prioridad' => 'required|string',
            'observaciones' => 'nullable|string',
            'fecha_visto' => 'required|date',
            'visto_bueno' => 'required|string',
            'materiales_json' => 'required|string',

        ]);

        $formulario = mrModel::find($request->id);
        $formulario->PRIORIDAD_MR = $request->prioridad;
        $formulario->OBSERVACIONES_MR = $request->observaciones;
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

            $tabla = mrModel::whereIn('USUARIO_ID', $usuariosACargo)
            ->where('DAR_BUENO', 0)
            ->get();

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



    /////////////////////////////////////////////////////////// BITACORA REQUISICION //////////////////////////////////////////////////////////////

    public function Tablabitacora()
    {
        try {
            // Solo obtener registros con ESTADO_APROBACION = 'Aprobada'
            $tabla = mrModel::where('ESTADO_APROBACION', 'Aprobada')->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-eye"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                $value->BTN_NO_MR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
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









    // public function guardarHOJAS(Request $request)
    // {
    //     $esUnico = $request->input('ES_UNICO');
    //     $no_mr = $request->input('NO_MR');
    //     $ids = $request->input('id');

    //     // Campos comunes
    //     $proveedor_q1 = $request->input('PROVEEDOR_Q1');
    //     $subtotal_q1 = $request->input('SUBTOTAL_Q1');
    //     $iva_q1 = $request->input('IVA_Q1');
    //     $importe_q1 = $request->input('IMPORTE_Q1');
    //     $observaciones_q1 = $request->input('OBSERVACIONES_Q1');
    //     $fecha_q1 = $request->input('FECHA_COTIZACION_Q1');
    //     $proveedor_q2 = $request->input('PROVEEDOR_Q2');
    //     $subtotal_q2 = $request->input('SUBTOTAL_Q2');
    //     $iva_q2 = $request->input('IVA_Q2');
    //     $importe_q2 = $request->input('IMPORTE_Q2');
    //     $observaciones_q2 = $request->input('OBSERVACIONES_Q2');
    //     $fecha_q2 = $request->input('FECHA_COTIZACION_Q2');
    //     $proveedor_q3 = $request->input('PROVEEDOR_Q3');
    //     $subtotal_q3 = $request->input('SUBTOTAL_Q3');
    //     $iva_q3 = $request->input('IVA_Q3');
    //     $importe_q3 = $request->input('IMPORTE_Q3');
    //     $observaciones_q3 = $request->input('OBSERVACIONES_Q3');
    //     $fecha_q3 = $request->input('FECHA_COTIZACION_Q3');
    //     $proveedor_sugerido = $request->input('PROVEEDOR_SUGERIDO');
    //     $solicitarverificacion = $request->input('SOLICITAR_VERIFICACION');
    //     $fechaverificacion = $request->input('FECHA_VERIFICACION');
    //     $estadoaprobacion = $request->input('ESTADO_APROBACION');
    //     $motivorechazo = $request->input('MOTIVO_RECHAZO');
    //     $fechaaprobacion = $request->input('FECHA_APROBACION');
    //     $forma_adquisicion = $request->input('FORMA_ADQUISICION');
    //     $proveedor_seleccionado = $request->input('PROVEEDOR_SELECCIONADO');
    //     $monto_final = $request->input('MONTO_FINAL');
    //     $forma_pago = $request->input('FORMA_PAGO');
    //     $requiere_po = $request->input('REQUIERE_PO');
    //     $requierecomentario = $request->input('REQUIERE_COMENTARIO');
    //     $comentarioaprobacion = $request->input('COMENTARIO_APROBACION');

    //     if ($esUnico === 'SI') {
    //         $materiales_hoja_json = $request->input('MATERIALES_HOJA_JSON')[0] ?? null;
    //         $id_hoja = $ids[0] ?? null;

    //         $data = [
    //             'NO_MR' => $no_mr,
    //             'PROVEEDOR_Q1' => $proveedor_q1[0] ?? null,
    //             'SUBTOTAL_Q1' => $subtotal_q1[0] ?? null,
    //             'IVA_Q1' => $iva_q1[0] ?? null,
    //             'IMPORTE_Q1' => $importe_q1[0] ?? null,
    //             'OBSERVACIONES_Q1' => $observaciones_q1[0] ?? null,
    //             'FECHA_COTIZACION_Q1' => $fecha_q1[0] ?? null,
    //             'PROVEEDOR_Q2' => $proveedor_q2[0] ?? null,
    //             'SUBTOTAL_Q2' => $subtotal_q2[0] ?? null,
    //             'IVA_Q2' => $iva_q2[0] ?? null,
    //             'IMPORTE_Q2' => $importe_q2[0] ?? null,
    //             'OBSERVACIONES_Q2' => $observaciones_q2[0] ?? null,
    //             'FECHA_COTIZACION_Q2' => $fecha_q2[0] ?? null,
    //             'PROVEEDOR_Q3' => $proveedor_q3[0] ?? null,
    //             'SUBTOTAL_Q3' => $subtotal_q3[0] ?? null,
    //             'IVA_Q3' => $iva_q3[0] ?? null,
    //             'IMPORTE_Q3' => $importe_q3[0] ?? null,
    //             'OBSERVACIONES_Q3' => $observaciones_q3[0] ?? null,
    //             'FECHA_COTIZACION_Q3' => $fecha_q3[0] ?? null,
    //             'PROVEEDOR_SUGERIDO' => $proveedor_sugerido[0] ?? null,
    //             'SOLICITAR_VERIFICACION' => $solicitarverificacion[0] ?? null,
    //             'FECHA_VERIFICACION' => $fechaverificacion[0] ?? null,
    //             'ESTADO_APROBACION' => $estadoaprobacion[0] ?? null,
    //             'MOTIVO_RECHAZO' => $motivorechazo[0] ?? null,
    //             'FECHA_APROBACION' => $fechaaprobacion[0] ?? null,
    //             'FORMA_ADQUISICION' => $forma_adquisicion[0] ?? null,
    //             'PROVEEDOR_SELECCIONADO' => $proveedor_seleccionado[0] ?? null,
    //             'MONTO_FINAL' => $monto_final[0] ?? null,
    //             'FORMA_PAGO' => $forma_pago[0] ?? null,
    //             'REQUIERE_PO' => $requiere_po[0] ?? null,
    //             'REQUIERE_COMENTARIO' => $requierecomentario[0] ?? null,
    //             'COMENTARIO_APROBACION' => $comentarioaprobacion[0] ?? null,
    //             'MATERIALES_HOJA_JSON' => $materiales_hoja_json,
    //         ];

    //         if ($id_hoja) {
    //             $hoja = HojaTrabajo::find($id_hoja);
    //             if ($hoja) {
    //                 $hoja->update($data);
    //             } else {
    //                 $hoja = HojaTrabajo::create($data);
    //             }
    //         } else {
    //             $hoja = HojaTrabajo::create($data);
    //         }

    //         $id = $hoja->id;

    //         foreach (['Q1', 'Q2', 'Q3'] as $q) {
    //             if ($request->hasFile("DOCUMENTO_{$q}.0")) {
    //                 $file = $request->file("DOCUMENTO_{$q}")[0];
    //                 $fileName = $file->getClientOriginalName();
    //                 $folder = "compras/{$no_mr}/{$id}/{$q}";
    //                 $path = $file->storeAs($folder, $fileName);
    //                 $hoja["DOCUMENTO_{$q}"] = $path;
    //             }
    //         }

    //         $hoja->save();
    //     } else {
    //         $descripciones = $request->input('DESCRIPCION');
    //         $cantidades = $request->input('CANTIDAD');
    //         $unidades = $request->input('UNIDAD_MEDIDA');
    //         $cantidadmrq1 = $request->input('CANTIDAD_MRQ1');
    //         $cantidadrealq1 = $request->input('CANTIDAD_REALQ1');
    //         $preciounitarioq1 = $request->input('PRECIO_UNITARIOQ1');
    //         $cantidadmrq2 = $request->input('CANTIDAD_MRQ2');
    //         $cantidadrealq2 = $request->input('CANTIDAD_REALQ2');
    //         $preciounitarioq2 = $request->input('PRECIO_UNITARIOQ2');
    //         $cantidadmrq3 = $request->input('CANTIDAD_MRQ3');
    //         $cantidadrealq3 = $request->input('CANTIDAD_REALQ3');
    //         $preciounitarioq3 = $request->input('PRECIO_UNITARIOQ3');

    //         $total = count($descripciones);

    //         for ($i = 0; $i < $total; $i++) {
    //             $data = [
    //                 'NO_MR' => $no_mr,
    //                 'DESCRIPCION' => $descripciones[$i] ?? '',
    //                 'CANTIDAD' => $cantidades[$i] ?? '',
    //                 'UNIDAD_MEDIDA' => $unidades[$i] ?? '',
    //                 'CANTIDAD_MRQ1' => $cantidadmrq1[$i] ?? null,
    //                 'CANTIDAD_REALQ1' => $cantidadrealq1[$i] ?? null,
    //                 'PRECIO_UNITARIOQ1' => $preciounitarioq1[$i] ?? null,
    //                 'CANTIDAD_MRQ2' => $cantidadmrq2[$i] ?? null,
    //                 'CANTIDAD_REALQ2' => $cantidadrealq2[$i] ?? null,
    //                 'PRECIO_UNITARIOQ2' => $preciounitarioq2[$i] ?? null,
    //                 'CANTIDAD_MRQ3' => $cantidadmrq3[$i] ?? null,

    //                 'CANTIDAD_REALQ3' => $cantidadrealq3[$i] ?? null,
    //                 'PRECIO_UNITARIOQ3' => $preciounitarioq3[$i] ?? null,
    //                 'PROVEEDOR_Q1' => $proveedor_q1[$i] ?? null,
    //                 'SUBTOTAL_Q1' => $subtotal_q1[$i] ?? null,
    //                 'IVA_Q1' => $iva_q1[$i] ?? null,
    //                 'IMPORTE_Q1' => $importe_q1[$i] ?? null,
    //                 'OBSERVACIONES_Q1' => $observaciones_q1[$i] ?? null,
    //                 'FECHA_COTIZACION_Q1' => $fecha_q1[$i] ?? null,
    //                 'PROVEEDOR_Q2' => $proveedor_q2[$i] ?? null,
    //                 'SUBTOTAL_Q2' => $subtotal_q2[$i] ?? null,
    //                 'IVA_Q2' => $iva_q2[$i] ?? null,
    //                 'IMPORTE_Q2' => $importe_q2[$i] ?? null,
    //                 'OBSERVACIONES_Q2' => $observaciones_q2[$i] ?? null,
    //                 'FECHA_COTIZACION_Q2' => $fecha_q2[$i] ?? null,
    //                 'PROVEEDOR_Q3' => $proveedor_q3[$i] ?? null,
    //                 'SUBTOTAL_Q3' => $subtotal_q3[$i] ?? null,
    //                 'IVA_Q3' => $iva_q3[$i] ?? null,
    //                 'IMPORTE_Q3' => $importe_q3[$i] ?? null,
    //                 'OBSERVACIONES_Q3' => $observaciones_q3[$i] ?? null,
    //                 'FECHA_COTIZACION_Q3' => $fecha_q3[$i] ?? null,
    //                 'PROVEEDOR_SUGERIDO' => $proveedor_sugerido[$i] ?? null,
    //                 'SOLICITAR_VERIFICACION' => $solicitarverificacion[$i] ?? null,
    //                 'FECHA_VERIFICACION' => $fechaverificacion[$i] ?? null,
    //                 'ESTADO_APROBACION' => $estadoaprobacion[$i] ?? null,
    //                 'MOTIVO_RECHAZO' => $motivorechazo[$i] ?? null,
    //                 'FECHA_APROBACION' => $fechaaprobacion[$i] ?? null,
    //                 'FORMA_ADQUISICION' => $forma_adquisicion[$i] ?? null,
    //                 'PROVEEDOR_SELECCIONADO' => $proveedor_seleccionado[$i] ?? null,
    //                 'MONTO_FINAL' => $monto_final[$i] ?? null,
    //                 'FORMA_PAGO' => $forma_pago[$i] ?? null,
    //                 'REQUIERE_PO' => $requiere_po[$i] ?? null,
    //                 'REQUIERE_COMENTARIO' => $requierecomentario[$i] ?? null,
    //                 'COMENTARIO_APROBACION' => $comentarioaprobacion[$i] ?? null,
    //             ];

    //             $hoja = !empty($ids[$i]) ? HojaTrabajo::find($ids[$i]) : null;
    //             if ($hoja) {
    //                 $hoja->update($data);
    //             } else {
    //                 $hoja = HojaTrabajo::create($data);
    //             }

    //             $id = $hoja->id;

    //             foreach (['Q1', 'Q2', 'Q3'] as $q) {
    //                 if ($request->hasFile("DOCUMENTO_{$q}.$i")) {
    //                     $file = $request->file("DOCUMENTO_{$q}")[$i];
    //                     $fileName = $file->getClientOriginalName();
    //                     $folder = "compras/{$no_mr}/{$id}/{$q}";
    //                     $path = $file->storeAs($folder, $fileName);
    //                     $hoja["DOCUMENTO_{$q}"] = $path;
    //                 }
    //             }

    //             $hoja->save();
    //         }
    //     }

    //     return response()->json(['success' => true]);
    // }



    public function guardarHOJAS(Request $request)
    {
        $esUnico = $request->input('ES_UNICO');
        $no_mr = $request->input('NO_MR');
        $ids = $request->input('id');

        // Campos comunes
        $proveedor_q1 = $request->input('PROVEEDOR_Q1');
        $subtotal_q1 = $request->input('SUBTOTAL_Q1');
        $iva_q1 = $request->input('IVA_Q1');
        $importe_q1 = $request->input('IMPORTE_Q1');
        $observaciones_q1 = $request->input('OBSERVACIONES_Q1');
        $fecha_q1 = $request->input('FECHA_COTIZACION_Q1');
        $proveedor_q2 = $request->input('PROVEEDOR_Q2');
        $subtotal_q2 = $request->input('SUBTOTAL_Q2');
        $iva_q2 = $request->input('IVA_Q2');
        $importe_q2 = $request->input('IMPORTE_Q2');
        $observaciones_q2 = $request->input('OBSERVACIONES_Q2');
        $fecha_q2 = $request->input('FECHA_COTIZACION_Q2');
        $proveedor_q3 = $request->input('PROVEEDOR_Q3');
        $subtotal_q3 = $request->input('SUBTOTAL_Q3');
        $iva_q3 = $request->input('IVA_Q3');
        $importe_q3 = $request->input('IMPORTE_Q3');
        $observaciones_q3 = $request->input('OBSERVACIONES_Q3');
        $fecha_q3 = $request->input('FECHA_COTIZACION_Q3');
        $proveedor_sugerido = $request->input('PROVEEDOR_SUGERIDO');
        $solicitarverificacion = $request->input('SOLICITAR_VERIFICACION');
        $fechaverificacion = $request->input('FECHA_VERIFICACION');
        $estadoaprobacion = $request->input('ESTADO_APROBACION');
        $motivorechazo = $request->input('MOTIVO_RECHAZO');
        $fechaaprobacion = $request->input('FECHA_APROBACION');
        $forma_adquisicion = $request->input('FORMA_ADQUISICION');
        $proveedor_seleccionado = $request->input('PROVEEDOR_SELECCIONADO');
        $monto_final = $request->input('MONTO_FINAL');
        $forma_pago = $request->input('FORMA_PAGO');
        $requiere_po = $request->input('REQUIERE_PO');
        $requierecomentario = $request->input('REQUIERE_COMENTARIO');
        $comentarioaprobacion = $request->input('COMENTARIO_APROBACION');

        if ($esUnico === 'SI') {
            $materiales_hoja_json = $request->input('MATERIALES_HOJA_JSON')[0] ?? null;
            $id_hoja = $ids[0] ?? null;

            $data = [
                'NO_MR' => $no_mr,
                'PROVEEDOR_Q1' => $proveedor_q1[0] ?? null,
                'SUBTOTAL_Q1' => $subtotal_q1[0] ?? null,
                'IVA_Q1' => $iva_q1[0] ?? null,
                'IMPORTE_Q1' => $importe_q1[0] ?? null,
                'OBSERVACIONES_Q1' => $observaciones_q1[0] ?? null,
                'FECHA_COTIZACION_Q1' => $fecha_q1[0] ?? null,
                'PROVEEDOR_Q2' => $proveedor_q2[0] ?? null,
                'SUBTOTAL_Q2' => $subtotal_q2[0] ?? null,
                'IVA_Q2' => $iva_q2[0] ?? null,
                'IMPORTE_Q2' => $importe_q2[0] ?? null,
                'OBSERVACIONES_Q2' => $observaciones_q2[0] ?? null,
                'FECHA_COTIZACION_Q2' => $fecha_q2[0] ?? null,
                'PROVEEDOR_Q3' => $proveedor_q3[0] ?? null,
                'SUBTOTAL_Q3' => $subtotal_q3[0] ?? null,
                'IVA_Q3' => $iva_q3[0] ?? null,
                'IMPORTE_Q3' => $importe_q3[0] ?? null,
                'OBSERVACIONES_Q3' => $observaciones_q3[0] ?? null,
                'FECHA_COTIZACION_Q3' => $fecha_q3[0] ?? null,
                'PROVEEDOR_SUGERIDO' => $proveedor_sugerido[0] ?? null,
                'SOLICITAR_VERIFICACION' => $solicitarverificacion[0] ?? null,
                'FECHA_VERIFICACION' => $fechaverificacion[0] ?? null,
                'ESTADO_APROBACION' => $estadoaprobacion[0] ?? null,
                'MOTIVO_RECHAZO' => $motivorechazo[0] ?? null,
                'FECHA_APROBACION' => $fechaaprobacion[0] ?? null,
                'FORMA_ADQUISICION' => $forma_adquisicion[0] ?? null,
                'PROVEEDOR_SELECCIONADO' => $proveedor_seleccionado[0] ?? null,
                'MONTO_FINAL' => $monto_final[0] ?? null,
                'FORMA_PAGO' => $forma_pago[0] ?? null,
                'REQUIERE_PO' => $requiere_po[0] ?? null,
                'REQUIERE_COMENTARIO' => $requierecomentario[0] ?? null,
                'COMENTARIO_APROBACION' => $comentarioaprobacion[0] ?? null,
                'MATERIALES_HOJA_JSON' => $materiales_hoja_json,
            ];

            if ($id_hoja) {
                $hoja = HojaTrabajo::find($id_hoja);
                if ($hoja) {
                    $hoja->update($data);
                } else {
                    $hoja = HojaTrabajo::create($data);
                }
            } else {
                $hoja = HojaTrabajo::create($data);
            }

            $id = $hoja->id;

            foreach (['Q1', 'Q2', 'Q3'] as $q) {
                if ($request->hasFile("DOCUMENTO_{$q}.0")) {
                    $file = $request->file("DOCUMENTO_{$q}")[0];
                    $fileName = $file->getClientOriginalName();
                    $folder = "compras/{$no_mr}/{$id}/{$q}";
                    $path = $file->storeAs($folder, $fileName);
                    $hoja["DOCUMENTO_{$q}"] = $path;
                }
            }

            $hoja->save();

            if (($solicitarverificacion[0] ?? null) === 'Sí' && !$hoja->SOLICITO_ID) {
                $hoja->SOLICITO_ID = auth()->user()->ID_USUARIO;
                $hoja->save();
            }

            // if (($requiere_po[0] ?? null) === 'Sí') {
            //     $ordenExistente = DB::table('formulario_ordencompra')
            //         ->where('HOJA_ID', $id)
            //         ->first();

            //     if (!$ordenExistente) {
            //         $año = now()->format('y');
            //         $ultimo = DB::table('formulario_ordencompra')
            //             ->where('NO_PO', 'like', "RES-PO$año-%")
            //             ->orderByDesc('ID_FORMULARIO_PO')
            //             ->value('NO_PO');

            //         $consecutivo = $ultimo ? (int)substr($ultimo, -3) + 1 : 1;
            //         $numeroOrden = sprintf("RES-PO%s-%03d", $año, $consecutivo);

            //         DB::table('formulario_ordencompra')->insert([
            //             'HOJA_ID' => $id,
            //             'NO_MR' => $no_mr,
            //             'NO_PO' => $numeroOrden,
            //             'ACTIVO' => 1,
            //             'created_at' => now(),
            //             'updated_at' => now(),
            //         ]);
            //     }
            // }

        } else {
            $descripciones = $request->input('DESCRIPCION');
            $cantidades = $request->input('CANTIDAD');
            $unidades = $request->input('UNIDAD_MEDIDA');
            $cantidadmrq1 = $request->input('CANTIDAD_MRQ1');
            $cantidadrealq1 = $request->input('CANTIDAD_REALQ1');
            $preciounitarioq1 = $request->input('PRECIO_UNITARIOQ1');
            $cantidadmrq2 = $request->input('CANTIDAD_MRQ2');
            $cantidadrealq2 = $request->input('CANTIDAD_REALQ2');
            $preciounitarioq2 = $request->input('PRECIO_UNITARIOQ2');
            $cantidadmrq3 = $request->input('CANTIDAD_MRQ3');
            $cantidadrealq3 = $request->input('CANTIDAD_REALQ3');
            $preciounitarioq3 = $request->input('PRECIO_UNITARIOQ3');

            $total = count($descripciones);

            for ($i = 0; $i < $total; $i++) {
                $data = [
                    'NO_MR' => $no_mr,
                    'DESCRIPCION' => $descripciones[$i] ?? '',
                    'CANTIDAD' => $cantidades[$i] ?? '',
                    'UNIDAD_MEDIDA' => $unidades[$i] ?? '',
                    'CANTIDAD_MRQ1' => $cantidadmrq1[$i] ?? null,
                    'CANTIDAD_REALQ1' => $cantidadrealq1[$i] ?? null,
                    'PRECIO_UNITARIOQ1' => $preciounitarioq1[$i] ?? null,
                    'CANTIDAD_MRQ2' => $cantidadmrq2[$i] ?? null,
                    'CANTIDAD_REALQ2' => $cantidadrealq2[$i] ?? null,
                    'PRECIO_UNITARIOQ2' => $preciounitarioq2[$i] ?? null,
                    'CANTIDAD_MRQ3' => $cantidadmrq3[$i] ?? null,

                    'CANTIDAD_REALQ3' => $cantidadrealq3[$i] ?? null,
                    'PRECIO_UNITARIOQ3' => $preciounitarioq3[$i] ?? null,
                    'PROVEEDOR_Q1' => $proveedor_q1[$i] ?? null,
                    'SUBTOTAL_Q1' => $subtotal_q1[$i] ?? null,
                    'IVA_Q1' => $iva_q1[$i] ?? null,
                    'IMPORTE_Q1' => $importe_q1[$i] ?? null,
                    'OBSERVACIONES_Q1' => $observaciones_q1[$i] ?? null,
                    'FECHA_COTIZACION_Q1' => $fecha_q1[$i] ?? null,
                    'PROVEEDOR_Q2' => $proveedor_q2[$i] ?? null,
                    'SUBTOTAL_Q2' => $subtotal_q2[$i] ?? null,
                    'IVA_Q2' => $iva_q2[$i] ?? null,
                    'IMPORTE_Q2' => $importe_q2[$i] ?? null,
                    'OBSERVACIONES_Q2' => $observaciones_q2[$i] ?? null,
                    'FECHA_COTIZACION_Q2' => $fecha_q2[$i] ?? null,
                    'PROVEEDOR_Q3' => $proveedor_q3[$i] ?? null,
                    'SUBTOTAL_Q3' => $subtotal_q3[$i] ?? null,
                    'IVA_Q3' => $iva_q3[$i] ?? null,
                    'IMPORTE_Q3' => $importe_q3[$i] ?? null,
                    'OBSERVACIONES_Q3' => $observaciones_q3[$i] ?? null,
                    'FECHA_COTIZACION_Q3' => $fecha_q3[$i] ?? null,
                    'PROVEEDOR_SUGERIDO' => $proveedor_sugerido[$i] ?? null,
                    'SOLICITAR_VERIFICACION' => $solicitarverificacion[$i] ?? null,
                    'FECHA_VERIFICACION' => $fechaverificacion[$i] ?? null,
                    'ESTADO_APROBACION' => $estadoaprobacion[$i] ?? null,
                    'MOTIVO_RECHAZO' => $motivorechazo[$i] ?? null,
                    'FECHA_APROBACION' => $fechaaprobacion[$i] ?? null,
                    'FORMA_ADQUISICION' => $forma_adquisicion[$i] ?? null,
                    'PROVEEDOR_SELECCIONADO' => $proveedor_seleccionado[$i] ?? null,
                    'MONTO_FINAL' => $monto_final[$i] ?? null,
                    'FORMA_PAGO' => $forma_pago[$i] ?? null,
                    'REQUIERE_PO' => $requiere_po[$i] ?? null,
                    'REQUIERE_COMENTARIO' => $requierecomentario[$i] ?? null,
                    'COMENTARIO_APROBACION' => $comentarioaprobacion[$i] ?? null,
                ];

                $hoja = !empty($ids[$i]) ? HojaTrabajo::find($ids[$i]) : null;
                if ($hoja) {
                    $hoja->update($data);
                } else {
                    $hoja = HojaTrabajo::create($data);
                }

                $id = $hoja->id;

                foreach (['Q1', 'Q2', 'Q3'] as $q) {
                    if ($request->hasFile("DOCUMENTO_{$q}.$i")) {
                        $file = $request->file("DOCUMENTO_{$q}")[$i];
                        $fileName = $file->getClientOriginalName();
                        $folder = "compras/{$no_mr}/{$id}/{$q}";
                        $path = $file->storeAs($folder, $fileName);
                        $hoja["DOCUMENTO_{$q}"] = $path;
                    }
                }

                $hoja->save();

                if (($solicitarverificacion[$i] ?? null) === 'Sí' && !$hoja->SOLICITO_ID) {
                    $hoja->SOLICITO_ID = auth()->user()->ID_USUARIO;
                    $hoja->save();
                }




                // if (($requiere_po[$i] ?? null) === 'Sí') {
                //     $ordenExistente = DB::table('formulario_ordencompra')
                //         ->where('HOJA_ID', $id)
                //         ->first();

                //     if (!$ordenExistente) {
                //         $año = now()->format('y');
                //         $ultimo = DB::table('formulario_ordencompra')
                //             ->where('NO_PO', 'like', "RES-PO$año-%")
                //             ->orderByDesc('ID_FORMULARIO_PO')
                //             ->value('NO_PO');

                //         $consecutivo = $ultimo ? (int)substr($ultimo, -3) + 1 : 1;
                //         $numeroOrden = sprintf("RES-PO%s-%03d", $año, $consecutivo);

                //         DB::table('formulario_ordencompra')->insert([
                //             'HOJA_ID' => $id,
                //             'NO_MR' => $no_mr,
                //             'NO_PO' => $numeroOrden,
                //             'ACTIVO' => 1,
                //             'created_at' => now(),
                //             'updated_at' => now(),
                //         ]);
                //     }
                // }
            }
        }

        return response()->json(['success' => true]);
    }






    public function mostrarcotizacionq1($id)
    {
        $archivo = HojaTrabajo::findOrFail($id)->DOCUMENTO_Q1;
        return Storage::response($archivo);
    }



    public function mostrarcotizacionq2($id)
    {
        $archivo = HojaTrabajo::findOrFail($id)->DOCUMENTO_Q2;
        return Storage::response($archivo);
    }




    public function mostrarcotizacionq3($id)
    {
        $archivo = HojaTrabajo::findOrFail($id)->DOCUMENTO_Q3;
        return Storage::response($archivo);
    }



    public function obtenerPorMR($no_mr)
    {
        $hojas = HojaTrabajo::where('NO_MR', $no_mr)->get();

        foreach ($hojas as $hoja) {
            $hoja->ES_UNICO_PROVEEDOR = $hoja->MATERIALES_HOJA_JSON ? 'SI' : 'NO';
        }

        return response()->json([
            'success' => true,
            'data' => $hojas
        ]);
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
