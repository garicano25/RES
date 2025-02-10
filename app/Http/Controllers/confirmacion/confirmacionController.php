<?php

namespace App\Http\Controllers\confirmacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;

use App\Models\solicitudes\solicitudesModel;
use App\Models\ofertas\ofertasModel;

use App\Models\confirmacion\confirmacionModel;



class confirmacionController extends Controller
{
    public function index()
    {
        $solicitudes = ofertasModel::select(
            'ID_FORMULARIO_OFERTAS',
            'NO_OFERTA',
          
        )
            ->where('ESTATUS_OFERTA', 'like', '%Aceptada%')
            ->get();

     

        return view('ventas.confirmacion.confirmacion', compact('solicitudes'));
    }


    public function Tablaconfirmacion()
    {
        try {
            $tabla = confirmacionModel::select(
                'formulario_confirmacion.*',
                'formulario_ofertas.NO_OFERTA',

            )
                ->leftJoin(
                'formulario_ofertas',
                'formulario_confirmacion.OFERTA_ID',
                    '=',
                'formulario_ofertas.ID_FORMULARIO_OFERTAS'
                )
                ->get();


            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONFRIMACION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" disabled><i class="bi  bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-aceptacion" data-id="' . $value->ID_FORMULARIO_CONFRIMACION . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONFRIMACION . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-aceptacion" data-id="' . $value->ID_FORMULARIO_CONFRIMACION . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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

    public function mostraraceptacion($id)
    {
        $archivo = confirmacionModel::findOrFail($id)->DOCUMENTO_ACEPTACION;
        return Storage::response($archivo);
    }



    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_CONFRIMACION == 0) {
                        DB::statement('ALTER TABLE formulario_confirmacion AUTO_INCREMENT=1;');
                        $confirmaciones = confirmacionModel::create($request->except('DOCUMENTO_ACEPTACION'));

                        $idconfirmacion = $confirmaciones->ID_FORMULARIO_CONFRIMACION;

                        if ($request->hasFile('DOCUMENTO_ACEPTACION')) {
                            $archivo = $request->file('DOCUMENTO_ACEPTACION');
                            $nombreArchivo = $archivo->getClientOriginalName(); 
                            $rutaCarpeta = "ventas/confirmación/$idconfirmacion";
                            $rutaCompleta = $archivo->storeAs($rutaCarpeta, $nombreArchivo);

                            $confirmaciones->DOCUMENTO_ACEPTACION = $rutaCompleta;
                            $confirmaciones->save();
                        }
                    } else {
                        $confirmaciones = confirmacionModel::find($request->ID_FORMULARIO_CONFRIMACION);
                        if (!$confirmaciones) {
                            return response()->json(['error' => 'Registro no encontrado'], 404);
                        }

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $confirmaciones->update(['ACTIVO' => 0]);
                                $response['confirmacion'] = 'Desactivada';
                            } else {
                                $confirmaciones->update(['ACTIVO' => 1]);
                                $response['confirmacion'] = 'Activada';
                            }
                        } else {
                            $confirmaciones->update($request->except('DOCUMENTO_ACEPTACION'));

                            if ($request->hasFile('DOCUMENTO_ACEPTACION')) {
                                if ($confirmaciones->DOCUMENTO_ACEPTACION && Storage::exists($confirmaciones->DOCUMENTO_ACEPTACION)) {
                                    Storage::delete($confirmaciones->DOCUMENTO_ACEPTACION);
                                }

                                $archivo = $request->file('DOCUMENTO_ACEPTACION');
                                $nombreArchivo = $archivo->getClientOriginalName();
                                $rutaCarpeta = "ventas/confirmación/" . $confirmaciones->ID_FORMULARIO_CONFRIMACION;
                                $rutaCompleta = $archivo->storeAs($rutaCarpeta, $nombreArchivo);

                                $confirmaciones->DOCUMENTO_ACEPTACION = $rutaCompleta;
                                $confirmaciones->save();
                            }

                            $response['confirmacion'] = 'Actualizada';
                        }
                    }

                    $response['code'] = 1;
                    $response['confirmacion'] = $confirmaciones;
                    return response()->json($response);

                default:
                    return response()->json(['code' => 1, 'msj' => 'Api no encontrada']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar la confirmación', 'message' => $e->getMessage()], 500);
        }
    }

    
}
