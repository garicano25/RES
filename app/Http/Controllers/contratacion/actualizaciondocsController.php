<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


use App\Models\contratacion\fechasactualizaciondocs;
use App\Models\contratacion\documentosactualizadosModel;



use DB;

class actualizaciondocsController extends Controller
{

    public function index()
    {
        $ultimaFecha = fechasactualizaciondocs::where('ACTIVO', 1)
            ->orderBy('ID_ACTUALIZACION_DOCUMENTOS', 'desc')
            ->first();

        return view('RH.contratacion.actualizaciondoc', compact('ultimaFecha'));
    }



    public function Tabladocumentosactualizados()
    {
        try {

            $tabla = DB::table('documento_actualizados as da')
                ->leftJoin('formulario_contratacion as fc', 'da.CURP', '=', 'fc.CURP')
                ->select(
                    'da.*',
                    DB::raw("CONCAT(
            COALESCE(fc.NOMBRE_COLABORADOR,''), ' ',
            COALESCE(fc.PRIMER_APELLIDO,''), ' ',
            COALESCE(fc.SEGUNDO_APELLIDO,'')
                ) as NOMBRE_COMPLETO")
                )
                ->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosactualizados" data-id="' . $value->ID_DOCUMENTOS_ACTUALIZADOS . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                } else {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosactualizados" data-id="' . $value->ID_DOCUMENTOS_ACTUALIZADOS . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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




    public function mostrardocumentoactualizado($id)
    {
        $archivo = documentosactualizadosModel::findOrFail($id)->DOCUMENTO_SOPORTE;
        return Storage::response($archivo);
    }


    public function validarPeriodoActualizacion()
    {
        try {

            $ultimo = fechasactualizaciondocs::orderBy('ID_ACTUALIZACION_DOCUMENTOS', 'desc')
                ->first();

            if (!$ultimo) {
                return response()->json([
                    'ok' => true,
                    'mostrar' => false
                ]);
            }

            $hoy = Carbon::now();

            $inicio = Carbon::parse($ultimo->FECHA_INICIO)->startOfDay();
            $fin = Carbon::parse($ultimo->FECHA_FIN)->endOfDay();

           

            return response()->json([
                'ok' => true,
                'mostrar' => $hoy->between($inicio, $fin)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'mostrar' => false
            ]);
        }
    }

    public function store(Request $request)
    {
        try {

            switch (intval($request->api)) {

                case 1:

                    $existe = fechasactualizaciondocs::where('FECHA_INICIO', $request->FECHA_INICIO)
                        ->where('FECHA_FIN', $request->FECHA_FIN)
                        ->first();

                    if ($existe) {
                        return response()->json([
                            'code' => 1,
                            'fecha' => $existe
                        ]);
                    }

                   
                    DB::statement('ALTER TABLE fechas_actualizaciondocs AUTO_INCREMENT=1;');

                    $fechas = fechasactualizaciondocs::create([
                        'FECHA_INICIO' => $request->FECHA_INICIO,
                        'FECHA_FIN' => $request->FECHA_FIN,
                        'ACTIVO' => 1
                    ]);

                    return response()->json([
                        'code' => 1,
                        'fecha' => $fechas
                    ]);

                    break;

                default:
                    return response()->json([
                        'code' => 0,
                        'msj' => 'Api no encontrada'
                    ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'code' => 0,
                'msj' => 'Error al guardar las fechas',
                'error' => $e->getMessage()
            ]);
        }
    }


    }
