<?php

namespace App\Http\Controllers\solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\solicitudes\solicitudesModel;
use App\Models\solicitudes\verificacionsolicitudModel;


use App\Models\solicitudes\catalogomediocontactoModel;
use App\Models\solicitudes\catalonecesidadModel;
use App\Models\solicitudes\catalogiroempresaModel;
use App\Models\solicitudes\catalogolineanegociosModel;
use App\Models\solicitudes\catalogotiposervicioModel;



class solicitudesController extends Controller
{




    // public function index()
    // {
    //     $medios = catalogomediocontactoModel::where('ACTIVO', 1)->get();
    //     $necesidades = catalonecesidadModel::where('ACTIVO', 1)->get();
    //     $giros = catalogiroempresaModel::where('ACTIVO', 1)->get();
    //     $lineas = catalogolineanegociosModel::where('ACTIVO', 1)->get();
    //     $tipos = catalogotiposervicioModel::where('ACTIVO', 1)->get();

    //     return view('ventas.solicitudes.solicitudes', compact('medios', 'necesidades', 'giros', 'lineas', 'tipos'))
    //         ->with('route', 'Solicitudes');
    // }



    public function index()
    {


        $medios = catalogomediocontactoModel::where('ACTIVO', 1)->get();
        $necesidades = catalonecesidadModel::where('ACTIVO', 1)->get();
        $giros = catalogiroempresaModel::where('ACTIVO', 1)->get();

        $lineas = catalogolineanegociosModel::where('ACTIVO', 1)->get();
        $tipos = catalogotiposervicioModel::where('ACTIVO', 1)->get();


        return view('ventas.solicitudes.solicitudes', compact('medios', 'necesidades','giros', 'lineas', 'tipos'));


    }




