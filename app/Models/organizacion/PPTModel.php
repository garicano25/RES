<?php


namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPTModel extends Model
{

    protected $table = 'PPT';
    protected $primaryKey = 'ID_PPT';
    protected $fillable = ['ID_PPT', 'NOMBRE_PUESTO', 'ARCHIVO_PPT'];
}
