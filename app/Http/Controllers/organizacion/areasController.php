<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Models\organizacion\areasModel;
use App\Models\organizacion\departamentosAreasModel;
use App\Models\organizacion\encargadosAreasModel;
use App\Models\organizacion\catalogocategoriaModel;
use App\Models\organizacion\areasLideresModel;
use App\Models\organizacion\lideresCategoriasModel;



use DB;



class areasController extends Controller
{

    public function index()
    {

        $categorias = catalogocategoriaModel::where('ACTIVO', 1)->get();
        $lideres = catalogocategoriaModel::where('ACTIVO', 1)->where('ES_LIDER_CATEGORIA', 1)->get();

        return view('RH.organizacion.organigrama', compact('categorias', 'lideres'));
    }

    // public function TablaAreas()
    // {
    //     try {

    //         $tabla = areasModel::where('ACTIVO', 1)->get();

    //         foreach ($tabla as $key => $value) {


    //             //Obtenemos el area afectada
    //             $departamentos = DB::select('SELECT NOMBRE, ID_DEPARTAMENTO_AREA FROM departamentos_areas da  WHERE da.AREA_ID = ? ', [$value->ID_AREA]);
    //             $encargados = DB::select('SELECT NOMBRE_CARGO FROM encargados_areas da  WHERE da.AREA_ID = ? ', [$value->ID_AREA]);


    //             $cadena = "";
    //             foreach ($departamentos  as $key => $val) {

    //                 $ppt = DB::select("SELECT IF(COUNT(ppt.ID_FORMULARIO_PPT) > 0, 1, 0) AS TIENE_PPT,  
    //                                     IF(COUNT(dpt.ID_FORMULARIO_DPT) > 0, 1, 0) AS TIENE_DPT
    //                                     FROM departamentos_areas d
    //                                     LEFT JOIN formulario_ppt ppt ON ppt.DEPARTAMENTO_AREA_ID = d.ID_DEPARTAMENTO_AREA 
    //                                     LEFT JOIN formulario_dpt dpt ON dpt.DEPARTAMENTOS_AREAS_ID = d.ID_DEPARTAMENTO_AREA
    //                                     WHERE d.ID_DEPARTAMENTO_AREA = ?", [$val->ID_DEPARTAMENTO_AREA]);


    //                 //TIENE PPT Y DPT
    //                 if($ppt[0]->TIENE_PPT == 1 && $ppt[0]->TIENE_DPT == 1){

    //                     $cadena .= "


    //                     <div class='row'>
    //                         <div class='col-8'>
    //                             <li class='mb-2'>" . $val->NOMBRE . " </li>
    //                         </div>
    //                         <div class='col-4 justify-content-end d-flex'>
    //                             <lu>
    //                                 <span class='badge text-bg-success' ><i class='bi bi-check-lg'></i> PPT </span>
    //                                 <span class='badge text-bg-success' style='margin-left: 10px'><i class='bi bi-check-lg'></i> DPT </span>
    //                             </lu>
    //                         </div>
    //                     </div>

    //                     ";

    //                 //NO TIENEN PPT NI DPT
    //                 }else if ($ppt[0]->TIENE_PPT == 0 && $ppt[0]->TIENE_DPT == 0){



    //                     $cadena .= "


    //                     <div class='row'>
    //                         <div class='col-8'>
    //                             <li class='mb-2'>" . $val->NOMBRE . " </li>
    //                         </div>
    //                         <div class='col-4 justify-content-end d-flex'>
    //                             <lu>
    //                                 <span class='badge text-bg-danger' ><i class='bi bi-x'></i> PPT </span> 
    //                                 <span class='badge text-bg-danger' style='margin-left: 10px'><i class='bi bi-x'></i> DPT </span> 
    //                             </lu>
    //                         </div>
    //                     </div>

    //                     ";

    //                     //TIEN PPT Y NO TIENE DPT
    //                 } else if ($ppt[0]->TIENE_PPT == 1 && $ppt[0]->TIENE_DPT == 0) {


