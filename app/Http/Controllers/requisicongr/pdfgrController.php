<?php

namespace App\Http\Controllers\requisicongr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use DB;

use App\Models\proveedor\directorioModel;
use App\Models\proveedor\proveedortempModel;


class pdfgrController extends Controller
{

    // public function generarGRpdf($id)
    // {
    //     try {

    //         $orden = DB::table('formulario_bitacoragr')->where('ID_GR', $id)->first();

    //         if (!$orden) {
    //             return response()->json(['error' => 'No se encontró la GR con ese ID.'], 404);
    //         }


    //         if (trim($orden->FINALIZAR_GR ?? '') !== 'Sí') {
    //             return response()->json([
    //                 'error' => 'La GR no está finalizada aún. Solo se puede descargar cuando esta finalizada.'
    //             ], 400);
    //         }

    //         $proveedor = null;

    //         if (!empty($orden->PROVEEDOR_KEY)) {
    //             $proveedor = directorioModel::where('RFC_PROVEEDOR', $orden->PROVEEDOR_KEY)->first();
    //         }

    //         if (!$proveedor) {
    //             $proveedor = (object)[
    //                 'TIPO_PERSONA' => '1',
    //                 'RAZON_SOCIAL' => 'N/A',
    //                 'RFC_PROVEEDOR' => 'N/A',
    //                 'NOMBRE_DIRECTORIO' => 'N/A',
    //                 'TIPO_VIALIDAD_EMPRESA' => 'N/A',
    //                 'NOMBRE_VIALIDAD_EMPRESA' => 'N/A',
    //                 'NUMERO_EXTERIOR_EMPRESA' => 'N/A',
    //                 'NUMERO_INTERIOR_EMPRESA' => 'N/A',
    //                 'NOMBRE_COLONIA_EMPRESA' => 'N/A',
    //                 'CODIGO_POSTAL' => 'N/A',
    //                 'NOMBRE_LOCALIDAD_EMPRESA' => 'N/A',
    //                 'NOMBRE_ENTIDAD_EMPRESA' => 'N/A',
    //                 'PAIS_EMPRESA' => 'México',
    //                 'TELEFONO_DIRECOTORIO' => 'N/A',
    //                 'CELULAR_DIRECTORIO' => 'N/A',
    //                 'CORREO_DIRECTORIO' => 'N/A'
    //             ];
    //         }


    //         $usuarioSolicito = DB::table('usuarios')
    //             ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
    //             ->where('ID_USUARIO', $orden->USUARIO_ID)
    //             ->first();


    //         $detalles = DB::table('formulario_bitacoragr_detalle')
    //             ->where('ID_GR', $id)
    //             ->where(function ($query) {
    //                 $query->whereNull('BIENS_PARCIAL')
    //                     ->orWhere('BIENS_PARCIAL', 'No');
    //             })
    //             ->select(
    //                 'DESCRIPCION',
    //                 'CANTIDAD',
    //                 'CANTIDAD_RECHAZADA',
    //                 'CANTIDAD_ACEPTADA',
    //                 'VOBO_USUARIO_PRODUCTO',
    //                 'BIENS_PARCIAL'
    //             )
    //             ->get();


    //         $pdf = Pdf::loadView('pdf.gr_pdf', [
    //             'orden' => $orden,
    //             'proveedor' => $proveedor,
    //             'usuarioSolicito' => $usuarioSolicito,
    //             'detalles' => $detalles,
    //         ])->setPaper('letter', 'portrait');

