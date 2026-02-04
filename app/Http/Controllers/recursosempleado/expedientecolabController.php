<?php

namespace App\Http\Controllers\recursosempleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


use App\Models\contratacion\contratacionModel;
use App\Models\contratacion\documentosoporteModel;
use App\Models\contratacion\contratosanexosModel;
use App\Models\contratacion\documentoscolaboradorcontratoModel;
use App\Models\contratacion\reingresocontratoModel;

use App\Models\contratacion\reciboscontratoModel;
use App\Models\contratacion\informacionmedicaModel;
use App\Models\contratacion\incidenciasModel;
use App\Models\contratacion\accionesdisciplinariasModel;
use App\Models\contratacion\documentosoportecontratoModel;
use App\Models\contratacion\renovacioncontratoModel;
use App\Models\contratacion\adendarenovacionModel;
use App\Models\contratacion\requisicioncontratacion;

use App\Models\contratacion\adendacontratoModel;
use App\Models\recempleados\recemplaedosModel;


use App\Models\organizacion\catalogotipovacanteModel;
use App\Models\organizacion\catalogomotivovacanteModel;
use App\Models\organizacion\areasModel;

use DB;




class expedientecolabController extends Controller
{
    public function index()
    {
        $areas = DB::select("
        SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE, LUGAR_CATEGORIA AS LUGAR, PROPOSITO_CATEGORIA AS PROPOSITO, ES_LIDER_CATEGORIA AS LIDER
        FROM catalogo_categorias
        WHERE ACTIVO = 1
        ");


        $areas2 = areasModel::orderBy('NOMBRE', 'ASC')->get();

        $requisicioncategoria = DB::select("
                SELECT 
                    rec.*, 
                    cat.NOMBRE_CATEGORIA,
                    CASE 
                        WHEN rec.ANTES_DE1 = 1 THEN rec.FECHA_CREACION
                        ELSE rec.FECHA_RP
                    END AS FECHA_MOSTRAR
                FROM formulario_requerimientos rec
                LEFT JOIN catalogo_categorias cat 
                    ON cat.ID_CATALOGO_CATEGORIA = rec.PUESTO_RP
                WHERE rec.ESTADO_SOLICITUD = 'Aprobada'
            ");


        $tipos = catalogotipovacanteModel::orderBy('NOMBRE_TIPOVACANTE', 'ASC')->get();
        $motivos = catalogomotivovacanteModel::orderBy('NOMBRE_MOTIVO_VACANTE', 'ASC')->get();


        $areas1 = DB::select("
        SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE, LUGAR_CATEGORIA AS LUGAR, PROPOSITO_CATEGORIA AS PROPOSITO, ES_LIDER_CATEGORIA AS LIDER
        FROM catalogo_categorias
        WHERE ACTIVO = 1
        ");

        $todascategoria = DB::select("SELECT ID_CATALOGO_CATEGORIA  AS ID_CATALOGO_CATEGORIA, NOMBRE_CATEGORIA AS NOMBRE
                FROM catalogo_categorias
                WHERE ACTIVO = 1");


        $categoria = DB::select("
                SELECT c.ID_CATALOGO_CATEGORIA AS ID_DEPARTAMENTO_AREA, 
                    c.NOMBRE_CATEGORIA AS NOMBRE
                FROM catalogo_categorias c
                INNER JOIN formulario_dpt f ON c.ID_CATALOGO_CATEGORIA = f.DEPARTAMENTOS_AREAS_ID
                WHERE c.ACTIVO = 1
            ");


        return view('RH.RecEmpleados.expedientecolaborador', compact('areas', 'tipos', 'motivos', 'areas1', 'todascategoria', 'categoria', 'areas2', 'requisicioncategoria'));
    }



    public function Tablaexpediente()
    {
        try {

        
            $curpUsuario = Auth::user()->CURP;

            $tabla = contratacionModel::where('ACTIVO', 1)
                ->where('CURP', $curpUsuario)
                ->get();

            foreach ($tabla as $value) {
                $contrato = DB::table('contratos_anexos_contratacion')
                    ->where('CURP', $value->CURP)
                    ->orderByDesc('ID_CONTRATOS_ANEXOS')
                    ->first();

                if ($contrato) {
                    $renovacion = DB::table('renovacion_contrato')
                        ->where('CONTRATO_ID', $contrato->ID_CONTRATOS_ANEXOS)
                        ->orderByDesc('FECHAF_RENOVACION')
                        ->first();

                    $fechaInicio = $renovacion ? $renovacion->FECHAI_RENOVACION : $contrato->FECHAI_CONTRATO;
                    $fechaFin = $renovacion ? $renovacion->FECHAF_RENOVACION : $contrato->VIGENCIA_CONTRATO;
                } else {
                    $fechaInicio = null;
                    $fechaFin = null;
                }

                if ($fechaInicio && $fechaFin) {
                    $inicio = new \DateTime($fechaInicio);
                    $fin = new \DateTime($fechaFin);
                    $hoy = new \DateTime();

                    $totalDias = $inicio->diff($fin)->days;
                    $diasRestantes = ($fin >= $hoy) ? $hoy->diff($fin)->days : -$hoy->diff($fin)->days;

                    $umbralVerde = $totalDias * 0.60;
                    $umbralAmarillo = $totalDias * 0.30;

                    if ($diasRestantes <= 0) {
                        $estado_dias = "<span style='color: red;'>(Terminado)</span>";
                    } elseif ($diasRestantes <= $umbralAmarillo) {
                        $estado_dias = "<span style='color: red;'>($diasRestantes días restantes)</span>";
                    } elseif ($diasRestantes <= $umbralVerde) {
                        $estado_dias = "<span style='color: orange;'>($diasRestantes días restantes)</span>";
                    } else {
                        $estado_dias = "<span style='color: green;'>($diasRestantes días restantes)</span>";
                    }

                    $value->ESTATUS_CONTRATO = "$fechaInicio<br>$fechaFin<br>$estado_dias";
                } else {
                    $value->ESTATUS_CONTRATO = "<span style='color: gray;'>(Sin contrato)</span>";
                }

                // Botones
                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msj' => 'Error: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }



    /////////////////////////////////////////// STEP 2 DOCUMENTOS DE SOPORTE //////////////////////////////////

    public function Tabladocumentosoportexpediente(Request $request)
    {
        try {

            $curp = $request->get('curp');

            $tabla = documentosoporteModel::where('CURP', $curp)
                ->where('RENOVACION_DOCUMENTO', 1)
                ->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_DOCUMENTO_SOPORTE . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                } else {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_DOCUMENTO_SOPORTE . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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


    }
