<?php

namespace App\Models\usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class usuarioModel extends Authenticatable
{
    use Notifiable;

    // Nombre de la tabla y clave primaria
    protected $table = 'usuarios';
    protected $primaryKey = 'ID_USUARIO';

    // Campos que se pueden rellenar en la base de datos
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

    // Campos ocultos para arrays
    protected $hidden = [
        'PASSWORD', 'PASSWORD_2', 'remember_token',
    ];

    // Campo de la contraseña para la autenticación
    protected $rememberTokenName = 'remember_token';

    // Sobrescribir el método getAuthPassword para usar el campo PASSWORD
    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }
}