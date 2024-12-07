<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Artisan;
use Exception;
use App\Models\organizacion\areasModel;
use App\Models\organizacion\formulariorequerimientoModel;
use App\Models\organizacion\departamentosAreasModel;


use App\Models\organizacion\catalogotipovacanteModel;
use App\Models\organizacion\catalogomotivovacanteModel;

use DB;

class requerimientoPersonalController extends Controller
{
    public function index()
    {
        $categoria = DB::select("
        SELECT c.ID_CATALOGO_CATEGORIA AS ID_DEPARTAMENTO_AREA, 
               c.NOMBRE_CATEGORIA AS NOMBRE
        FROM catalogo_categorias c
        INNER JOIN formulario_dpt f ON c.ID_CATALOGO_CATEGORIA = f.DEPARTAMENTOS_AREAS_ID
        WHERE c.ACTIVO = 1
    ");
    

        $todascategoria = DB::select("SELECT ID_CATALOGO_CATEGORIA  AS ID_CATALOGO_CATEGORIA, NOMBRE_CATEGORIA AS NOMBRE
        FROM catalogo_categorias
        WHERE ACTIVO = 1");


        $areas = areasModel::orderBy('NOMBRE', 'ASC')->get();

        $tipos = catalogotipovacanteModel::orderBy('NOMBRE_TIPOVACANTE', 'ASC')->get();
        $motivos = catalogomotivovacanteModel::orderBy('NOMBRE_MOTIVO_VACANTE', 'ASC')->get();


        $areas1 = DB::select("
        SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE, LUGAR_CATEGORIA AS LUGAR, PROPOSITO_CATEGORIA AS PROPOSITO, ES_LIDER_CATEGORIA AS LIDER
        FROM catalogo_categorias
        WHERE ACTIVO = 1
        ");



        return view('RH.organizacion.requerimiento_personal', compact('areas','categoria','tipos','motivos','todascategoria','areas1'));
        
    }


public function Tablarequerimiento()
{
    try {
        $tabla = DB::select("SELECT rec.*, cat.NOMBRE_CATEGORIA
                            FROM formulario_requerimientos rec
                            LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = rec.PUESTO_RP");

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARO_REQUERIMIENTO . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_RP = '<button type="button" class="btn btn-success  RP btn-custom rounded-pill" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARO_REQUERIMIENTO . '" checked><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';

                if ($value->ANTES_DE1 == 0) {
                    $value->BTN_RP = '<button type="button" class="btn btn-success  RP btn-custom rounded-pill"><i class="bi bi-file-earmark-excel-fill"></i></button>';
                } else {
                    $value->BTN_RP = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-requerimiento" data-id="' . $value->ID_FORMULARO_REQUERIMIENTO . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                }
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
    

public function mostrardocumentorequisicion($id)
{
    $archivo = formulariorequerimientoModel::findOrFail($id)->DOCUMENTO_REQUISICION;
    return Storage::response($archivo);
}


    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARO_REQUERIMIENTO == 0) {
                        DB::statement('ALTER TABLE formulario_requerimientos AUTO_INCREMENT=1;');
                        
                        $requerimientos = formulariorequerimientoModel::create($request->all());
                        
                        if ($request->hasFile('DOCUMENTO_REQUISICION')) {
                            $file = $request->file('DOCUMENTO_REQUISICION');
                            
                            $folderPath = "Requisición de personal/{$requerimientos->ID_FORMULARO_REQUERIMIENTO}";
                            $fileName = $file->getClientOriginalName();
                            
                            $filePath = $file->storeAs($folderPath, $fileName);
        
                            $requerimientos->DOCUMENTO_REQUISICION = $filePath;
                            $requerimientos->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $requerimientos = formulariorequerimientoModel::where('ID_FORMULARO_REQUERIMIENTO', $request['ID_FORMULARO_REQUERIMIENTO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['requerimiento'] = 'Desactivada';
                            } else {
                                $requerimientos = formulariorequerimientoModel::where('ID_FORMULARO_REQUERIMIENTO', $request['ID_FORMULARO_REQUERIMIENTO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['requerimiento'] = 'Activada';
                            }
                        } else {
                            $requerimientos = formulariorequerimientoModel::find($request->ID_FORMULARO_REQUERIMIENTO);
                            
                            $requerimientos->update($request->all());
        
                            if ($request->hasFile('DOCUMENTO_REQUISICION')) {
                                $file = $request->file('DOCUMENTO_REQUISICION');
                                
                                if ($requerimientos->DOCUMENTO_REQUISICION && Storage::exists($requerimientos->DOCUMENTO_REQUISICION)) {
                                    Storage::delete($requerimientos->DOCUMENTO_REQUISICION);
                                }
        
                                $folderPath = "Requisición de personal/{$requerimientos->ID_FORMULARO_REQUERIMIENTO}";
                                $fileName = $file->getClientOriginalName();
        
                                $filePath = $file->storeAs($folderPath, $fileName);
        
                                $requerimientos->DOCUMENTO_REQUISICION = $filePath;
                                $requerimientos->save();
                            }
                            $response['code'] = 1;
                            $response['requerimiento'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
        
                    $response['code']  = 1;
                    $response['requerimiento']  = $requerimientos;
                    return response()->json($response);
        
                    break;
        
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar las relaciones', 'message' => $e->getMessage()]);
        }
        
        
    }

}

