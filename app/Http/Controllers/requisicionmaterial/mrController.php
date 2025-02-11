<?php

namespace App\Http\Controllers\requisicionmaterial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;

use App\Models\requisicionmaterial\mrModel;


class mrController extends Controller
{

    public function Tablamr()
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
                    if ($request->ID_FORMULARIO_MR == 0) {
                        DB::statement('ALTER TABLE formulario_requisiconmaterial AUTO_INCREMENT=1;');

                        $year = date('y'); 
                        $lastMR = mrModel::where('NO_MR', 'like', "RES-MR$year-%")
                        ->orderBy('NO_MR', 'desc')
                            ->first();

                        $nextNumber = $lastMR ? intval(substr($lastMR->NO_MR, -3)) + 1 : 1;
                        $noMR = sprintf("RES-MR%s-%03d", $year, $nextNumber);

                        $mrs = mrModel::create(array_merge($request->all(), [
                            'NO_MR' => $noMR
                        ]));

                        return response()->json([
                            'code' => 1,
                            'mr' => $mrs
                        ]);
                    } else {
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
                                $mrs->update($request->all());
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