    //                     $cadena .= "
    //                     <div class='row'>
    //                         <div class='col-8'>
    //                             <li class='mb-2'>" . $val->NOMBRE . " </li>
    //                         </div>
    //                         <div class='col-4 justify-content-end d-flex'>
    //                             <lu>
    //                                 <span class='badge text-bg-success' ><i class='bi bi-check-lg'></i> PPT </span> 
    //                                 <span class='badge text-bg-danger' style='margin-left: 10px'><i class='bi bi-x'></i> DPT </span> 
    //                             </lu>
    //                         </div>
    //                     </div>

    //                     ";

    //                     //NO TIENE PPT Y TIENE DPT
    //                 } else if ($ppt[0]->TIENE_PPT == 0 && $ppt[0]->TIENE_DPT == 1) {

    //                     $cadena .= "

    //                     <div class='row'>
    //                         <div class='col-8'>
    //                             <li class='mb-2'>" . $val->NOMBRE . " </li>
    //                         </div>
    //                         <div class='col-4 justify-content-end d-flex'>
    //                             <lu>
    //                                 <span class='badge text-bg-danger' ><i class='bi bi-x'></i> PPT </span>
    //                                 <span class='badge text-bg-success' style='margin-left: 10px'><i class='bi bi-check-lg'></i> DPT </span>
    //                             </lu>
    //                         </div>
    //                     </div>

    //                     ";

    //                 }


    //             }

    //             $encargados_list = "";
    //             foreach ($encargados  as $key => $val1) {
    //                 $encargados_list .= "<li>" .  $val1->NOMBRE_CARGO . "</li>";
    //             }

    //             $value['DEPARTAMENTOS'] = $cadena;
    //             $value['ENCARGADOS'] = $encargados_list === "" ? '<span class="badge text-bg-warning ">Sin encargados</span>' : $encargados_list;


    //             // // Botones
    //             // if (auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Reconocimiento', 'CoordinadorHI'])  && ($recsensorial->recsensorial_bloqueado + 0) == 0) {

    //             $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-circle ELIMINAR"><i class="bi bi-power"></i></button>';
    //             $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-circle EDITAR"><i class="bi bi-pencil-square"></i></button>';
    //             $value->BTN_ORGANIGRAMA = '<button type="button" class="btn btn-success btn-circle ORGANIGRAMA"><i class="bi bi-diagram-3-fill"></i></button>';


    //             // } else {

    //             //     $value->boton_eliminar = '<button type="button" class="btn btn-secondary btn-circle"><i class="fa fa-ban"></i></button>';
    //             // }
    //         }

    //         // respuesta
    //         $dato['data'] = $tabla;
    //         $dato["msj"] = 'Información consultada correctamente';
    //         return response()->json($dato);
    //     } catch (Exception $e) {

    //         $dato["msj"] = 'Error ' . $e->getMessage();
    //         $dato['data'] = 0;
    //         return response()->json($dato);
    //     }
    // }




    public function TablaAreas()
    {
        try {

            $tabla = DB::select("CALL sp_obtener_organigrama_areas_b()");
            $COUNT = 1;
            foreach ($tabla as $key => $value) {

                $value->COUNT = $COUNT;
                $COUNT += 1;


                $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill ELIMINAR "><i class="bi bi-power"></i></button>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom EDITAR rounded-pill"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_ORGANIGRAMA = '<button type="button" class="btn btn-success btn-custom ORGANIGRAMA rounded-pill"><i class="bi bi-diagram-3-fill"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-pdf" data-id="' . $value->ID_AREA . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';

            }

            // respuesta
            $dato['data'] = $tabla;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['data'] = 0;
            return response()->json($dato);
        }
    }

    public function mostrararchivo($id)
    {
        $archivo = areasModel::findOrFail($id)->DOCUMENTO_ORGANIGRAMA;
        return Storage::response($archivo);
    }
    


