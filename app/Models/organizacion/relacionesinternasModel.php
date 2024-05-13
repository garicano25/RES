<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relacionesinternasModel extends Model
{
    protected $primaryKey = 'ID_RELACIONES_INTERNAS_DPT';
    protected $table = 'relaciones_internas_dpt';
    protected $fillable = [
        'FORMULARIO_DPT_ID',
        'INTERNAS_CONQUIEN_DPT',
        'INTERNAS_PARAQUE_DPT',
        'INTERNAS_FRECUENCIA_DIARIAS_DPT',
        'INTERNAS_FRECUENCIA_SEMANAL_DPT',
        'INTERNAS_FRECUENCIA_MENSUAL_DPT',
        'INTERNAS_FRECUENCIA_SEMESTRAL_DPT',
        'INTERNAS_FRECUENCIA_ANUAL_DPT',
    ];

}