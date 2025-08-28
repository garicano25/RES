<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventarioModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_INVENTARIO';
    protected $table = 'formulario_inventario';
    protected $fillable = [


        'FOTO_EQUIPO',
        'DESCRIPCION_EQUIPO',
        'MARCA_EQUIPO',
        'MODELO_EQUIPO',
        'SERIE_EQUIPO',
        'CODIGO_EQUIPO',
        'CANTIDAD_EQUIPO',
        'UBICACION_EQUIPO',
        'ESTADO_EQUIPO',
        'FECHA_ADQUISICION',
        'PROVEEDOR_EQUIPO',
        'UNITARIO_EQUIPO',
        'TOTAL_EQUIPO',
        'TIPO_EQUIPO',
        'ACTIVO',
        'OBSERVACION_EQUIPO'



    ];
}
