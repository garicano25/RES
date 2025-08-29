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

use App\Models\inventario\catalogotipoinventarioModel;


use DB;

class inventarioController extends Controller
{


    public function index()
    {
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();


        return view('almacen.inventario.inventario', compact('tipoinventario'));
    }





    
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
                        DB::statement('ALTER TABLE formulario_inventario AUTO_INCREMENT=1;');

                        $datos = $request->except('FOTO_EQUIPO');
                        $inventarios = inventarioModel::create($datos);

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
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            $accion = $estado == 1 ? 'Activada' : 'Desactivada';

                            inventarioModel::where('ID_FORMULARIO_INVENTARIO', $request->ID_FORMULARIO_INVENTARIO)
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['inventario'] = $accion;
                            return response()->json($response);
                        } else {
                            $inventarios = inventarioModel::find($request->ID_FORMULARIO_INVENTARIO);

                            if (!$inventarios) {
                                return response()->json(['code' => 0, 'msj' => 'Inventario no encontrado']);
                            }

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
                //                     $datosGenerales[] = $row;
                //                 }
                //             }

                //             $drawings = $sheet->getDrawingCollection();
                //             $imagenes = [];
                //             $processedCoordinates = [];

                //             foreach ($drawings as $drawing) {
                //                 $coordinates = $drawing->getCoordinates();

                //                 // Solo columna K
                //                 if (strpos(strtoupper($coordinates), 'K') !== 0) {
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

                //                 $imagenes[] = [
                //                     'contents' => $imageContents,
                //                     'extension' => $extension,
                //                     'coord' => $coordinates
                //                 ];
                //             }

                //             // ============= Guardar en DB ==================
                //             $totalEquipos = count($datosGenerales);
                //             $equipoInsertados = 0;
                //             $posicionImagenEquipo = 0;

                //             foreach ($datosGenerales as $rowData) {
                //                 $nuevoEquipo = inventarioModel::create([

                //                     'DESCRIPCION_EQUIPO'  => !empty($rowData['B']) ? $rowData['B'] : null,
                //                     // 'DESCRIPCION_EQUIPO' => $rowData['B'] ?? "EL NOMBRE DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'MARCA_EQUIPO'  => !empty($rowData['C']) ? $rowData['C'] : null,
                //                     // 'MARCA_EQUIPO'       => $rowData['C'] ?? "LA MARCA DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'MODELO_EQUIPO'  => !empty($rowData['D']) ? $rowData['D'] : null,
                //                     // 'MODELO_EQUIPO'      => $rowData['D'] ?? "EL MODELO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'SERIE_EQUIPO'  => !empty($rowData['E']) ? $rowData['E'] : null,
                //                     // 'SERIE_EQUIPO'       => $rowData['E'] ?? "LA SERIE DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'CODIGO_EQUIPO'  => !empty($rowData['F']) ? $rowData['F'] : null,
                //                     // 'CODIGO_EQUIPO'      => $rowData['F'] ?? "EL CODIGO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'CANTIDAD_EQUIPO'  => !empty($rowData['G']) ? $rowData['G'] : null,
                //                     // 'CANTIDAD_EQUIPO'    => $rowData['G'] ?? "0",
                //                     'UBICACION_EQUIPO'  => !empty($rowData['I']) ? $rowData['I'] : null,
                //                     // 'UBICACION_EQUIPO'   => $rowData['I'] ?? "LA UBICACION DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'ESTADO_EQUIPO'  => !empty($rowData['J']) ? $rowData['J'] : null,
                //                     // 'ESTADO_EQUIPO'      => $rowData['J'] ?? "EL ESTADO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'FECHA_ADQUISICION'  => !empty($rowData['L']) ? $rowData['L'] : null,
                //                     'PROVEEDOR_EQUIPO'  => !empty($rowData['M']) ? $rowData['M'] : null,
                //                     // 'PROVEEDOR_EQUIPO'   => $rowData['M'] ?? "EL PROVEEDOR DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'UNITARIO_EQUIPO'  => !empty($rowData['N']) ? $rowData['N'] : null,
                //                     // 'UNITARIO_EQUIPO'    => $rowData['N'] ?? "EL PRECIO UNITARIO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'TOTAL_EQUIPO'  => !empty($rowData['O']) ? $rowData['O'] : null,
                //                     // 'TOTAL_EQUIPO'       => $rowData['O'] ?? "EL PRECIO TOTAL DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'TIPO_EQUIPO'  => !empty($rowData['P']) ? $rowData['P'] : null,
                //                     // 'TIPO_EQUIPO'        => $rowData['P'] ?? "EL TIPO DEL EQUIPO NO FUE ESPECIFICADO EN EL EXCEL",
                //                     'FOTO_EQUIPO'        => null
                //                 ]);

                //                 if (isset($imagenes[$posicionImagenEquipo])) {
                //                     $imagen = $imagenes[$posicionImagenEquipo];
                //                     $filename = 'foto_equipo.' . $imagen['extension'];
                //                     $pathFinal = 'Almacén/Inventario/' . $nuevoEquipo->ID_FORMULARIO_INVENTARIO . '/' . $filename;

                //                     Storage::put($pathFinal, $imagen['contents']);

                //                     $nuevoEquipo->update([
                //                         'FOTO_EQUIPO' => $pathFinal
                //                     ]);
                //                 }

                //                 $posicionImagenEquipo++;
                //                 $equipoInsertados++;
                //             }

                //             return response()->json([
                //                 'msj'  => 'Total de equipos agregados : ' . $equipoInsertados . ' de ' . $totalEquipos,
                //                 'code' => 200
                //             ]);
                //         } else {
                //             return response()->json(["msj" => 'No se ha subido ningún archivo', "code" => 500]);
                //         }
                //     } catch (Exception $e) {
                //         return response()->json([
                //             'msj'  => 'Se produjo un error al intentar cargar los equipos: ' . $e->getMessage(),
                //             'code' => 500
                //         ]);
                //     }



                case 2:
                    try {
                        if ($request->hasFile('excelEquipos')) {
                            $excel = $request->file('excelEquipos');

                            $spreadsheet = IOFactory::load($excel->getPathname());
                            $sheet = $spreadsheet->getActiveSheet();
                            $data = $sheet->toArray(null, true, true, true);

                            // Saltar encabezados (filas 1 y 2)
                            array_shift($data);
                            array_shift($data);

                            $datosGenerales = [];
                            foreach ($data as $row) {
                                if (!empty(array_filter($row))) {
                                    $datosGenerales[] = $row;
                                }
                            }

                            // Obtener imágenes y mapearlas a su fila
                            $drawings = $sheet->getDrawingCollection();
                            $imagenesMap = []; // Mapa: fila => imagen

                            foreach ($drawings as $drawing) {
                                $coordinates = $drawing->getCoordinates();
                                $col = strtoupper(preg_replace('/[0-9]/', '', $coordinates));
                                $rowNum = preg_replace('/[^0-9]/', '', $coordinates);

                                // Solo columna K
                                if ($col !== 'K') continue;

                                // Extraer contenido de la imagen
                                if ($drawing instanceof MemoryDrawing) {
                                    ob_start();
                                    call_user_func($drawing->getRenderingFunction(), $drawing->getImageResource());
                                    $imageContents = ob_get_contents();
                                    ob_end_clean();

                                    $extension = 'png';
                                    switch ($drawing->getMimeType()) {
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

                                $imagenesMap[$rowNum] = [
                                    'contents' => $imageContents,
                                    'extension' => $extension
                                ];
                            }

                            // Guardar en DB
                            $totalEquipos = count($datosGenerales);
                            $equipoInsertados = 0;
                            $filaExcel = 3; // La fila de datos inicia en 3 (ya se saltaron 2 encabezados)

                            foreach ($datosGenerales as $rowData) {
                                // Insertar equipo
                                $nuevoEquipo = inventarioModel::create([
                                    'DESCRIPCION_EQUIPO' => !empty($rowData['B']) ? $rowData['B'] : null,
                                    'MARCA_EQUIPO'       => !empty($rowData['C']) ? $rowData['C'] : null,
                                    'MODELO_EQUIPO'      => !empty($rowData['D']) ? $rowData['D'] : null,
                                    'SERIE_EQUIPO'       => !empty($rowData['E']) ? $rowData['E'] : null,
                                    'CODIGO_EQUIPO'      => !empty($rowData['F']) ? $rowData['F'] : null,
                                    'CANTIDAD_EQUIPO'    => !empty($rowData['G']) ? $rowData['G'] : null,
                                    'UBICACION_EQUIPO'   => !empty($rowData['I']) ? $rowData['I'] : null,
                                    'ESTADO_EQUIPO'      => !empty($rowData['J']) ? $rowData['J'] : null,
                                    'FECHA_ADQUISICION'  => !empty($rowData['L']) ? $rowData['L'] : null,
                                    'PROVEEDOR_EQUIPO'   => !empty($rowData['M']) ? $rowData['M'] : null,
                                    'UNITARIO_EQUIPO'    => !empty($rowData['N']) ? $rowData['N'] : null,
                                    'TOTAL_EQUIPO'       => !empty($rowData['O']) ? $rowData['O'] : null,
                                    'TIPO_EQUIPO'        => !empty($rowData['P']) ? $rowData['P'] : null,
                                    'OBSERVACION_EQUIPO' => !empty($rowData['Q']) ? $rowData['Q'] : null,
                                    'FOTO_EQUIPO'        => null
                                ]);

                                // Verificar si hay imagen en la fila actual
                                if (isset($imagenesMap[$filaExcel])) {
                                    $imagen = $imagenesMap[$filaExcel];
                                    $filename = 'foto_equipo.' . $imagen['extension'];
                                    $pathFinal = 'Almacén/Inventario/' . $nuevoEquipo->ID_FORMULARIO_INVENTARIO . '/' . $filename;

                                    Storage::put($pathFinal, $imagen['contents']);

                                    $nuevoEquipo->update([
                                        'FOTO_EQUIPO' => $pathFinal
                                    ]);
                                } else {
                                    // Si no hay imagen, opcionalmente puedes dejar null o 'N/A'
                                    $nuevoEquipo->update([
                                        'FOTO_EQUIPO' => null // o 'N/A' si quieres texto explícito
                                    ]);
                                }

                                $equipoInsertados++;
                                $filaExcel++;
                            }

                            return response()->json([
                                'msj'  => 'Total de equipos agregados: ' . $equipoInsertados . ' de ' . $totalEquipos,
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
            return response()->json('Error al guardar');
        }
    }


}
