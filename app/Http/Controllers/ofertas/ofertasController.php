<?php

namespace App\Http\Controllers\ofertas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\solicitudes\solicitudesModel;

use App\Models\ofertas\ofertasModel;



class ofertasController extends Controller
{
    public function index()
    {
        $solicitudesAceptadas = solicitudesModel::select(
            'ID_FORMULARIO_SOLICITUDES',
            'NO_SOLICITUD',
            'NOMBRE_COMERCIAL_SOLICITUD'
        )
        ->where('ESTATUS_SOLICITUD', 'like', '%Aceptada%')
        ->get();
    
        $idsAsociados = ofertasModel::pluck('SOLICITUD_ID')->toArray();
    
        $solicitudes = $solicitudesAceptadas->filter(function ($solicitud) use ($idsAsociados) {
            return !in_array($solicitud->ID_FORMULARIO_SOLICITUDES, $idsAsociados);
        });
    
        return view('ventas.ofertas', compact('solicitudes'));
    }
    


    public function Tablaofertas()
    {
        try {
            $tabla = ofertasModel::select(
                'formulario_ofertas.*', 
                'formulario_solicitudes.NO_SOLICITUD'
            )
            ->leftJoin(
                'formulario_solicitudes', 
                'formulario_ofertas.SOLICITUD_ID', 
                '=', 
                'formulario_solicitudes.ID_FORMULARIO_SOLICITUDES' 
            )
            ->get();
    
            $solicitudesAceptadas = solicitudesModel::select(
                'ID_FORMULARIO_SOLICITUDES',
                'NO_SOLICITUD',
                'NOMBRE_COMERCIAL_SOLICITUD'
            )
            ->where('ESTATUS_SOLICITUD', 'like', '%Aceptada%')
            ->get();
    
            $idsAsociados = ofertasModel::pluck('SOLICITUD_ID')->toArray();
    
            foreach ($tabla as $value) {
                $solicitudesDisponibles = $solicitudesAceptadas->filter(function ($solicitud) use ($idsAsociados, $value) {
                    return !in_array($solicitud->ID_FORMULARIO_SOLICITUDES, $idsAsociados) || 
                           $solicitud->ID_FORMULARIO_SOLICITUDES == $value->SOLICITUD_ID;
                });
    
                $value->SOLICITUDES = $solicitudesDisponibles->values(); 
    
                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_OFERTAS . '"><span class="slider round"></span></label>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
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
    
    
    



    public function actualizarEstatusOferta(Request $request)
    {
        try {
            $request->validate([
                'ID_FORMULARIO_OFERTAS' => 'required|exists:formulario_ofertas,ID_FORMULARIO_OFERTAS',
                'ESTATUS_OFERTA' => 'required|string|in:Aceptada,Revision,Rechazada',
                'MOTIVO_RECHAZO' => 'nullable|string|max:255',
                'ACEPTADA_OFERTA' => 'nullable|string|max:255',
                'FECHA_ACEPTACION_OFERTA' => 'nullable|date',
                'FECHA_FIRMA_OFERTA' => 'nullable|date'
            ]);
    
            $oferta = ofertasModel::find($request->ID_FORMULARIO_OFERTAS);
    
            $oferta->ESTATUS_OFERTA = $request->ESTATUS_OFERTA;
            $oferta->MOTIVO_RECHAZO = $request->ESTATUS_OFERTA === 'Rechazada' ? $request->MOTIVO_RECHAZO : null;
    
            if ($request->ESTATUS_OFERTA === 'Aceptada') {
                $oferta->ACEPTADA_OFERTA = $request->ACEPTADA_OFERTA;
                $oferta->FECHA_ACEPTACION_OFERTA = $request->FECHA_ACEPTACION_OFERTA;
                $oferta->FECHA_FIRMA_OFERTA = $request->FECHA_FIRMA_OFERTA;
            }
    
            $oferta->save();
    
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
    



    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_OFERTAS == 0) {
                        // Generar el número dinámico NO_OFERTA
                        $ultimoRegistro = ofertasModel::orderBy('ID_FORMULARIO_OFERTAS', 'desc')->first();
                        $numeroIncremental = $ultimoRegistro ? intval(substr($ultimoRegistro->NO_OFERTA, -3)) + 1 : 1;
                        $anioActual = date('Y');
                        
                        // Formatear el NO_OFERTA como RES-COT-(año)-[tres dígitos]
                        $noOferta = 'RES-COT-' . $anioActual . '-' . str_pad($numeroIncremental, 3, '0', STR_PAD_LEFT);
                        $request->merge(['NO_OFERTA' => $noOferta]);
    
                        // Reiniciar el AUTO_INCREMENT si es necesario
                        DB::statement('ALTER TABLE formulario_ofertas AUTO_INCREMENT=1;');
                        $ofertas = ofertasModel::create($request->all());
    
                        $response['code'] = 1;
                        $response['oferta'] = $ofertas;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                ofertasModel::where('ID_FORMULARIO_OFERTAS', $request['ID_FORMULARIO_OFERTAS'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['oferta'] = 'Desactivada';
                            } else {
                                ofertasModel::where('ID_FORMULARIO_OFERTAS', $request['ID_FORMULARIO_OFERTAS'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['oferta'] = 'Activada';
                            }
                        } else {
                            $ofertas = ofertasModel::find($request->ID_FORMULARIO_OFERTAS);
                            $ofertas->update($request->all());
                            $response['code'] = 1;
                            $response['oferta'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    break;
                default:
                    $response['code'] = 1;
                    $response['msj'] = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar la oferta', 'message' => $e->getMessage()]);
        }
    }
    




}
