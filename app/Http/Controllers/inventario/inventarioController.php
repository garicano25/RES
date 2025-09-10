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

use App\Models\inventario\entradasinventarioModel;


use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;

use DB;

class inventarioController extends Controller
{


    public function index()
    {
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();


        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();



        return view('almacen.inventario.inventario', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales'));
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

                $campos = [
                    'DESCRIPCION_EQUIPO',
                    'MARCA_EQUIPO',
                    'MODELO_EQUIPO',
                    'SERIE_EQUIPO',
                    'CODIGO_EQUIPO',
                    'CANTIDAD_EQUIPO',
                    'UBICACION_EQUIPO',
                    'ESTADO_EQUIPO',
                    'FECHA_ADQUISICION',
                    'PROVEEDOR_EQUIPO',
                    'UNITARIO_EQUIPO',
                    'TOTAL_EQUIPO',
                    'TIPO_EQUIPO',
                    'ACTIVO',
                    'OBSERVACION_EQUIPO'
                ];

                $completo = true;
                foreach ($campos as $campo) {
                    if (empty($value->$campo)) {
                        $completo = false;
                        break;
                    }
                }

                $value->ROW_CLASS = $completo ? 'bg-verde-suave' : 'bg-rojo-suave';
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


    



    public function mostrarFotoEquipo($usuario_id)
    {
        $foto = inventarioModel::findOrFail($usuario_id);
        return Storage::response($foto->FOTO_EQUIPO);
    }



    public function respaldarInventario()
    {
        try {
            // Obtener todos los registros de formulario_inventario
            $inventarios = DB::table('formulario_inventario')->get();

            foreach ($inventarios as $inv) {
                DB::table('inventario_respaldo')->insert([
                    'INVENTARIO_ID'       => $inv->ID_FORMULARIO_INVENTARIO, // ID original
                    'FOTO_EQUIPO'         => $inv->FOTO_EQUIPO,
                    'DESCRIPCION_EQUIPO'  => $inv->DESCRIPCION_EQUIPO,
                    'MARCA_EQUIPO'        => $inv->MARCA_EQUIPO,
                    'MODELO_EQUIPO'       => $inv->MODELO_EQUIPO,
                    'SERIE_EQUIPO'        => $inv->SERIE_EQUIPO,
                    'CODIGO_EQUIPO'       => $inv->CODIGO_EQUIPO,
                    'CANTIDAD_EQUIPO'     => $inv->CANTIDAD_EQUIPO,
                    'UBICACION_EQUIPO'    => $inv->UBICACION_EQUIPO,
                    'ESTADO_EQUIPO'       => $inv->ESTADO_EQUIPO,
                    'FECHA_ADQUISICION'   => $inv->FECHA_ADQUISICION,
                    'PROVEEDOR_EQUIPO'    => $inv->PROVEEDOR_EQUIPO,
                    'UNITARIO_EQUIPO'     => $inv->UNITARIO_EQUIPO,
                    'TOTAL_EQUIPO'        => $inv->TOTAL_EQUIPO,
                    'TIPO_EQUIPO'         => $inv->TIPO_EQUIPO,
                    'ACTIVO'              => $inv->ACTIVO,
                    'OBSERVACION_EQUIPO'  => $inv->OBSERVACION_EQUIPO,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
            }

            return response()->json(['message' => 'Respaldo realizado con éxito.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al respaldar: ' . $e->getMessage()], 500);
        }
    }



    /////////////////////////////////// ENTRADA INVENTARIO /////////////////////////////////// 
    public function Tablaentradainventario(Request $request)
    {
        try {
            $inventarioId = $request->get('inventario');
            $data = [];
            $primerEntradaId = null;

            // =========================
            // 1. Buscar saldo inicial en inventario_respaldo
            // =========================
            $saldoInicial = DB::table('inventario_respaldo')
                ->where('INVENTARIO_ID', $inventarioId)
                ->first(['CANTIDAD_EQUIPO', 'FECHA_ADQUISICION', 'UNITARIO_EQUIPO']);

            if ($saldoInicial) {
                // viene del respaldo
                $data[] = [
                    'FECHA_INGRESO'     => $saldoInicial->FECHA_ADQUISICION,
                    'CANTIDAD_PRODUCTO' => $saldoInicial->CANTIDAD_EQUIPO, 
                    'VALOR_UNITARIO'    => $saldoInicial->UNITARIO_EQUIPO,
                    'COSTO_TOTAL'       => $saldoInicial->CANTIDAD_EQUIPO * $saldoInicial->UNITARIO_EQUIPO,
                    'TIPO'              => '<span class="badge bg-warning text-dark">Saldo inicial</span>',
                    'BTN_EDITAR'        => '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
                    'BTN_VISUALIZAR'    => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>'
                ];
            } else {
                // =========================
                // 2. Si no hay respaldo, usar primer registro de entradas_inventario
                // =========================
                $primerEntrada = DB::table('entradas_inventario')
                    ->where('INVENTARIO_ID', $inventarioId)
                    ->orderBy('FECHA_INGRESO', 'asc')
                    ->first();

                if ($primerEntrada) {
                    $primerEntradaId = $primerEntrada->ID_ENTRADA_FORMULARIO; 

                    $data[] = [
                        'FECHA_INGRESO'     => $primerEntrada->FECHA_INGRESO,
                        // 'CANTIDAD_PRODUCTO' => $primerEntrada->CANTIDAD_PRODUCTO, // saldo inicial → solo cantidad
                        'CANTIDAD_PRODUCTO' => $primerEntrada->CANTIDAD_PRODUCTO . ($primerEntrada->UNIDAD_MEDIDA ? " ({$primerEntrada->UNIDAD_MEDIDA})" : ""),
                        'VALOR_UNITARIO'    => $primerEntrada->VALOR_UNITARIO,
                        'COSTO_TOTAL'       => $primerEntrada->CANTIDAD_PRODUCTO * $primerEntrada->VALOR_UNITARIO,
                        'TIPO'              => '<span class="badge bg-warning text-dark">Saldo inicial</span>',
                        'BTN_EDITAR'        => '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
                        'BTN_VISUALIZAR'    => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>'
                    ];
                }
            }

            // =========================
            // 3. Agregar las demás entradas, excluyendo la primera si ya se usó como saldo inicial
            // =========================
            $entradasQuery = DB::table('entradas_inventario')
                ->where('INVENTARIO_ID', $inventarioId);

            if ($primerEntradaId) {
                $entradasQuery->where('ID_ENTRADA_FORMULARIO', '!=', $primerEntradaId);
            }

            $entradas = $entradasQuery->get();

            foreach ($entradas as $entrada) {
                $data[] = [
                    'FECHA_INGRESO'     => $entrada->FECHA_INGRESO,
                    'CANTIDAD_PRODUCTO' => $entrada->CANTIDAD_PRODUCTO . ($entrada->UNIDAD_MEDIDA ? " ({$entrada->UNIDAD_MEDIDA})" : ""),
                    'VALOR_UNITARIO'    => $entrada->VALOR_UNITARIO,
                    'COSTO_TOTAL'       => $entrada->CANTIDAD_PRODUCTO * $entrada->VALOR_UNITARIO,
                    'TIPO'              => '', 
                    'BTN_EDITAR'        => '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
                    'BTN_VISUALIZAR'    => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>'
                ];
            }

            return response()->json([
                'data' => $data,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }






    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
             
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

                 case 2:
                    try {
                        if ($request->hasFile('excelEquipos')) {
                            $excel = $request->file('excelEquipos');

                            $spreadsheet = IOFactory::load($excel->getPathname());
                            $sheet = $spreadsheet->getActiveSheet();
                            $data = $sheet->toArray(null, true, true, true);

                            array_shift($data);
                            array_shift($data);

                            $datosGenerales = [];
                            foreach ($data as $row) {
                                if (!empty(array_filter($row))) {
                                    $datosGenerales[] = $row;
                                }
                            }

                            $drawings = $sheet->getDrawingCollection();
                            $imagenesMap = []; 

                            foreach ($drawings as $drawing) {
                                $coordinates = $drawing->getCoordinates();
                                $col = strtoupper(preg_replace('/[0-9]/', '', $coordinates));
                                $rowNum = preg_replace('/[^0-9]/', '', $coordinates);

                                if ($col !== 'K') continue;

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

                            $totalEquipos = count($datosGenerales);
                            $equipoInsertados = 0;
                            $filaExcel = 3; 

                            foreach ($datosGenerales as $rowData) {
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

                                if (isset($imagenesMap[$filaExcel])) {
                                    $imagen = $imagenesMap[$filaExcel];
                                    $filename = 'foto_equipo.' . $imagen['extension'];
                                    $pathFinal = 'Almacén/Inventario/' . $nuevoEquipo->ID_FORMULARIO_INVENTARIO . '/' . $filename;

                                    Storage::put($pathFinal, $imagen['contents']);

                                    $nuevoEquipo->update([
                                        'FOTO_EQUIPO' => $pathFinal
                                    ]);
                                } else {
                                    $nuevoEquipo->update([
                                        'FOTO_EQUIPO' => null 
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
