<?php

namespace App\Models\solicitudes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudesModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_SOLICITUDES';
    protected $table = 'formulario_solicitudes';
    protected $fillable = [
        'NO_SOLICITUD',
        'TIPO_SOLICITUD',
        'FECHA_SOLICITUD',
        'MEDIO_CONTACTO_SOLICITUD',
        'RAZON_SOCIAL_SOLICITUD',
        'NOMBRE_COMERCIAL_SOLICITUD',
        'GIRO_EMPRESA_SOLICITUD',
        'REPRESENTANTE_LEGAL_SOLICITUD',
        'DIRECCION_SOLICITUD',
        'CONTACTO_SOLICITUD',
        'CARGO_SOLICITUD',
        'TELEFONO_SOLICITUD',
        'CELULAR_SOLICITUD',
        'CORREO_SOLICITUD',
        'NECESIDAD_SERVICIO_SOLICITUD',
        'SERVICIO_SOLICITADO_SOLICITUD',
        'TIPO_CLIENTE_SOLICITUD',
        'OBSERVACIONES_SOLICITUD',
        'ESTATUS_SOLICITUD',
        'FECHA_NOTIFICACION_SOLICITUD',
        'ACTIVO',
        'DIRIGE_OFERTA',
        'CONTACTO_OFERTA',
        'CARGO_OFERTA',
        'TELEFONO_OFERTA',
        'CELULAR_OFERTA',
        'CORREO_OFERTA',
        'MOTIVO_RECHAZO',
        'RFC_SOLICITUD',
        'TIPO_SERVICIO_SOLICITUD',
        'CONTACTOS_JSON'
    ];

}
