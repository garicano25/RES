<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departamentosAreasModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_DEPARTAMENTO_AREA';
    protected $table = 'departamentos_areas';
    protected $fillable = [
        'NOMBRE',
        'TIPO_AREA_ID',
        'AREA_ID',
        'ACTIVO'
    ];

}
