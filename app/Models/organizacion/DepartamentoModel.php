<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartamentoModel extends Model
{
    protected $fillable = [
        'DEPARTAMENTO_AREA_ID',
        'NOMBRE',
        'DESCRIPCION',
        'USUARIO_ID',
        'AREA_ID',
        'ACTIVO',
    ];

}
