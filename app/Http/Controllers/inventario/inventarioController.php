<?php

namespace App\Http\Controllers\inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\inventario\inventarioModel;

use Illuminate\Support\Facades\Storage;

//Recursos para abrir el Excel
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


use DB;

class inventarioController extends Controller
{
    public function Tablainventario()
    {
        try {
            $tabla = inventarioModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }


                $value->FOTO_EQUIPO_HTML = '<img src="/equipofoto/' . $value->ID_FORMULARIO_INVENTARIO . '" alt="Foto" class="img-fluid" width="50" height="60">';


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


    // public function store(Request $request)
    // {
    //     try {
    //         switch (intval($request->api)) {
    //             case 1:
    //                 if ($request->ID_FORMULARIO_INVENTARIO == 0) {
    //                     DB::statement('ALTER TABLE formulario_inventario AUTO_INCREMENT=1;');
    //                     $inventarios = inventarioModel::create($request->all());
    //                 } else {

    //                     if (isset($request->ELIMINAR)) {
    //                         if ($request->ELIMINAR == 1) {

    //                             $inventarios = inventarioModel::where('ID_FORMULARIO_INVENTARIO', $request['ID_FORMULARIO_INVENTARIO'])->update(['ACTIVO' => 0]);
    //                             $response['code'] = 1;
    //                             $response['inventario'] = 'Desactivada';
    //                         } else {
    //                             $inventarios = inventarioModel::where('ID_FORMULARIO_INVENTARIO', $request['ID_FORMULARIO_INVENTARIO'])->update(['ACTIVO' => 1]);
    //                             $response['code'] = 1;
    //                             $response['inventario'] = 'Activada';
    //                         }
    //                     } else {
    //                         $inventarios = inventarioModel::find($request->ID_FORMULARIO_INVENTARIO);
    //                         $inventarios->update($request->all());
    //                         $response['code'] = 1;
    //                         $response['inventario'] = 'Actualizada';
    //                     }
    //                     return response()->json($response);
    //                 }
    //                 $response['code']  = 1;
    //                 $response['inventario']  = $inventarios;
    //                 return response()->json($response);
    //                 break;

    //             default:
    //                 $response['code']  = 1;
    //                 $response['msj']  = 'Api no encontrada';
    //                 return response()->json($response);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json('Error al guardar el asesor');
    //     }
    // }





    public function mostrarFotoEquipo($usuario_id)
    {
        $foto = inventarioModel::findOrFail($usuario_id);
        return Storage::response($foto->FOTO_EQUIPO);
    }




    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                // case 1:
                //     if ($request->ID_FORMULARIO_INVENTARIO == 0) {
                //         DB::statement('ALTER TABLE formulario_inventario AUTO_INCREMENT=1;');
                //         $inventarios = inventarioModel::create($request->all());
                //     } else {
                //         if (isset($request->ELIMINAR)) {
                //             if ($request->ELIMINAR == 1) {
                //                 $inventarios = inventarioModel::where('ID_FORMULARIO_INVENTARIO', $request['ID_FORMULARIO_INVENTARIO'])
                //                     ->update(['ACTIVO' => 0]);
                //                 $response['code'] = 1;
                //                 $response['inventario'] = 'Desactivada';
                //             } else {
                //                 $inventarios = inventarioModel::where('ID_FORMULARIO_INVENTARIO', $request['ID_FORMULARIO_INVENTARIO'])
                //                     ->update(['ACTIVO' => 1]);
                //                 $response['code'] = 1;
                //                 $response['inventario'] = 'Activada';
                //             }
                //         } else {
                //             $inventarios = inventarioModel::find($request->ID_FORMULARIO_INVENTARIO);
                //             $inventarios->update($request->all());
                //             $response['code'] = 1;
                //             $response['inventario'] = 'Actualizada';
                //         }
                //         return response()->json($response);
                //     }
                //     $response['code']  = 1;
                //     $response['inventario']  = $inventarios;
                //     return response()->json($response);
                //     break;




                case 1:
                    if ($request->ID_FORMULARIO_INVENTARIO == 0) {
                        // Reiniciar AUTO_INCREMENT al crear un nuevo registro
                        DB::statement('ALTER TABLE formulario_inventario AUTO_INCREMENT=1;');

                        // Guardar datos excepto la foto
                        $datos = $request->except('FOTO_EQUIPO');
                        $inventarios = inventarioModel::create($datos);

                        // Manejar la foto si viene en el request
                        if ($request->hasFile('FOTO_EQUIPO')) {
                            $file = $request->file('FOTO_EQUIPO');
                            $folder = "Almacén/Inventario/{$inventarios->ID_FORMULARIO_INVENTARIO}";
                            $filename = 'foto_equipo.' . $file->getClientOriginalExtension();
                            $path = $file->storeAs($folder, $filename);

                            $inventarios->FOTO_EQUIPO = $path;
                            $inventarios->save();
                        }

                        $response['code']  = 1;
                        $response['inventario']  = $inventarios;
                        return response()->json($response);
                    } else {
                        // Activar / Desactivar
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            $accion = $estado == 1 ? 'Activada' : 'Desactivada';

                            inventarioModel::where('ID_FORMULARIO_INVENTARIO', $request->ID_FORMULARIO_INVENTARIO)
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['inventario'] = $accion;
                            return response()->json($response);
                        } else {
                            // Actualización normal
                            $inventarios = inventarioModel::find($request->ID_FORMULARIO_INVENTARIO);

                            if (!$inventarios) {
                                return response()->json(['code' => 0, 'msj' => 'Inventario no encontrado']);
                            }

                            // Reemplazo de foto si se sube una nueva
                            if ($request->hasFile('FOTO_EQUIPO')) {
                                if ($inventarios->FOTO_EQUIPO && Storage::exists($inventarios->FOTO_EQUIPO)) {
                                    Storage::delete($inventarios->FOTO_EQUIPO);
                                }

                                $file = $request->file('FOTO_EQUIPO');
                                $folder = "Almacén/Inventario/{$inventarios->ID_FORMULARIO_INVENTARIO}";
                                $filename = 'foto_equipo.' . $file->getClientOriginalExtension();
                                $path = $file->storeAs($folder, $filename);

                                $inventarios->FOTO_EQUIPO = $path;
                            }

                            // Actualizar con los demás datos
                            $inventarios->fill($request->except('FOTO_EQUIPO'))->save();

                            $response['code'] = 1;
                            $response['inventario'] = 'Actualizada';
                            return response()->json($response);
                        }
                    }
                    break;