    //           $noRecepcion = $orden->NO_RECEPCION ?? 'SIN_NUMERO';
    //         $fileName = $noRecepcion . '.pdf';
    //         return $pdf->download($fileName);
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'error' => 'Error al generar el PDF: ' . $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ], 500);
    //     }
    // }


    public function generarGRpdf($id)
    {
        try {
            $orden = DB::table('formulario_bitacoragr')->where('ID_GR', $id)->first();

            if (!$orden) {
                return response()->json(['error' => 'No se encontró la GR con ese ID.'], 404);
            }

            if (trim($orden->FINALIZAR_GR ?? '') !== 'Sí') {
                return response()->json([
                    'error' => 'La GR no está finalizada aún. Solo se puede descargar cuando está finalizada.'
                ], 400);
            
            }

            $proveedor = null;

            if (!empty($orden->PROVEEDOR_KEY)) {
                $proveedor = directorioModel::where('RFC_PROVEEDOR', $orden->PROVEEDOR_KEY)->first();
            }

            if (!$proveedor && !empty($orden->PROVEEDOR_KEY)) {
                $temp = proveedortempModel::where('RAZON_PROVEEDORTEMP', $orden->PROVEEDOR_KEY)->first();

                if ($temp) {
                    $proveedor = (object)[
                        'TIPO_PERSONA' => 'TEMP',
                        'RAZON_SOCIAL' => $temp->RAZON_PROVEEDORTEMP ?: 'N/P',
                        'RFC_PROVEEDOR' => $temp->RFC_PROVEEDORTEMP ?: 'N/P',
                        'NOMBRE_DIRECTORIO' => '',
                        'TIPO_VIALIDAD_EMPRESA' => '',
                        'NOMBRE_VIALIDAD_EMPRESA' => '',
                        'NUMERO_EXTERIOR_EMPRESA' => '',
                        'NUMERO_INTERIOR_EMPRESA' => '',
                        'NOMBRE_COLONIA_EMPRESA' => '',
                        'CODIGO_POSTAL' => '',
                        'NOMBRE_LOCALIDAD_EMPRESA' => '',
                        'NOMBRE_ENTIDAD_EMPRESA' => '',
                        'PAIS_EMPRESA' => '',
                        'TELEFONO_DIRECOTORIO' =>  '',
                        'CELULAR_DIRECTORIO' =>  '',
                        'CORREO_DIRECTORIO' =>  '',
                        'DOMICILIO_EXTRANJERO' => '',
                        'DEPARTAMENTO_EXTRANJERO' => '',
                        'CODIGO_EXTRANJERO' => '',
                        'ESTADO_EXTRANJERO' => '',
                        'CIUDAD_EXTRANJERO' => '',
                        'PAIS_EXTRANJERO' => ''
                    ];
                }
            }

            // 🔹 3. Si no se encontró en ningún lado → asignar valores por defecto
            if (!$proveedor) {
                $proveedor = (object)[
                    'TIPO_PERSONA' => '1',
                    'RAZON_SOCIAL' => 'N/P',
                    'RFC_PROVEEDOR' => 'N/P',
                    'NOMBRE_DIRECTORIO' => '',
                    'TIPO_VIALIDAD_EMPRESA' => '',
                    'NOMBRE_VIALIDAD_EMPRESA' => '',
                    'NUMERO_EXTERIOR_EMPRESA' => '',
                    'NUMERO_INTERIOR_EMPRESA' => '',
                    'NOMBRE_COLONIA_EMPRESA' => '',
                    'CODIGO_POSTAL' => '',
                    'NOMBRE_LOCALIDAD_EMPRESA' => '',
                    'NOMBRE_ENTIDAD_EMPRESA' => '',
                    'PAIS_EMPRESA' => '',
                    'TELEFONO_DIRECOTORIO' => '',
                    'CELULAR_DIRECTORIO' => '',
                    'CORREO_DIRECTORIO' => '',
                    'DOMICILIO_EXTRANJERO' => '',
                    'DEPARTAMENTO_EXTRANJERO' => '',
                    'CODIGO_EXTRANJERO' => '',
                    'ESTADO_EXTRANJERO' => '',
                    'CIUDAD_EXTRANJERO' => '',
                    'PAIS_EXTRANJERO' => ''
                ];
            }

            $usuarioSolicito = DB::table('usuarios')
                ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
                ->where('ID_USUARIO', $orden->USUARIO_ID)
                ->first();

   
            $detalles = DB::table('formulario_bitacoragr_detalle')
                ->where('ID_GR', $id)
                ->where(function ($query) {
                    $query->where(function ($q1) {
                        $q1->whereNull('BIENS_PARCIAL')
                            ->orWhere('BIENS_PARCIAL', '')
                            ->orWhere('BIENS_PARCIAL', 'No');
                    })
                        ->orWhere(function ($q2) {
                            $q2->where('BIENS_PARCIAL', 'Sí')
                                ->where(function ($q3) {
                                    $q3->whereNotNull('CANTIDAD_ACEPTADA')
                                        ->where('CANTIDAD_ACEPTADA', '>', 0);
                                });
                        });
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
            return $pdf->download($noRecepcion . '.pdf');
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error al generar el PDF: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}




