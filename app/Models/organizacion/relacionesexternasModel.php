<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relacionesexternasModel extends Model
{
   
    protected $primaryKey = 'ID_RELACIONES_EXTERNAS_DPT';
    protected $table = 'relaciones_externas_dpt';
    protected $fillable = [
        'FORMULARIO_DPT_ID',
        'EXTERNAS_CONQUIEN_DPT',
        'EXTERNAS_PARAQUE_DPT',
        'EXTERNAS_FRECUENCIA_DIARIAS_DPT',
        'EXTERNAS_FRECUENCIA_SEMANAL_DPT',
        'EXTERNAS_FRECUENCIA_MENSUAL_DPT',
        'EXTERNAS_FRECUENCIA_SEMESTRAL_DPT',
        'EXTERNAS_FRECUENCIA_ANUAL_DPT',
    ];

}
