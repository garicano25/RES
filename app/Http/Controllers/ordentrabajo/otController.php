<?php

namespace App\Http\Controllers\ordentrabajo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;

use App\Models\ofertas\ofertasModel;

use App\Models\ordentrabajo\otModel;

class otController extends Controller
{
    public function index()
    {
        $ofertasJSON = DB::table('formulario_ordentrabajo')->pluck('OFERTA_ID');
        $ofertasUsadas = [];

        foreach ($ofertasJSON as $json) {
            $ids = json_decode($json, true);
            if (is_array($ids)) {
                $ofertasUsadas = array_merge($ofertasUsadas, $ids);
            }
        }

        $ofertasUsadas = array_unique($ofertasUsadas);

        $ofertasPermitidas = DB::table('formulario_ordentrabajo')
            ->where('UTILIZAR_COTIZACION', 1)
            ->pluck('OFERTA_ID')
            ->toArray();

        $ofertasPermitidasIds = [];
        foreach ($ofertasPermitidas as $json) {
            $ids = json_decode($json, true);
            if (is_array($ids)) {
                $ofertasPermitidasIds = array_merge($ofertasPermitidasIds, $ids);
            }
        }

       
        $idsParaMostrar = array_diff($ofertasUsadas, $ofertasPermitidasIds);
        $ofertasFinales = array_diff($ofertasUsadas, $idsParaMostrar); 

        $solicitudes = DB::table('formulario_confirmacion as fc')
            ->join('formulario_ofertas as fo', 'fc.OFERTA_ID', '=', 'fo.ID_FORMULARIO_OFERTAS')
            ->select('fo.ID_FORMULARIO_OFERTAS', 'fo.NO_OFERTA')
            ->where('fc.PROCEDE_ORDEN', 1)
            ->where(function ($query) use ($ofertasUsadas, $ofertasFinales) {
                $query->whereNotIn('fo.ID_FORMULARIO_OFERTAS', $ofertasUsadas)
                    ->orWhereIn('fo.ID_FORMULARIO_OFERTAS', $ofertasFinales);
            })
            ->get();

        return view('ventas.orden_trabajo.orden_trabajo', compact('solicitudes'));
    }