    public function TablaEncargados($area_id)
    {
        try {

            $tabla = DB::select('SELECT cat.NOMBRE_CATEGORIA AS NOMBRE, 
                                        1 AS LIDER, 
                                        lideres.LIDER_ID AS ID_CATEGORIA, 
                                        lideres.ACTIVO
                                FROM areas_lideres lideres
                                LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = lideres.LIDER_ID
                                WHERE lideres.AREA_ID = ?

                                    UNION

                                SELECT cat.NOMBRE_CATEGORIA AS NOMBRE, 
                                        0 LIDER, 
                                        lideres_cat.CATEGORIA_ID AS ID_CATEGORIA, 
                                        lideres_cat.ACTIVO
                                FROM lideres_categorias lideres_cat
                                LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = lideres_cat.CATEGORIA_ID
                                WHERE lideres_cat.AREA_ID = ?', [$area_id, $area_id]);

            $COUNT = 1;
            foreach ($tabla as $key => $value) {

                $value->COUNT = $COUNT;
                $COUNT += 1;



                if ($value->LIDER == 1) {

                    $value->ES_LIDER = '<span class="badge rounded-pill text-bg-success"><i class="bi bi-check-lg"></i></span>';
                } else {

                    $value->ES_LIDER = '<span class="badge rounded-pill text-bg-danger"><i class="bi bi-x-lg"></i></span>';
                }

                // // Botones
                // if (auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Reconocimiento', 'CoordinadorHI'])  && ($recsensorial->recsensorial_bloqueado + 0) == 0) {


                if ($value->ACTIVO == 1) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill " ><i class="bi bi-pencil-square EDITAR"></i></button>';

                    $value->BTN_ACTIVO = '<button type="button" class="btn btn-info btn-custom rounded-pill"> <i class="bi bi-toggle-on DESACTIVAR"></i></button>';
                } else {

                    $value->BTN_EDITAR = '<i class="bi bi-ban"></i>';
                    $value->BTN_ACTIVO = '<button type="button" class="btn btn-info rounded-pill  btn-custom" ><i class="bi bi-toggle-off ACTIVAR"></i></button>';
                }



                // } else {

                //     $value->boton_eliminar = '<button type="button" class="btn btn-secondary btn-circle"><i class="fa fa-ban"></i></button>';
                // }
            }

            // respuesta
            $dato['data'] = $tabla;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['data'] = 0;
            return response()->json($dato);
        }
    }


    public function getDataOrganigrama($area_id, $esGeneral)
    {
        try {

            $resultados = DB::select('CALL sp_obtener_json_organigrama_b(?, ?)', [$area_id, $esGeneral]);

            $arreglo_json = [];
            foreach ($resultados as $resultado) {

                $json = json_decode($resultado->JSON_DIRECCION, true);

                $arreglo_json[] = $json;
            }



            $response['code']  = 1;
            $response['data']  = json_encode($arreglo_json);
            return response()->json($response);
        } catch (Exception  $e) {

            return response()->json('Error al ejecutar el Procedure');
        }
    }