                // case 2: 
                //     try {
                //         if ($request->hasFile('excelEquipos')) {
                //             $excel = $request->file('excelEquipos');

                //             $spreadsheet = IOFactory::load($excel->getPathname());
                //             $sheet = $spreadsheet->getActiveSheet();
                //             $data = $sheet->toArray(null, true, true, true);

                //             array_shift($data);
                //             array_shift($data);

                //             $datosGenerales = [];
                //             foreach ($data as $row) {
                //                 if (!empty(array_filter($row))) {
                //                     array_shift($row); 
                //                     if (count($row) > 1) {
                //                         array_splice($row, -2, 1);
                //                     }
                //                     array_pop($row);
                //                     $datosGenerales[] = $row;
                //                 }
                //             }

                //             // Extraer imágenes (columna J)
                //             $drawings = $sheet->getDrawingCollection();
                //             $imagenes = [];
                //             $coun = 1;
                //             $processedCoordinates = [];

                //             foreach ($drawings as $drawing) {
                //                 $coordinates = $drawing->getCoordinates();

                //                 // ✅ Solo procesar si es columna J
                //                 if (strpos($coordinates, 'k') !== 0) {
                //                     continue;
                //                 }

                //                 if (in_array($coordinates, $processedCoordinates)) {
                //                     continue;
                //                 }
                //                 $processedCoordinates[] = $coordinates;

                //                 if ($drawing instanceof MemoryDrawing) {
                //                     ob_start();
                //                     call_user_func($drawing->getRenderingFunction(), $drawing->getImageResource());
                //                     $imageContents = ob_get_contents();
                //                     ob_end_clean();

