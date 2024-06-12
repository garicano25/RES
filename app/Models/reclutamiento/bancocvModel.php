<?php

namespace App\Models\reclutamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bancocvModel extends Model
{
    protected $primaryKey = 'ID_BANCO_CV';
    protected $table = 'formulario_bancocv';
    protected $fillable = [
        'AVISO_PRIVACIDAD',
        'NOMBRE_CV',
        'PRIMER_APELLIDO_CV',
        'SEGUNDO_APELLIDO_CV',
        'CORREO_CV',
        'NUMERO1_CV',
        'TIPO_TELEFONO1',
        'TELEFONO_CELULAR2_CV',
        'CURP_CV',
        'DIA_FECHA_CV',
        'MES_FECHA_CV',
        'ANO_FECHA_CV',
        'ULTIMO_GRADO_CV',
        'NOMBRE_LICENCIATURA_CV',
        'TIPO_POSGRADO_CV',
        'NOMBRE_POSGRADO_CV',
        'ARCHIVO_CURP_CV',
        'ARCHIVO_CV',
        'CUENTA_TITULO_CV',
        'OBSERVACIO_CV',

    ];
}
