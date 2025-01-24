<?php

namespace App\Models\confirmacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class confirmacionModel extends Model
{
     use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_CONFRIMACION';
    protected $table = 'formulario_confirmacion';
    protected $fillable = [
        'NO_OFERTA',
        'NO_CONFIRMACION',
        'ACEPTACION_CONFIRMACION'

    ];
}

