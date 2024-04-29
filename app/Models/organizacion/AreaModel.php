<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    protected $fillable = [
        'ID_AREA',
        'NOMBRE',
        'DESCRIPCION',
        'TIPO_AREA_ID',
        'USUARIO_ID',
        'ACTIVO',
    ];
}