                //                     $extension = 'png';
                //                     switch ($drawing->getMimeType()) {
                //                         case MemoryDrawing::MIMETYPE_PNG:
                //                             $extension = 'png';
                //                             break;
                //                         case MemoryDrawing::MIMETYPE_GIF:
                //                             $extension = 'gif';
                //                             break;
                //                         case MemoryDrawing::MIMETYPE_JPEG:
                //                             $extension = 'jpg';
                //                             break;
                //                     }
                //                 } elseif ($drawing instanceof Drawing) {
                //                     $zipReader = fopen($drawing->getPath(), 'r');
                //                     $imageContents = '';
                //                     while (!feof($zipReader)) {
                //                         $imageContents .= fread($zipReader, 1024);
                //                     }
                //                     fclose($zipReader);

                //                     $extension = $drawing->getExtension();
                //                 }

                //                 $filename = 'equipo_' . $coun . '.' . $extension;
                //                 $path = 'Inventario/Almacén/' . $request['ID_FORMULARIO_INVENTARIO'] . '/' . $filename;
                //                 Storage::put($path, $imageContents);

                //                 $imagenes[] = $path;
                //                 $coun++;
                //             }

                //             // ============= Procesamiento y guardado ================
                //             $totalEquipos = count($datosGenerales);
                //             $equipoInsertados = 0;
                //             $posicionImagenEquipo = 0;

                //             foreach ($datosGenerales as $rowData) {
                //                 inventarioModel::create([
                //                     'DESCRIPCION_EQUIPO' => $rowData['B'] ?? "EL NOMBRE DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'MARCA_EQUIPO' => $rowData['C'] ?? "LA MARCA DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'MODELO_EQUIPO' => $rowData['D'] ?? "EL MODELO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'SERIE_EQUIPO' => $rowData['E'] ?? "LA SERIE DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'CODIGO_EQUIPO' => $rowData['F'] ?? "EL CODIGO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'CANTIDAD_EQUIPO' => $rowData['G'] ?? "0",
                //                     'UBICACION_EQUIPO' => $rowData['I'] ?? "LA UBICACION DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'ESTADO_EQUIPO' => $rowData['J'] ?? "EL ESTADO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'FECHA_ADQUISICION' => !empty($rowData['K']) ? $rowData['L'] : null,
                //                     'PROVEEDOR_EQUIPO' => $rowData['M'] ?? "EL PROVEEDOR DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'UNITARIO_EQUIPO' => $rowData['N'] ?? "EL PRECIO UNITARIO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'TOTAL_EQUIPO' => $rowData['O'] ?? "EL PRECIO TOTAL DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'TIPO_EQUIPO' => $rowData['P'] ?? "EL TIPO TOTAL DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'FOTO_EQUIPO' => $imagenes[$posicionImagenEquipo] ?? null,
                //                 ]);
                //                 $posicionImagenEquipo++;
                //                 $equipoInsertados++;
                //             }

                //             return response()->json([
                //                 'msj' => 'Total de equipos agregados : ' . $equipoInsertados . ' de ' . $totalEquipos,
                //                 'code' => 200,
                //                 'img' => $imagenes
                //             ]);
                //         } else {
                //             return response()->json(["msj" => 'No se ha subido ningún archivo', "code" => 500]);
                //         }
                //     } catch (Exception $e) {
                //         return response()->json([
                //             'msj' => 'Se produjo un error al intentar cargar los equipos: ' . $e->getMessage(),
                //             'code' => 500
                //         ]);
                //     }
                //     break;