    public function obtenerDatosOferta(Request $request)
    {
        $ofertaIds = $request->input('oferta_ids', []);

        $datos = DB::table('formulario_ofertas as fo')
            ->join('formulario_solicitudes as fs', 'fo.SOLICITUD_ID', '=', 'fs.ID_FORMULARIO_SOLICITUDES')
            ->join('catalogo_giroempresa as cg', 'fs.GIRO_EMPRESA_SOLICITUD', '=', 'cg.ID_CATALOGO_GIRO_EMPRESA')
            ->select(
                'fs.RAZON_SOCIAL_SOLICITUD',
                'fs.NOMBRE_COMERCIAL_SOLICITUD',
                'fs.RFC_SOLICITUD',
                'cg.NOMBRE_GIRO as GIRO_EMPRESA',
                'fs.DIRECCIONES_JSON',
                'fs.CONTACTOS_JSON'
            )
            ->whereIn('fo.ID_FORMULARIO_OFERTAS', $ofertaIds)
            ->get();

        $razonesSociales = $datos->pluck('RAZON_SOCIAL_SOLICITUD')->unique()->values();
        $comerciales = $datos->pluck('NOMBRE_COMERCIAL_SOLICITUD')->unique()->values();
        $rfcs = $datos->pluck('RFC_SOLICITUD')->unique()->values();
        $giros = $datos->pluck('GIRO_EMPRESA')->unique()->values();

        // Direcciones
        $direcciones = [];
        foreach ($datos as $registro) {
            if ($registro->DIRECCIONES_JSON) {
                $json = json_decode($registro->DIRECCIONES_JSON, true);
                if (is_array($json)) {
                    foreach ($json as $dir) {
                        $direccionFormateada = trim(
                            $dir['NOMBRE_VIALIDAD_DOMICILIO'] . ' No. ' . $dir['NUMERO_EXTERIOR_DOMICILIO'] .
                                (empty($dir['NOMBRE_COLONIA_DOMICILIO']) ? '' : ', Colonia ' . $dir['NOMBRE_COLONIA_DOMICILIO']) .
                                ', C.P. ' . $dir['CODIGO_POSTAL_DOMICILIO'] .
                                ', ' . $dir['NOMBRE_LOCALIDAD_DOMICILIO'] .
                                ', ' . $dir['NOMBRE_ENTIDAD_DOMICILIO'] .
                                ', ' . $dir['PAIS_CONTRATACION_DOMICILIO']
                        );
                        $direcciones[] = $direccionFormateada;
                    }
                }
            }
        }
        $direcciones = array_values(array_unique($direcciones));

        // Contactos
        $contactosNombres = [];
        $contactosCompletos = [];

        foreach ($datos as $registro) {
            if ($registro->CONTACTOS_JSON) {
                $json = json_decode($registro->CONTACTOS_JSON, true);
                if (is_array($json)) {
                    foreach ($json as $contacto) {
                        $nombre = trim($contacto['CONTACTO_SOLICITUD']);
                        if (!in_array($nombre, $contactosNombres)) {
                            $contactosNombres[] = $nombre;
                        }
                        if (!isset($contactosCompletos[$nombre])) {
                            $contactosCompletos[$nombre] = [
                                'nombre' => $nombre,
                                'telefono' => $contacto['TELEFONO_SOLICITUD'] ?? '',
                                'celular' => $contacto['CELULAR_SOLICITUD'] ?? '',
                                'correo' => $contacto['CORREO_SOLICITUD'] ?? ''
                            ];
                        }
                    }
                }
            }
        }

        return response()->json([
            'razones' => $razonesSociales,
            'comerciales' => $comerciales,
            'rfcs' => $rfcs,
            'giros' => $giros,
            'direcciones' => $direcciones,
            'contactos' => $contactosNombres,
            'contactos_completos' => array_values($contactosCompletos)
        ]);
    }






