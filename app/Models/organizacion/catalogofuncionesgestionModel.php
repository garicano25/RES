<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogofuncionesgestionModel extends Model
{
    protected $primaryKey ='ID_CATALOGO_FUNCIONESGESTION';
    protected $table ='catalogo_funcionesgestiones';
    protected $fillable = [
        'TIPO_FUNCION_GESTION',
        'CATEGORIAS_GESTION',
        'DESCRIPCION_FUNCION_GESTION',
    ];}
