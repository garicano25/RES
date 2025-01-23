<?php

namespace App\Models\ofertas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ofertasModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_OFERTAS';
    protected $table = 'formulario_ofertas';
    protected $fillable = [
        'SOLICITUD_ID',
        'NO_OFERTA',
        'REVISION_OFERTA',
        'FECHA_OFERTA',
        'TIEMPO_OFERTA',
        'SERVICIO_COTIZADO_OFERTA',
        'MONEDA_MONTO',
        'IMPORTE_OFERTA',
        'DIAS_VALIDACION_OFERTA',
        'OBSERVACIONES_OFERTA',
        'MOTIVO_RECHAZO',
        'ACEPTADA_OFERTA',
        'FECHA_ACEPTACION_OFERTA',
        'FECHA_FIRMA_OFERTA',
        'ESTATUS_OFERTA',
        'ACTIVO'
        
    ];
}
