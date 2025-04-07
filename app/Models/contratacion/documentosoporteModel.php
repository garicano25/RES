<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentosoporteModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_DOCUMENTO_SOPORTE';
    protected $table = 'documentos_soporte_contratacion';
    protected $fillable = [
        'CURP',
        'TIPO_DOCUMENTO',
        'NOMBRE_DOCUMENTO',
        'DOCUMENTO_SOPORTE',
        'FECHAI_DOCUMENTOSOPORTE',
        'FECHAF_DOCUMENTOSOPORTE',
        'ACTIVO'
    ];
}
