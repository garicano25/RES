<?php

namespace App\Models\requisicionmaterial;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mrModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_MR';
    protected $table = 'formulario_requisiconmaterial';
    protected $fillable = [
        'SOLICITANTE_MR',
        'FECHA_SOLICITUD_MR',
        'AREA_SOLICITANTE_MR',
        'NO_MR',
        'MATERIALES_JSON',
        'JUSTIFICACION_MR',
        'ACTIVO',

    ];
}
