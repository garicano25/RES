<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formulariorequerimientoModel extends Model
{
    protected $primaryKey = 'ID_FORMULARO_REQUERIMIENTO';
    protected $table = 'formulario_requerimientos';
    protected $fillable = [
        'FECHA_RP',
        'PRIORIDAD_RP',
        'TIPO_VACANTE_RP',
        'MOTIVO_VACANTE_RP',
        'SUSTITUYE_RP',
        'CENTRO_COSTO_RP',
        'AREA_RP',
        'NO_VACANTES_RP',
        'PUESTO_RP',
        'FECHA_INICIO_RP',
        'OBSERVACION1_RP',
        'OBSERVACION2_RP',
        'OBSERVACION3_RP',
        'OBSERVACION4_RP',
        'OBSERVACION5_RP',
        'CORREO_CORPORATIVO_RP',
        'TELEFONO_CORPORATIVO_RP',
        'SOFTWARE_RP',
        'VEHICULO_EMPRESA_RP',
        'SOLICITA_RP',
        'AUTORIZA_RP',
        
    ];
}
