<?php

namespace App\Http\Controllers\paginaweb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\paginaweb\ContactoPaginaWeb;


class mensajespaginaController extends Controller
{

    public function Tablamensajepaginaweb()
    {
        try {
            $tabla = ContactoPaginaWeb::get();

            foreach ($tabla as $value) {



                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-danger btn-custom rounded-pill ELIMINAR"><i class="bi bi-trash3-fill"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                
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
                    if ($request->ID_FORMULARIO_CONTACTOSPAGINAWEB == 0) {
                        DB::statement('ALTER TABLE contactos_paginaweb AUTO_INCREMENT = 1;');
                        $areas = ContactoPaginaWeb::create($request->all());
                        $response['code']  = 1;
                        $response['area']  = $areas;
                    } else {
                        ContactoPaginaWeb::where('ID_FORMULARIO_CONTACTOSPAGINAWEB', $request->ID_FORMULARIO_CONTACTOSPAGINAWEB)->delete();

                        $response['code'] = 1;
                        $response['area'] = 'Eliminada';
                    }

                    return response()->json($response);

                default:
                    return response()->json([
                        'code' => 0,
                        'msj' => 'API no encontrada'
                    ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 0,
                'msj' => 'Error al procesar la solicitud',
                'error' => $e->getMessage()
            ]);
        }
    }
}
