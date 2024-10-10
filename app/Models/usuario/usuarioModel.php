<?php

namespace App\Models\usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class usuarioModel extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'ID_USUARIO';

    protected $fillable = [
        'USUARIO_TIPO',
        'EMPLEADO_NOMBRE',
        'EMPLEADO_APELLIDOPATERNO',
        'EMPLEADO_APELLIDOMATERNO',
        'FOTO_USUARIO',
        'EMPLEADO_DIRECCION',
        'EMPLEADO_CARGO',
        'EMPLEADO_TELEFONO',
        'EMPLEADO_FECHANACIMIENTO',
        'EMPLEADO_CORREO',
        'PASSWORD',
        'PASSWORD_2',
        'ACTIVO'
    ];

    protected $hidden = [
        'PASSWORD', 'PASSWORD_2', 'remember_token',
    ];

    protected $rememberTokenName = 'remember_token';

    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }
}