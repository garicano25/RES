<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reciboscontratoModel extends Model
{
    
    use HasFactory;
    protected $primaryKey = 'ID_RECIBOS_NOMINA';
    protected $table = 'recibos_contrato';
    protected $fillable = [
        'CONTRATO_ID',
        'CURP',
        'NOMBRE_RECIBO',
        'FECHA_RECIBO',
        'DOCUMENTO_RECIBO',
        'ACTIVO'
    ];


}