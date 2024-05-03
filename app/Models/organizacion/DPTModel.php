<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPTModel extends Model
{
    protected $table = 'DPT';
    protected $primaryKey = 'ID_DPT';
    protected $fillable = ['ID_DPT', 'NOMBRE_PUESTO', 'ARCHIVO_DPT'];
}