                case 2:
                    try {
                        if ($request->hasFile('excelEquipos')) {
                            $excel = $request->file('excelEquipos');

                            $spreadsheet = IOFactory::load($excel->getPathname());
                            $sheet = $spreadsheet->getActiveSheet();
                            $data = $sheet->toArray(null, true, true, true);

                            // ❌ Saltar filas de encabezado (1 y 2)
                            array_shift($data);
                            array_shift($data);

                            $datosGenerales = [];
                            foreach ($data as $row) {
                                if (!empty(array_filter($row))) {
                                    $datosGenerales[] = $row;
                                }
                            }

                            // ✅ Extraer imágenes de columna K
                            $drawings = $sheet->getDrawingCollection();
                            $imagenes = [];
                            $processedCoordinates = [];

                            foreach ($drawings as $drawing) {
                                $coordinates = $drawing->getCoordinates();

                                // Solo columna K
                                if (strpos(strtoupper($coordinates), 'K') !== 0) {
                                    continue;
                                }

                                if (in_array($coordinates, $processedCoordinates)) {
                                    continue;
                                }
                                $processedCoordinates[] = $coordinates;

                                if ($drawing instanceof MemoryDrawing) {
                                    ob_start();
                                    call_user_func($drawing->getRenderingFunction(), $drawing->getImageResource());
                                    $imageContents = ob_get_contents();
                                    ob_end_clean();

                                    $extension = 'png';
                                    switch ($drawing->getMimeType()) {
                                        case MemoryDrawing::MIMETYPE_PNG:
                                            $extension = 'png';
                                            break;
                                        case MemoryDrawing::MIMETYPE_GIF:
                                            $extension = 'gif';
                                            break;
                                        case MemoryDrawing::MIMETYPE_JPEG:
                                            $extension = 'jpg';
                                            break;
                                    }
                                } elseif ($drawing instanceof Drawing) {
                                    $zipReader = fopen($drawing->getPath(), 'r');
                                    $imageContents = '';
                                    while (!feof($zipReader)) {
                                        $imageContents .= fread($zipReader, 1024);
                                    }
                                    fclose($zipReader);

                                    $extension = $drawing->getExtension();
                                }

                                $imagenes[] = [
                                    'contents' => $imageContents,
                                    'extension' => $extension,
                                    'coord' => $coordinates
                                ];
                            }

                            // ============= Guardar en DB ==================
                            $totalEquipos = count($datosGenerales);
                            $equipoInsertados = 0;
                            $posicionImagenEquipo = 0;

                            foreach ($datosGenerales as $rowData) {
                                $nuevoEquipo = inventarioModel::create([
                                    'DESCRIPCION_EQUIPO' => $rowData['B'] ?? "EL NOMBRE DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'MARCA_EQUIPO'       => $rowData['C'] ?? "LA MARCA DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'MODELO_EQUIPO'      => $rowData['D'] ?? "EL MODELO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'SERIE_EQUIPO'       => $rowData['E'] ?? "LA SERIE DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'CODIGO_EQUIPO'      => $rowData['F'] ?? "EL CODIGO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'CANTIDAD_EQUIPO'    => $rowData['G'] ?? "0",
                                    'UBICACION_EQUIPO'   => $rowData['I'] ?? "LA UBICACION DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'ESTADO_EQUIPO'      => $rowData['J'] ?? "EL ESTADO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'FECHA_ADQUISICION'  => !empty($rowData['L']) ? $rowData['L'] : null,
                                    'PROVEEDOR_EQUIPO'   => $rowData['M'] ?? "EL PROVEEDOR DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'UNITARIO_EQUIPO'    => $rowData['N'] ?? "EL PRECIO UNITARIO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'TOTAL_EQUIPO'       => $rowData['O'] ?? "EL PRECIO TOTAL DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'TIPO_EQUIPO'        => $rowData['P'] ?? "EL TIPO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                                    'FOTO_EQUIPO'        => null
                                ]);

                                // 📸 Guardar foto si existe en columna K
                                if (isset($imagenes[$posicionImagenEquipo])) {
                                    $imagen = $imagenes[$posicionImagenEquipo];
                                    $filename = 'foto_equipo.' . $imagen['extension'];
                                    $pathFinal = 'Almacén/Inventario/' . $nuevoEquipo->ID_FORMULARIO_INVENTARIO . '/' . $filename;

                                    Storage::put($pathFinal, $imagen['contents']);

                                    $nuevoEquipo->update([
                                        'FOTO_EQUIPO' => $pathFinal
                                    ]);
                                }

                                $posicionImagenEquipo++;
                                $equipoInsertados++;
                            }

                            return response()->json([
                                'msj'  => 'Total de equipos agregados : ' . $equipoInsertados . ' de ' . $totalEquipos,
                                'code' => 200
                            ]);
                        } else {
                            return response()->json(["msj" => 'No se ha subido ningún archivo', "code" => 500]);
                        }
                    } catch (Exception $e) {
                        return response()->json([
                            'msj'  => 'Se produjo un error al intentar cargar los equipos: ' . $e->getMessage(),
                            'code' => 500
                        ]);
                    }


                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar el asesor');
        }
    }


}
