<?php

namespace App\Models\ordentrabajo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_ORDEN';
    protected $table = 'formulario_ordentrabajo';
    protected $fillable = [
        'OFERTA_ID',
        'NO_ORDEN_CONFIRMACION',
        'FECHA_EMISION',
        'VERIFICADO_POR',
        'FECHA_VERIFICACION',
        'PRIORIDAD_SERVICIO',
        'FECHA_INICIO_SERVICIO',
        'ACTIVO',

    ];
}
