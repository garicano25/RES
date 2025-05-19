<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HojaTrabajo extends Model
{
    protected $table = 'hoja_trabajo';

    protected $fillable = [
        'NO_MR',
        'DESCRIPCION',
        'CANTIDAD',
        'UNIDAD_MEDIDA',

        // Cotización Q1
        'PROVEEDOR_Q1',
        'SUBTOTAL_Q1',
        'IVA_Q1',
        'IMPORTE_Q1',
        'OBSERVACIONES_Q1',
        'FECHA_COTIZACION_Q1',
        'DOCUMENTO_Q1',

        // Cotización Q2
        'PROVEEDOR_Q2',
        'SUBTOTAL_Q2',
        'IVA_Q2',
        'IMPORTE_Q2',
        'OBSERVACIONES_Q2',
        'FECHA_COTIZACION_Q2',
        'DOCUMENTO_Q2',

        // Cotización Q3
        'PROVEEDOR_Q3',
        'SUBTOTAL_Q3',
        'IVA_Q3',
        'IMPORTE_Q3',
        'OBSERVACIONES_Q3',
        'FECHA_COTIZACION_Q3',
        'DOCUMENTO_Q3',

        // Datos adicionales
        'SOLICITAR_VERIFICACION',
        'PROVEEDOR_SUGERIDO',
        'FORMA_ADQUISICION',
        'PROVEEDOR_SELECCIONADO',
        'MONTO_FINAL',
        'FORMA_PAGO',
        'REQUIERE_PO',
    ];
}