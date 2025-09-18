<?php

namespace App\Models\recempleados;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recemplaedosModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_RECURSOS_EMPLEADOS';
    protected $table = 'formulario_recempleados';
    protected $fillable = [

        'USUARIO_ID',
        'TIPO_SOLICITUD',
        'SOLICITANTE_SALIDA',
        'FECHA_SALIDA',
        'MATERIAL_RETORNA_SALIDA',
        'FECHA_ESTIMADA_SALIDA',
        'MATERIALES_JSON',
        'SOLICITANTE_PERMISO',
        'FECHA_PERMISO',
        'CARGO_PERMISO',
        'NOEMPLEADO_PERMISO',
        'CONCEPTO_PERMISO',
        'NODIAS_PERMISO',
        'NOHORAS_PERMISO',
        'FECHA_INICIAL_PERMISO',
        'FECHA_FINAL_PERMISO',
        'EXPLIQUE_PERMISO',
        'OBSERVACIONES_REC',
        'ACTIVO',
        'DAR_BUENO',
        'CURP',
        'FIRMO_USUARIO',
        'FIRMADO_POR',

        
        'VISTO_BUENO',
        'FECHA_VISTO_SOLICITUD',
        'MOTIVO_RECHAZO_JEFE',
        'FIRMO_JEFE',
        'JEFE_ID',

        'FIRMO_APROBACION',
        'ESTADO_APROBACION',
        'MOTIVO_RECHAZO',
        'QUIEN_APROBACION',
        'FECHA_APRUEBA_SOLICITUD',

        'FIRMA_ALMACEN',
        'FECHA_ALMACEN_SOLICITUD',
        'FIRMO_ALMACENISTA',

        'FINALIZAR_SOLICITUD_ALMACEN',
        'GUARDO_SALIDA_INVENTARIO',
        'GUARDO_RETORNO_INVENTARIO'


    ];
}