    public function Tablaordentrabajo()
    {
        try {
            $tabla = otModel::select('formulario_ordentrabajo.*')->get();

            foreach ($tabla as $value) {
                $ofertaIds = !empty($value->OFERTA_ID) ? json_decode($value->OFERTA_ID, true) : [];

                if (!empty($ofertaIds)) {
                    $ofertas = DB::table('formulario_ofertas')
                        ->whereIn('ID_FORMULARIO_OFERTAS', $ofertaIds)
                        ->pluck('NO_OFERTA')
                        ->toArray();

                    $value->NO_OFERTA = implode(', ', $ofertas);

                    $value->NO_OFERTA_HTML = implode('<br>', $ofertas);
                } else {
                    $value->NO_OFERTA = "Sin oferta";
                    $value->NO_OFERTA_HTML = "Sin oferta";
                }

                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ORDEN . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" disabled><i class="bi  bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ORDEN . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
                }
            }

            return response()->json([
                'data' => $tabla,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }



    // public function store(Request $request)
    // {
    //     try {
    //         switch (intval($request->api)) {
    //             case 1:
    //                 if ($request->ID_FORMULARIO_ORDEN == 0) {
    //                     DB::statement('ALTER TABLE formulario_ordentrabajo AUTO_INCREMENT=1;');

    //                     $year = date('y');
    //                     $lastOrder = otModel::where('NO_ORDEN_CONFIRMACION', 'like', "RESOT-$year-%")
    //                     ->orderBy('NO_ORDEN_CONFIRMACION', 'desc')
    //                     ->first();

    //                     $nextNumber = $lastOrder ? intval(substr($lastOrder->NO_ORDEN_CONFIRMACION, -3)) + 1 : 1;
    //                     $noOrdenConfirmacion = sprintf("RESOT-%s-%03d", $year, $nextNumber);

    //                     $ofertaArray = $request->filled('OFERTA_ID') ? json_encode($request->input('OFERTA_ID')) : json_encode([]);

    //                     $ordenes = otModel::create(array_merge($request->all(), [
    //                         'NO_ORDEN_CONFIRMACION' => $noOrdenConfirmacion,
    //                         'OFERTA_ID' => $ofertaArray 
    //                     ]));

    //                     return response()->json([
    //                         'code' => 1,
    //                         'orden' => $ordenes
    //                     ]);
    //                 } else {
    //                     if (isset($request->ELIMINAR)) {
    //                         $estado = $request->ELIMINAR == 1 ? 0 : 1;
    //                         otModel::where('ID_FORMULARIO_ORDEN', $request->ID_FORMULARIO_ORDEN)
    //                             ->update(['ACTIVO' => $estado]);

    //                         return response()->json([
    //                             'code' => 1,
    //                             'orden' => $estado == 0 ? 'Desactivada' : 'Activada'
    //                         ]);
    //                     } else {
    //                         $ordenes = otModel::find($request->ID_FORMULARIO_ORDEN);
    //                         if ($ordenes) {
    //                             $ofertaArray = $request->filled('OFERTA_ID') ? json_encode($request->input('OFERTA_ID')) : json_encode([]);

    //                             $ordenes->update(array_merge($request->all(), [
    //                                 'OFERTA_ID' => $ofertaArray
    //                             ]));

    //                             return response()->json([
    //                                 'code' => 1,
    //                                 'orden' => 'Actualizada'
    //                             ]);
    //                         }
    //                         return response()->json([
    //                             'code' => 0,
    //                             'msj' => 'Orden no encontrada'
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
    //         Log::error("Error al guardar orden: " . $e->getMessage());
    //         return response()->json([
    //             'code' => 0,
    //             'error' => 'Error al guardar la orden'
    //         ], 500);
    //     }
    // }


    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_ORDEN == 0) {
                        DB::statement('ALTER TABLE formulario_ordentrabajo AUTO_INCREMENT=1;');

                        $year = date('y');
                        $lastOrder = otModel::where('NO_ORDEN_CONFIRMACION', 'like', "RESOT-$year-%")
                            ->orderBy('NO_ORDEN_CONFIRMACION', 'desc')
                            ->first();

                        $nextNumber = $lastOrder ? intval(substr($lastOrder->NO_ORDEN_CONFIRMACION, -3)) + 1 : 1;
                        $noOrdenConfirmacion = sprintf("RESOT-%s-%03d", $year, $nextNumber);

                        $ofertaArray = $request->filled('OFERTA_ID') ? json_encode($request->input('OFERTA_ID')) : json_encode([]);
                        $serviciosJson = $request->filled('SERVICIOS_JSON') ? $request->input('SERVICIOS_JSON') : json_encode([]);

                        $ordenes = otModel::create(array_merge($request->all(), [
                            'NO_ORDEN_CONFIRMACION' => $noOrdenConfirmacion,
                            'OFERTA_ID' => $ofertaArray,
                            'SERVICIOS_JSON' => $serviciosJson
                        ]));

                        return response()->json([
                            'code' => 1,
                            'orden' => $ordenes
                        ]);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            otModel::where('ID_FORMULARIO_ORDEN', $request->ID_FORMULARIO_ORDEN)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'orden' => $estado == 0 ? 'Desactivada' : 'Activada'
                            ]);
                        } else {
                            $ordenes = otModel::find($request->ID_FORMULARIO_ORDEN);
                            if ($ordenes) {
                                $ofertaArray = $request->filled('OFERTA_ID') ? json_encode($request->input('OFERTA_ID')) : json_encode([]);
                                $serviciosJson = $request->filled('SERVICIOS_JSON') ? $request->input('SERVICIOS_JSON') : json_encode([]);

                                $ordenes->update(array_merge($request->all(), [
                                    'OFERTA_ID' => $ofertaArray,
                                    'SERVICIOS_JSON' => $serviciosJson
                                ]));

                                return response()->json([
                                    'code' => 1,
                                    'orden' => 'Actualizada'
                                ]);
                            }
                            return response()->json([
                                'code' => 0,
                                'msj' => 'Orden no encontrada'
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
            Log::error("Error al guardar orden: " . $e->getMessage());
            return response()->json([
                'code' => 0,
                'error' => 'Error al guardar la orden'
            ], 500);
        }
    }
}
