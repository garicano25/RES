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

use App\Models\solicitudes\catalogomediocontactoModel;
use App\Models\solicitudes\catalonecesidadModel;
use App\Models\solicitudes\catalogiroempresaModel;
use App\Models\solicitudes\catalogolineanegociosModel;
use App\Models\solicitudes\catalogotiposervicioModel;



class solicitudesController extends Controller
{


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

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_SOLICITUDES . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" disabled><i class="bi  bi-ban"></i></button>';

                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_SOLICITUDES . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
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

    public function actualizarEstatusSolicitud(Request $request)
    {
        try {
            // Validar los datos recibidos
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



    public function store(Request $request)
    {
        try {
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
                
                        $data = $request->except(['observacion','contactos','direcciones']);
                        $solicitudes = solicitudesModel::create($data);
                
                        $response['code'] = 1;
                        $response['solicitud'] = $solicitudes;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                solicitudesModel::where('ID_FORMULARIO_SOLICITUDES', $request['ID_FORMULARIO_SOLICITUDES'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['solicitud'] = 'Desactivada';
                            } else {
                                solicitudesModel::where('ID_FORMULARIO_SOLICITUDES', $request['ID_FORMULARIO_SOLICITUDES'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['solicitud'] = 'Activada';
                            }
                        } else {
                            $solicitudes = solicitudesModel::find($request->ID_FORMULARIO_SOLICITUDES);
                            $solicitudes->update($request->except('FOTO_USUARIO'));
                
                            $response['code'] = 1;
                            $response['solicitud'] = 'Actualizada';
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
            return response()->json(['error' => 'Error al guardar la solicitud', 'message' => $e->getMessage()]);
        }
    }




}