    public function store(Request $request)
    {

        try {
            switch (intval($request->api)) {
                    //Guardar Area
                // case 1:

                //     //Guardamos Area
                //     if ($request->ID_AREA == 0) {

                //         DB::statement('ALTER TABLE areas AUTO_INCREMENT=1;');
                //         $areas = areasModel::create($request->all());
                //     } else { //Editamos Area y eliminar area

                //         if (!isset($request->ELIMINAR)) {


                //             $areas = areasModel::find($request->ID_AREA);
                //             $areas->update($request->all());
                //         } else {

                //             $areas = areasModel::where('ID_AREA', $request['ID_AREA'])->delete();

                //             $response['code']  = 1;
                //             $response['area']  = 'Eliminada';
                //             return response()->json($response);
                //         }
                //     }

                //     $response['code']  = 1;
                //     $response['area']  = $areas;
                //     return response()->json($response);

                //     break;

              

                case 1:
                    // Guardamos Área y documento
                    if ($request->ID_AREA == 0) {
                        // Reiniciamos el AUTO_INCREMENT si es necesario
                        DB::statement('ALTER TABLE areas AUTO_INCREMENT=1;');
                
                        // Guardamos los datos del área
                        $areas = areasModel::create($request->except('DOCUMENTO_ORGANIGRAMA')); 
                
                        // Procesamos el documento
                        if ($request->hasFile('DOCUMENTO_ORGANIGRAMA')) {
                            $documento = $request->file('DOCUMENTO_ORGANIGRAMA');
                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE) . '.' . $documento->getClientOriginalExtension();
                            $rutaCarpeta = 'Documentos organigrama/' . $areas->ID_AREA;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                
                            // Actualizamos el registro con la ruta del documento
                            $areas->DOCUMENTO_ORGANIGRAMA = $rutaCompleta;
                            $areas->save();
                        }
                    } else {
                        // Editamos Área o eliminamos Área
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $areas = areasModel::where('ID_AREA', $request['ID_AREA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['area'] = 'Desactivada';
                            } else {
                                $areas = areasModel::where('ID_AREA', $request['ID_AREA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['area'] = 'Activada';
                            }
                        } else {
                            $areas = areasModel::find($request->ID_AREA);
                            $areas->update($request->except('DOCUMENTO_ORGANIGRAMA'));
                
                            // Procesamos el documento si se envió uno nuevo
                            if ($request->hasFile('DOCUMENTO_ORGANIGRAMA')) {
                                // Eliminamos el archivo anterior si existe
                                if ($areas->DOCUMENTO_ORGANIGRAMA && Storage::exists($areas->DOCUMENTO_ORGANIGRAMA)) {
                                    Storage::delete($areas->DOCUMENTO_ORGANIGRAMA); 
                                }
                
                                $documento = $request->file('DOCUMENTO_ORGANIGRAMA');
                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE) . '.' . $documento->getClientOriginalExtension();
                                $rutaCarpeta = 'Documentos organigrama/' . $areas->ID_AREA;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                
                                // Actualizamos el registro con la nueva ruta del documento
                                $areas->DOCUMENTO_ORGANIGRAMA = $rutaCompleta;
                                $areas->save();
                            }
                
                            $response['code'] = 1;
                            $response['area'] = 'Actualizada';
                        }
                    }
                
                    $response['code'] = 1;
                    $response['area'] = $areas;
                    return response()->json($response);
                    break;
                
                    


                    //GUARDAR CATEGORIAS
                case 2:
                    //Verificamos si es un nuevo registro para ver en donde lo guardamos
                    if ($request->NUEVO == 1) {

                        if ($request->ES_LIDER == 1) {

                            DB::statement('ALTER TABLE areas_lideres AUTO_INCREMENT=1;');
                            // ASIGNAMOS VALORES PARA ALMACENAR EN LA BASE DE DATOS
                            $request['AREA_ID'] = $request->AREA_ID;
                            $request['LIDER_ID'] = $request->CATEGORIA;

                            $categoria = areasLideresModel::create($request->all());

                            $response['code']  = 1;
                            $response['categoria']  = $categoria;
                            return response()->json($response);
                        } else {

                            DB::statement('ALTER TABLE lideres_categorias AUTO_INCREMENT=1;');
                            // ASIGNAMOS VALORES PARA ALMACENAR EN LA BASE DE DATOS
                            $request['AREA_ID'] = $request->AREA_ID;
                            $request['CATEGORIA_ID'] = $request->CATEGORIA;
                            $request['LIDER_ID'] = $request->LIDER;


                            $categoria = lideresCategoriasModel::create($request->all());

                            $response['code']  = 1;
                            $response['categoria']  = $categoria;
                            return response()->json($response);
                        }
                    } else { //Eliminar encargado del area

                        $encargados = encargadosAreasModel::where('ID_ENCARGADO_AREA', $request['ID_ENCARGADO_AREA'])->delete();

                        $response['code']  = 1;
                        $response['encargado']  = 'Eliminado';
                        return response()->json($response);
                    }



                    break;
                default:

                    $response['code']  = 2;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {

            return response()->json('Error al guardar el Area');
        }
    }
}
