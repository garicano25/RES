<?php

namespace App\Http\Controllers\ordencompra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;

use App\Models\ordencompra\poModel;
use App\Models\HojaTrabajo;


class poController extends Controller
{
    public function Tablaordencompra()
    {
        try {
            $tabla = poModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                 
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
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





    public function obtenerMaterialesPO($hoja_id)
    {
        try {
            $hoja =HojaTrabajo::find($hoja_id);

            if (!$hoja) {
                return response()->json([
                    'status' => 'error',
                    'msj' => 'No se encontró la hoja de trabajo.'
                ], 404);
            }

            $proveedor = $hoja->PROVEEDOR_SELECCIONADO;

            $subtotal = $iva = $importe = null;

            if ($proveedor == $hoja->PROVEEDOR_Q1) {
                $subtotal = $hoja->SUBTOTAL_Q1;
                $iva = $hoja->IVA_Q1;
                $importe = $hoja->IMPORTE_Q1;
            } elseif ($proveedor == $hoja->PROVEEDOR_Q2) {
                $subtotal = $hoja->SUBTOTAL_Q2;
                $iva = $hoja->IVA_Q2;
                $importe = $hoja->IMPORTE_Q2;
            } elseif ($proveedor == $hoja->PROVEEDOR_Q3) {
                $subtotal = $hoja->SUBTOTAL_Q3;
                $iva = $hoja->IVA_Q3;
                $importe = $hoja->IMPORTE_Q3;
            }

            if (!empty($hoja->MATERIALES_HOJA_JSON)) {
                $json = json_decode($hoja->MATERIALES_HOJA_JSON, true);
                $materiales = [];

                foreach ($json as $item) {
                    $materiales[] = [
                        'DESCRIPCION' => $item['DESCRIPCION'] ?? '',
                        'CANTIDAD_REAL' => $item['CANTIDAD_REAL'] ?? '',
                        'PRECIO_UNITARIO' => $item['PRECIO_UNITARIO'] ?? '',
                    ];
                }

                return response()->json([
                    'status' => 'success',
                    'proveedor' => $proveedor,
                    'materiales' => $materiales,
                    'subtotal' => $subtotal,
                    'iva' => $iva,
                    'importe' => $importe,
                ]);
            }

            $cantidad_real = $precio_unitario = null;

            if ($proveedor == $hoja->PROVEEDOR_Q1) {
                $cantidad_real = $hoja->CANTIDAD_REALQ1;
                $precio_unitario = $hoja->PRECIO_UNITARIOQ1;
            } elseif ($proveedor == $hoja->PROVEEDOR_Q2) {
                $cantidad_real = $hoja->CANTIDAD_REALQ2;
                $precio_unitario = $hoja->PRECIO_UNITARIOQ2;
            } elseif ($proveedor == $hoja->PROVEEDOR_Q3) {
                $cantidad_real = $hoja->CANTIDAD_REALQ3;
                $precio_unitario = $hoja->PRECIO_UNITARIOQ3;
            }

            return response()->json([
                'status' => 'success',
                'proveedor' => $proveedor,
                'materiales' => [[
                    'DESCRIPCION' => $hoja->DESCRIPCION,
                    'CANTIDAD' => null,
                    'CANTIDAD_REAL' => $cantidad_real,
                    'PRECIO_UNITARIO' => $precio_unitario,
                ]],
                'subtotal' => $subtotal,
                'iva' => $iva,
                'importe' => $importe,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


}