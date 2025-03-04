<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB; 

use App\Models\proveedor\directorioModel;

class directorioController extends Controller
{
    public function Tabladirectorio()
    {
        try {
            $tabla = directorioModel::get();
    
            foreach ($tabla as $value) {
                
            
    
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
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


    public function mostrarconstanciaproveedor($id)
    {
        $archivo = directorioModel::findOrFail($id)->CONSTANCIA_DOCUMENTO;
        return Storage::response($archivo);
    }


    public function actualizarinfoproveedor(Request $request)
    {
        $rfc = $request->input('rfc');
        $rfcInfo = directorioModel::where('RFC_PROVEEDOR', $rfc)->first();

        if ($rfcInfo) {
            $rfcInfo->SERVICIOS_JSON = json_decode($rfcInfo->SERVICIOS_JSON, true);
            return response()->json($rfcInfo);
        } else {
            return response()->json(['message' => 'No se encontró el RFC.'], 404);
        }
    }


    //     public function store(Request $request)
    //         {
    //             try {
    //                 switch (intval($request->api)) {
    //                     case 1:
    //                         if ($request->ID_FORMULARIO_DIRECTORIO == 0) {
    //                             DB::statement('ALTER TABLE formulario_directorio AUTO_INCREMENT=1;');

    //                             $data = $request->except(['servicios']);
    //                              $servicios = directorioModel::create($data);
    //                         } else { 

    //                             if (isset($request->ELIMINAR)) {
    //                                 if ($request->ELIMINAR == 1) {
    //                                     $servicios = directorioModel::where('ID_FORMULARIO_DIRECTORIO', $request['ID_FORMULARIO_DIRECTORIO'])->update(['ACTIVO' => 0]);
    //                                     $response['code'] = 1;
    //                                     $response['servicio'] = 'Desactivada';
    //                                 } else {
    //                                     $servicios = directorioModel::where('ID_FORMULARIO_DIRECTORIO', $request['ID_FORMULARIO_DIRECTORIO'])->update(['ACTIVO' => 1]);
    //                                     $response['code'] = 1;
    //                                     $response['servicio'] = 'Activada';
    //                                 }
    //                             } else {
    //                                 $servicios = directorioModel::find($request->ID_FORMULARIO_DIRECTORIO);
    //                                 $servicios->update($request->all());
    //                                 $response['code'] = 1;
    //                                 $response['servicio'] = 'Actualizada';
    //                             }
    //                             return response()->json($response);

    //                         }
    //                         $response['code']  = 1;
    //                         $response['servicio']  = $servicios;
    //                         return response()->json($response);
    //                         break;
    //                     default:
    //                         $response['code']  = 1;
    //                         $response['msj']  = 'Api no encontrada';
    //                         return response()->json($response);
    //                 }
    //             } catch (Exception $e) {
    //                 return response()->json('Error al guardar');
    //             }
    //         }

    // }



    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_DIRECTORIO == 0) {
                        DB::statement('ALTER TABLE formulario_directorio AUTO_INCREMENT=1;');

                        $data = $request->except(['servicios', 'CONSTANCIA_DOCUMENTO']);
                        $servicios = directorioModel::create($data);

                        if ($request->hasFile('CONSTANCIA_DOCUMENTO')) {
                            $documento = $request->file('CONSTANCIA_DOCUMENTO');
                            $idFormulario = $servicios->ID_FORMULARIO_DIRECTORIO;

                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME));
                            $nombreArchivo .= '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta = 'compras/' . $idFormulario;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $servicios->CONSTANCIA_DOCUMENTO = $rutaCompleta;
                            $servicios->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $servicios = directorioModel::where('ID_FORMULARIO_DIRECTORIO', $request['ID_FORMULARIO_DIRECTORIO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['servicio'] = 'Desactivada';
                            } else {
                                $servicios = directorioModel::where('ID_FORMULARIO_DIRECTORIO', $request['ID_FORMULARIO_DIRECTORIO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['servicio'] = 'Activada';
                            }
                        } else {
                            $servicios = directorioModel::find($request->ID_FORMULARIO_DIRECTORIO);
                            $servicios->update($request->except('CONSTANCIA_DOCUMENTO'));

                            if ($request->hasFile('CONSTANCIA_DOCUMENTO')) {
                                if ($servicios->CONSTANCIA_DOCUMENTO && Storage::exists($servicios->CONSTANCIA_DOCUMENTO)) {
                                    Storage::delete($servicios->CONSTANCIA_DOCUMENTO);
                                }

                                $documento = $request->file('CONSTANCIA_DOCUMENTO');
                                $idFormulario = $servicios->ID_FORMULARIO_DIRECTORIO;

                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME));
                                $nombreArchivo .= '.' . $documento->getClientOriginalExtension();

                                $rutaCarpeta = 'compras/' . $idFormulario;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $servicios->CONSTANCIA_DOCUMENTO = $rutaCompleta;
                                $servicios->save();
                            }

                            $response['code'] = 1;
                            $response['servicio'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }

                    $response['code'] = 1;
                    $response['servicio'] = $servicios;
                    return response()->json($response);
                    break;
                default:
                    $response['code'] = 1;
                    $response['msj'] = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar', 'message' => $e->getMessage()]);
        }
    }
}