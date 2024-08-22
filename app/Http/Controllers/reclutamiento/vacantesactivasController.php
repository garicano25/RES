<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reclutamiento\requerimientoModel;
use App\Models\organizacion\catalogocategoriaModel;
use App\Models\selección\seleccionModel;
use App\Models\reclutamiento\listapostulacionesModel;


use DB;
class vacantesactivasController extends Controller
{
    


    public function index()
{
    

    $areas = catalogocategoriaModel::where('ES_LIDER_CATEGORIA', 0)
    ->orderBy('NOMBRE_CATEGORIA', 'ASC')
    ->get();




    return view('RH.reclutamiento.Vacantes_activas', compact('areas'));



}



    
public function Tablapostulaciones()
{
    try {
        $tabla = DB::select("
            SELECT vac.*, 
                    cat.NOMBRE_CATEGORIA, 
                    (SELECT COUNT(lp.VACANTES_ID) 
                    FROM lista_postulantes lp 
                    WHERE lp.VACANTES_ID = vac.ID_CATALOGO_VACANTE AND lp.ACTIVO = 1) AS TOTAL_POSTULANTES
            FROM catalogo_vacantes vac
            LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
            WHERE vac.ACTIVO = 1
        ");

        foreach ($tabla as $value) {
            $value->REQUERIMIENTO = requerimientoModel::where('CATALOGO_VACANTES_ID', $value->ID_CATALOGO_VACANTE)->get();

            $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar registro"><i class="bi bi-eye"></i></button>';

            $value->TOTAL_POSTULANTES = '<button type="button" class="btn btn-info btn-custom rounded-pill TOTAL_POSTULANTES" onclick="TotalPostulantes(' . $value->ID_CATALOGO_VACANTE . ', ' . $value->CATEGORIA_VACANTE . ')">' . $value->TOTAL_POSTULANTES . '</button>';
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


    





public function informacionpostulantes($idVacante)
{
    try {
        // Consulta para obtener los datos únicos de los postulantes
        $postulantes = DB::select("
            SELECT 
                fb.NOMBRE_CV,
                fb.PRIMER_APELLIDO_CV,
                fb.SEGUNDO_APELLIDO_CV,
                fb.CURP_CV,
                fb.CORREO_CV,
                fb.TELEFONO1,
                fb.TELEFONO2,
                fb.ARCHIVO_CV,
                lp.VACANTES_ID
            FROM lista_postulantes lp
            LEFT JOIN formulario_bancocv fb ON lp.CURP = fb.CURP_CV
            WHERE lp.VACANTES_ID = ? AND lp.ACTIVO = 1
            GROUP BY fb.CURP_CV, lp.VACANTES_ID, fb.NOMBRE_CV, fb.PRIMER_APELLIDO_CV, fb.SEGUNDO_APELLIDO_CV, fb.CORREO_CV, fb.TELEFONO1, fb.TELEFONO2, fb.ARCHIVO_CV
        ", [$idVacante]);

        $requerimientos = DB::select("
            SELECT 
                rv.NOMBRE_REQUERIMINETO,
                rv.PORCENTAJE
            FROM requerimientos_vacantes rv
            WHERE rv.CATALOGO_VACANTES_ID = ?
        ", [$idVacante]);

        return response()->json([
            'postulantes' => $postulantes,
            'requerimientos' => $requerimientos,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}


public function getCV($filename)
{
    $path = storage_path('app/Reclutamiento/CV/' . $filename . '.pdf');  

    if (!file_exists($path)) {
        abort(404, 'El archivo no fue encontrado.');
    }

    return response()->file($path);
}





public function guardarSeleccion(Request $request)
{
    try {
        // Actualizar la tabla lista_postulantes, estableciendo ACTIVO en 0 para la CURP especificada
        listapostulacionesModel::where('CURP', $request->CURP)
            ->where('VACANTES_ID', $request->VACANTES_ID)
            ->update(['ACTIVO' => 0]);

        // Guardar la información del postulante seleccionado en formulario_seleccion
        SeleccionModel::create([
            'VACANTES_ID' => $request->VACANTES_ID,
            'CATEGORIA_VACANTE' => $request->CATEGORIA_VACANTE,
            'CURP' => $request->CURP,
            'NOMBRE_SELC' => $request->NOMBRE_SELC,
            'PRIMER_APELLIDO_SELEC' => $request->PRIMER_APELLIDO_SELEC,
            'SEGUNDO_APELLIDO_SELEC' => $request->SEGUNDO_APELLIDO_SELEC,
            'CORREO_SELEC' => $request->CORREO_SELEC,
            'TELEFONO1_SELECT' => $request->TELEFONO1_SELECT,
            'TELEFONO2_SELECT' => $request->TELEFONO2_SELECT,
            'PORCENTAJE' => $request->PORCENTAJE  // Guardar el total del cumplimiento
        ]);

        return response()->json(['message' => 'Postulante seleccionado exitosamente.'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error al seleccionar postulante: ' . $e->getMessage()], 500);
    }
}




}
