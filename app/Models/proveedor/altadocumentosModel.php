<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altadocumentosModel extends Model
{
    use HasFactory;


    protected $table = 'formulario_altadocumentoproveedores';
    protected $primaryKey = 'ID_FORMULARIO_DOCUMENTOSPROVEEDOR';
    protected $fillable = [
        'RFC_PROVEEDOR',
        'TIPO_DOCUMENTO',
        'NOMBRE_DOCUMENTO',
        'DOCUMENTO_SOPORTE',
        'ACTIVO'
    ];


}
