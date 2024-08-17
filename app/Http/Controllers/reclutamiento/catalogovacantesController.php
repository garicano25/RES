<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\reclutamiento\catalogovacantesModel;
use App\Models\organizacion\catalogocategoriaModel;
use App\Models\reclutamiento\requerimientoModel;

use DB;


class catalogovacantesController extends Controller
{

   

    
        public function index()
    {
        // $areas = DB::select("SELECT NOMBRE_CATEGORIA  AS ID_DEPARTAMENTO_AREA, NOMBRE_CATEGORIA AS NOMBRE
        // FROM catalogo_categorias
        // WHERE ACTIVO = 1");

    

            $areas = catalogocategoriaModel::orderBy('NOMBRE_CATEGORIA', 'ASC')->get();



        return view('RH.reclutamiento.catalogovacantes', compact('areas'));
   
    }

    

    public function Tablavacantes()
{
    try {
        $tabla = DB::select("
            SELECT vac.*, cat.NOMBRE_CATEGORIA,
                   DATEDIFF(vac.FECHA_EXPIRACION, CURDATE()) as DIAS_RESTANTES,
                   (CASE WHEN vac.FECHA_EXPIRACION < CURDATE() THEN 1 ELSE 0 END) as EXPIRADO
            FROM catalogo_vacantes vac
            LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
        ");

        foreach ($tabla as $value) {
            // Relacionar los requerimientos con cada vacante
            $value->REQUERIMIENTO = requerimientoModel::where('CATALOGO_VACANTES_ID', $value->ID_CATALOGO_VACANTE)->get();

            // Agregar botones de acción con condiciones
          if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill ELIMINAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';

                } else {
                    $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill ELIMINAR"><i class="bi bi-power"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                }
        }

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
                    DB::beginTransaction(); // Start transaction
    
                    if ($request->ID_CATALOGO_VACANTE == 0) {
                        DB::statement('ALTER TABLE catalogo_vacantes AUTO_INCREMENT=1;');
                        $vacante = catalogovacantesModel::create($request->all());

                    } else { 
                        if (!isset($request->ELIMINAR)) {
                            $vacante = catalogovacantesModel::find($request->ID_CATALOGO_VACANTE);
                            $vacante->update($request->all());
    
                            // Eliminar los requerimientos existentes
                            requerimientoModel::where('CATALOGO_VACANTES_ID', $request->ID_CATALOGO_VACANTE)->delete();
                        } else {
                            $vacante = catalogovacantesModel::where('ID_CATALOGO_VACANTE', $request['ID_CATALOGO_VACANTE'])->delete();
                            $response['code']  = 1;
                            $response['vacante']  = 'Eliminada';
                            DB::commit();
                            return response()->json($response);
                        }
                    }
    
                    // Guardar los nuevos requerimientos
                    if ($request->has('NOMBRE_REQUERIMINETO')) {
                        foreach ($request->NOMBRE_REQUERIMINETO as $requerimiento) {
                            requerimientoModel::create([
                                'CATALOGO_VACANTES_ID' => $vacante->ID_CATALOGO_VACANTE,
                                'NOMBRE_REQUERIMINETO' => $requerimiento
                            ]);
                        }
                    }
    
                    $response['code']  = 1;
                    $response['vacante']  = $vacante;
                    DB::commit(); // Commit transaction
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            return response()->json('Error al guardar la nueva vacante');
        }
    }
}




