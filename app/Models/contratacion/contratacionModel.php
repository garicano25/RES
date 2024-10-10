<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contratacionModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_CONTRATACION';
    protected $table = 'formulario_contratacion';
    protected $fillable = [
        'CURP',
        'NOMBRE_COLABORADOR',
        'PRIMER_APELLIDO',
        'SEGUNDO_APELLIDO',
        'INICIALES_COLABORADOR',
        'DIA_COLABORADOR',
        'MES_COLABORADOR',
        'ANIO_COLABORADOR',
        'EDAD_COLABORADOR',
        'FOTO_USUARIO',
        'LUGAR_NACIMIENTO',
        'TELEFONO_COLABORADOR',
        'CORREO_COLABORADOR',
        'ESTADO_CIVIL',
        'RFC_COLABORADOR',
        'VIGENCIA_INE',
        'NSS_COLABORADOR',
        'TIPO_SANGRE',
        'ALERGIAS_COLABORADOR',
        'CALLE_COLABORADOR',
        'COLONIA_COLABORADOR',
        'CODIGO_POSTAL',
        'CIUDAD_COLABORADOR',
        'ESTADO_COLABORADOR',
        'NOMBRE_EMERGENCIA',
        'PARENTESCO_EMERGENCIA',
        'TELEFONO1_EMERGENCIA',
        'TELEFONO2_EMERGENCIA',
        'NOMBRE_BENEFICIARIO',
        'PARENTESCO_BENEFICIARIO',
        'PORCENTAJE_BENEFICIARIO',
        'TELEFONO1_BENEFICIARIO',
        'TELEFONO2_BENEFICIARIO',
        'ACTIVO',

      
    ];
}
