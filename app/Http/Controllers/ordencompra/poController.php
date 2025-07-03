<?php

namespace App\Http\Controllers\ordencompra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;

use App\Models\ordencompra\poModel; 
use App\Models\HojaTrabajo;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;



class poController extends Controller
{



    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.ordencompra.ordencompra', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }



    public function Tablaordencompra()
    {
        try {
            $tabla = poModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                 
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
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
                    if ($request->ID_FORMULARIO_PO == 0) {
                        DB::statement('ALTER TABLE formulario_ordencompra AUTO_INCREMENT=1;');
                        $compras = poModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['compra'] = 'Desactivada';
                            } else {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['compra'] = 'Activada';
                            }
                        } else {
                            $compras = poModel::find($request->ID_FORMULARIO_PO);
                            $compras->update($request->all());
                            $response['code'] = 1;
                            $response['compra'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['compra']  = $compras;
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