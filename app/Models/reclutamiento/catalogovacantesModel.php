<?php

namespace App\Models\reclutamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogovacantesModel extends Model
{

    protected $primaryKey = 'ID_CATALOGO_VACANTE';
    protected $table = 'catalogo_vacantes';
    protected $fillable = [
        'CATEGORIA_VACANTE',
        'DESCRIPCION_VACANTE',
        'REQUISITOS_VACANTES',
        'ACTIVO',
    ];

}
