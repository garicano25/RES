<?php

namespace App\Models\ordencompra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_PO';
    protected $table = 'formulario_ordencompra';
    protected $fillable = [
        'NO_PO',
        'NO_MR',
        'HOJA_ID', 
        'ACTIVO',
        'MATERIALES_JSON',
        'PROVEEDOR_SELECCIONADO',
        'SUBTOTAL',
        'IVA',
        'IMPORTE'


    ];
}
