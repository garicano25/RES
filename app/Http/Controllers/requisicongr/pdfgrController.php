<?php

namespace App\Http\Controllers\requisicongr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use DB;

use App\Models\proveedor\directorioModel;


class pdfgrController extends Controller
{
    
    public function generarGRpdf($id)
    {
        try {
            // ===============================
            // 🔹 1. Obtener la GR principal
            // ===============================
            $orden = DB::table('formulario_bitacoragr')->where('ID_GR', $id)->first();

            if (!$orden) {
                return response()->json(['error' => 'No se encontró la GR con ese ID.'], 404);
            }

      
            if (trim($orden->FINALIZAR_GR ?? '') !== 'Sí') {
                return response()->json([
                    'error' => 'La GR no está finalizada aún. Solo se puede descargar cuando esta finalizada.'
                ], 400);
            }

            $proveedor = null;

            if (!empty($orden->PROVEEDOR_KEY)) {
                $proveedor = directorioModel::where('RFC_PROVEEDOR', $orden->PROVEEDOR_KEY)->first();
            }

            if (!$proveedor) {
                $proveedor = (object)[
                    'TIPO_PERSONA' => '1',
                    'RAZON_SOCIAL' => 'N/A',
                    'RFC_PROVEEDOR' => 'N/A',
                    'NOMBRE_DIRECTORIO' => 'N/A',
                    'TIPO_VIALIDAD_EMPRESA' => 'N/A',
                    'NOMBRE_VIALIDAD_EMPRESA' => 'N/A',
                    'NUMERO_EXTERIOR_EMPRESA' => 'N/A',
                    'NUMERO_INTERIOR_EMPRESA' => 'N/A',
                    'NOMBRE_COLONIA_EMPRESA' => 'N/A',
                    'CODIGO_POSTAL' => 'N/A',
                    'NOMBRE_LOCALIDAD_EMPRESA' => 'N/A',
                    'NOMBRE_ENTIDAD_EMPRESA' => 'N/A',
                    'PAIS_EMPRESA' => 'México',
                    'TELEFONO_DIRECOTORIO' => 'N/A',
                    'CELULAR_DIRECTORIO' => 'N/A',
                    'CORREO_DIRECTORIO' => 'N/A'
                ];
            }


            $usuarioSolicito = DB::table('usuarios')
                ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
                ->where('ID_USUARIO', $orden->USUARIO_ID)
                ->first();


            // $detalles = DB::table('formulario_bitacoragr_detalle')
            //     ->where('ID_GR', $id)
            //     ->select('DESCRIPCION', 'CANTIDAD', 'CANTIDAD_RECHAZADA', 'CANTIDAD_ACEPTADA', 'VOBO_USUARIO_PRODUCTO')
            //     ->get();


            $detalles = DB::table('formulario_bitacoragr_detalle')
                ->where('ID_GR', $id)
                ->where(function ($query) {
                    $query->whereNull('BIENS_PARCIAL')
                        ->orWhere('BIENS_PARCIAL', 'No');
                })
                ->select(
                    'DESCRIPCION',
                    'CANTIDAD',
                    'CANTIDAD_RECHAZADA',
                    'CANTIDAD_ACEPTADA',
                    'VOBO_USUARIO_PRODUCTO',
                    'BIENS_PARCIAL'
                )
                ->get();


            $pdf = Pdf::loadView('pdf.gr_pdf', [
                'orden' => $orden,
                'proveedor' => $proveedor,
                'usuarioSolicito' => $usuarioSolicito,
                'detalles' => $detalles,
            ])->setPaper('letter', 'portrait');

              $noRecepcion = $orden->NO_RECEPCION ?? 'SIN_NUMERO';
            $fileName = $noRecepcion . '.pdf';
            return $pdf->download($fileName);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error al generar el PDF: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}




