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
            $tabla = confirmacionModel::get();

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



    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_CONFRIMACION == 0) {
                        DB::statement('ALTER TABLE formulario_confirmacion AUTO_INCREMENT=1;');
                        $confirmaciones = confirmacionModel::create($request->all());
                    } else { 

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $confirmaciones = confirmacionModel::where('ID_FORMULARIO_CONFRIMACION', $request['ID_FORMULARIO_CONFRIMACION'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['confirmacion'] = 'Desactivada';
                            } else {
                                $confirmaciones = confirmacionModel::where('ID_FORMULARIO_CONFRIMACION', $request['ID_FORMULARIO_CONFRIMACION'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['confirmacion'] = 'Activada';
                            }
                        } else {
                            $confirmaciones = confirmacionModel::find($request->ID_FORMULARIO_CONFRIMACION);
                            $confirmaciones->update($request->all());
                            $response['code'] = 1;
                            $response['confirmacion'] = 'Actualizada';
                        }
                        return response()->json($response);

                    }
                    $response['code']  = 1;
                    $response['confirmacion']  = $confirmaciones;
                    return response()->json($response);
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
