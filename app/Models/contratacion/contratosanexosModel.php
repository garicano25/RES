<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contratosanexosModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_CONTRATOS_ANEXOS';
    protected $table = 'contratos_anexos_contratacion';
    protected $fillable = [
        'CURP',
        'TIPO_DOCUMENTO_CONTRATO',
        'NOMBRE_DOCUMENTO_CONTRATO',
        'NOMBRE_CARGO',
        'VIGENCIA_CONTRATO',
        'VIGENCIA_ACUERDO',
        'DOCUMENTO_CONTRATO',
        'ACTIVO'

        
    ];}
