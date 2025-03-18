<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altacontactos extends Model
{
    protected $table = 'formulario_altacontactoproveedor';
    protected $primaryKey = 'ID_FORMULARIO_CUENTAPROVEEDOR';
    protected $fillable = [
        'NOMBRE_CONTACTO',
        'TITULO_CONTACTO',
        'FUNCIONES_CONTACTOS',
        'ACTIVO'
    ];
}
