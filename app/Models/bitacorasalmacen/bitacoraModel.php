<?php

namespace App\Models\bitacorasalmacen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bitacoraModel extends Model
{
    protected $primaryKey = 'ID_BITACORAS_ALMACEN';
    protected $table = 'bitacorasalmacen';
    protected $fillable = [


        'RECEMPLEADO_ID',
        'INVENTARIO_ID',
        'SOLICITANTE_SALIDA',
        'FECHA_SALIDA',
        'DESCRIPCION',
        'CANTIDAD',
        'CANTIDAD_SALIDA',
        'INVENTARIO',
        'FUNCIONAMIENTO_BITACORA',
        'OBSERVACIONES_REC',
        'RECIBIDO_POR',
        'ENTREGADO_POR',
        'FIRMA_RECIBIDO_POR',
        'FIRMA_ENTREGADO_POR',
        'OBSERVACIONES_BITACORA',
        'ACTIVO',
        'UNIDAD'

    ];
}