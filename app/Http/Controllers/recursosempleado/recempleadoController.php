<?php

namespace App\Http\Controllers\recursosempleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;





class recempleadoController extends Controller
{



    public function obtenerDatosPermiso()
    {
        try {
            $curp = auth()->user()->CURP;

            // Cargo
            $cargo = DB::table('contratos_anexos_contratacion as cac')
                ->join('catalogo_categorias as cc', 'cc.ID_CATALOGO_CATEGORIA', '=', 'cac.NOMBRE_CARGO')
                ->where('cac.CURP', $curp)
                ->orderBy('cac.ID_CONTRATOS_ANEXOS', 'desc')
                ->select('cc.NOMBRE_CATEGORIA')
                ->first();

            // Número de empleado
            $empleado = DB::table('formulario_contratacion')
                ->where('CURP', $curp)
                ->select('NUMERO_EMPLEADO')
                ->first();

            return response()->json([
                'cargo' => $cargo ? $cargo->NOMBRE_CATEGORIA : 'No disponible',
                'numero_empleado' => $empleado ? $empleado->NUMERO_EMPLEADO : 'No disponible'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener datos: ' . $e->getMessage()
            ], 500);
        }
    }





}