    public function Tablasolicitudes()
    {
        try {
            $tabla = solicitudesModel::get();

            $rows = [];
            foreach ($tabla as $value) {
                $verificaciones = verificacionsolicitudModel::where('SOLICITUD_ID', $value->ID_FORMULARIO_SOLICITUDES)->get();

                $verificacionesAgrupadas = $verificaciones->map(function ($verificacion) {
                    return [
                        'VERIFICADO_EN' => $verificacion->VERIFICADO_EN,
                        'EVIDENCIA_VERIFICACION' => $verificacion->EVIDENCIA_VERIFICACION,
                        'BTN_DOCUMENTO' => '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-verificacion" data-id="' . $verificacion->ID_VERIFICACION_SOLICITUD . '" title="Ver evidencia"> <i class="bi bi-filetype-pdf"></i></button>'
                    ];
                });
                $rows[] = array_merge($value->toArray(), [
                    'SOLICITAR_VERIFICACION' => $value->SOLICITAR_VERIFICACION,
                    'PROCEDE_COTIZAR' => $value->PROCEDE_COTIZAR,
                    'MOTIVO_COTIZACION' => $value->MOTIVO_COTIZACION, 
                    'VERIFICACIONES' => $verificacionesAgrupadas,
                    'BTN_EDITAR' => ($value->ACTIVO == 0) ?
                        '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>' :
                        '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
                    'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>',
                    'BTN_ELIMINAR' => '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_SOLICITUDES . '"' . ($value->ACTIVO ? ' checked' : '') . '><span class="slider round"></span></label>',
                    'BTN_CORREO' => ($value->ACTIVO == 0) ?
                        '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" disabled><i class="bi bi-ban"></i></button>' :
                        '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>',
                ]);

            }

            return response()->json([
                'data' => $rows,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }




    public function mostrarverificacioncliente($id)
    {
        $archivo = verificacionsolicitudModel::findOrFail($id)->EVIDENCIA_VERIFICACION;
        return Storage::response($archivo);
    }


    public function actualizarSolicitud(Request $request)
    {
        $solicitud = solicitudesModel::find($request->ID_FORMULARIO_SOLICITUDES);

        if ($solicitud) {
            $solicitud->SOLICITAR_VERIFICACION = 1;
            $solicitud->save();

            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente']);
        }

        return response()->json(['success' => false, 'message' => 'No se encontró la solicitud']);
    }




    public function actualizarEstatusSolicitud(Request $request)
    {
        try {
            $request->validate([
                'ID_FORMULARIO_SOLICITUDES' => 'required|exists:formulario_solicitudes,ID_FORMULARIO_SOLICITUDES',
                'ESTATUS_SOLICITUD' => 'required|string|in:Aceptada,Revisión,Rechazada',
                'MOTIVO_RECHAZO' => 'nullable|string|max:255'
            ]);

            // Buscar la solicitud
            $solicitud = solicitudesModel::find($request->ID_FORMULARIO_SOLICITUDES);

            // Actualizar los datos
            $solicitud->ESTATUS_SOLICITUD = $request->ESTATUS_SOLICITUD;
            $solicitud->MOTIVO_RECHAZO = $request->ESTATUS_SOLICITUD === 'Rechazada' ? $request->MOTIVO_RECHAZO : null;
            $solicitud->save();

            return response()->json([
                'success' => true,
                'message' => 'Estatus actualizado correctamente.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estatus: ' . $e->getMessage()
            ], 500);
        }
    }



    // public function store(Request $request)
    // {
    //     try {
    //         switch (intval($request->api)) {

    //             case 1:
    //                 if ($request->ID_FORMULARIO_SOLICITUDES == 0) {
    //                     $ultimoRegistro = solicitudesModel::orderBy('ID_FORMULARIO_SOLICITUDES', 'desc')->first();
    //                     $numeroIncremental = $ultimoRegistro ? intval(substr($ultimoRegistro->NO_SOLICITUD, 0, 3)) + 1 : 1;
    //                     $anioActual = date('Y');
    //                     $ultimoDigitoAnio = substr($anioActual, -2);
    //                     $noSolicitud = str_pad($numeroIncremental, 3, '0', STR_PAD_LEFT) . '-' . $ultimoDigitoAnio;

    //                     $request->merge(['NO_SOLICITUD' => $noSolicitud]);

    //                     DB::statement('ALTER TABLE formulario_solicitudes AUTO_INCREMENT=1;');

    //                     $data = $request->except(['observacion','contactos','direcciones']);
    //                     $solicitudes = solicitudesModel::create($data);

    //                     $response['code'] = 1;
    //                     $response['solicitud'] = $solicitudes;
    //                     return response()->json($response);
    //                 } else {
    //                     if (isset($request->ELIMINAR)) {
    //                         if ($request->ELIMINAR == 1) {
    //                             solicitudesModel::where('ID_FORMULARIO_SOLICITUDES', $request['ID_FORMULARIO_SOLICITUDES'])
    //                                 ->update(['ACTIVO' => 0]);
    //                             $response['code'] = 1;
    //                             $response['solicitud'] = 'Desactivada';
    //                         } else {
    //                             solicitudesModel::where('ID_FORMULARIO_SOLICITUDES', $request['ID_FORMULARIO_SOLICITUDES'])
    //                                 ->update(['ACTIVO' => 1]);
    //                             $response['code'] = 1;
    //                             $response['solicitud'] = 'Activada';
    //                         }
    //                     } else {
    //                         $solicitudes = solicitudesModel::find($request->ID_FORMULARIO_SOLICITUDES);
    //                         $solicitudes->update($request->except('FOTO_USUARIO'));

    //                         $response['code'] = 1;
    //                         $response['solicitud'] = 'Actualizada';
    //                     }
    //                     return response()->json($response);
    //                 }
    //                 break;


    //             default:
    //                 $response['code'] = 1;
    //                 $response['msj'] = 'Api no encontrada';
    //                 return response()->json($response);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json(['error' => 'Error al guardar la solicitud', 'message' => $e->getMessage()]);
    //     }
    // }





    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_SOLICITUDES == 0) {
                        $ultimoRegistro = solicitudesModel::orderBy('ID_FORMULARIO_SOLICITUDES', 'desc')->first();
                        $numeroIncremental = $ultimoRegistro ? intval(substr($ultimoRegistro->NO_SOLICITUD, 0, 3)) + 1 : 1;
                        $anioActual = date('Y');
                        $ultimoDigitoAnio = substr($anioActual, -2);
                        $noSolicitud = str_pad($numeroIncremental, 3, '0', STR_PAD_LEFT) . '-' . $ultimoDigitoAnio;

                        $request->merge(['NO_SOLICITUD' => $noSolicitud]);

                        DB::statement('ALTER TABLE formulario_solicitudes AUTO_INCREMENT=1;');

                        $data = $request->except(['observacion', 'contactos', 'direcciones']);
                        $solicitudes = solicitudesModel::create($data);

                        $solicitudId = $solicitudes->ID_FORMULARIO_SOLICITUDES;

                        $response['code'] = 1;
                        $response['solicitud'] = $solicitudes;
                    } else {
                        $solicitudes = solicitudesModel::find($request->ID_FORMULARIO_SOLICITUDES);
                        if (!$solicitudes) {
                            throw new Exception("Solicitud no encontrada");
                        }
                        $solicitudes->update($request->except('FOTO_USUARIO'));
                        $solicitudId = $solicitudes->ID_FORMULARIO_SOLICITUDES;
                        $response['code'] = 1;
                        $response['solicitud'] = 'Actualizada';
                    }

                    if ($request->has('VERIFICADO_EN')) {
                        foreach ($request->VERIFICADO_EN as $index => $verificadoEn) {
                            $archivoPath = verificacionsolicitudModel::where('SOLICITUD_ID', $solicitudId)
                                ->where('VERIFICADO_EN', $verificadoEn)
                                ->value('EVIDENCIA_VERIFICACION');

                            if ($request->hasFile("EVIDENCIA_VERIFICACION.$index")) {
                                $baseFolder = "ventas/solicitudes/$solicitudId/";

                                if (!Storage::exists($baseFolder)) {
                                    Storage::makeDirectory($baseFolder);
                                }

                                $archivoFile = $request->file("EVIDENCIA_VERIFICACION.$index");

                                if ($archivoPath && Storage::exists($archivoPath)) {
                                    Storage::delete($archivoPath);
                                }

                                $archivoFileName = $archivoFile->getClientOriginalName();
                                $archivoFile->storeAs($baseFolder, $archivoFileName);

                                $archivoPath = $baseFolder . $archivoFileName;
                            }

                            verificacionsolicitudModel::updateOrCreate(
                                [
                                    'SOLICITUD_ID' => $solicitudId,
                                    'VERIFICADO_EN' => $verificadoEn,
                                ],
                                [
                                    'EVIDENCIA_VERIFICACION' => $archivoPath,
                                ]
                            );
                        }
                    }

                    DB::commit();
                    return response()->json($response);
                    break;

                default:
                    DB::rollback();
                    $response['code'] = 1;
                    $response['msj'] = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al guardar la solicitud', 'message' => $e->getMessage()]);
        }
    }



}
