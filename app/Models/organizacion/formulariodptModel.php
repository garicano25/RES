<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formulariodptModel extends Model
{

    protected $primaryKey = 'ID_FORMULARIO_DPT';
    protected $table = 'formulario_dpt';
    protected $fillable = [
        'DEPARTAMENTOS_AREAS_ID',
        'AREA_TRABAJO_DPT',
        'PROPOSITO_FINALIDAD_DPT',
        'NIVEL_JERARQUICO_DPT',
        'PUESTO_REPORTA_DPT',
        'PUESTO_LE_REPORTAN_DPT',
        'PUESTOS_INTERACTUAN_DPT',
        'PUESTOS_DIRECTOS_DPT',
        'PUESTOS_INDIRECTOS_DPT',      
        'LUGAR_TRABAJO_DPT',
        'DISPONIBILIDAD_VIAJAR',
        'HORARIO_ENTRADA_DPT',
        'HORARIO_SALIDA_DPT',
        'FUNCIONES_CARGO_DPT',
        'FUNCIONES_GESTION_DPT',
        'ESCALA_INNOVACION',
        'ESCALA_PASION',
        'ESCALA_SERVICIO',
        'ESCALA_COMUNICACION',
        'ESCALA_TRABAJO',
        'ESCALA_INTEGRIDAD',
        'ESCALA_RESPONSABILIDAD',
        'ESCALA_ADAPTIBILIDAD',
        'ESCALA_LIDERAZGO',
        'ESCALA_TOMADECISION',
        'DE_INFORMACION_DPT',
        'DE_RECURSOS_DPT',
        'DE_INFORMACION_ESPECIFIQUE_DPT',
        'DE_RECURSOS_ESPECIFIQUE_DPT',
        'DE_EQUIPOS_DPT',
        'DE_VEHICULOS_DPT',
        'DE_EQUIPOS_ESPECIFIQUE_DPT',
        'DE_VEHICULOS_ESPECIFIQUE_DPT',
        'OBSERVACIONES_DPT',
        'ORGANIGRAMA_DPT',
        'ELABORADO_NOMBRE_DPT',
        'ELABORADO_FIRMA_DPT',
        'ELABORADO_FECHA_DPT',
        'REVISADO_NOMBRE_DPT',
        'REVISADO_FIRMA_DPT',
        'REVISADO_FECHA_DPT',
        'AUTORIZADO_NOMBRE_DPT',
        'AUTORIZADO_FIRMA_DPT',
        'AUTORIZADO_FECHA_DPT',
    ];

}
