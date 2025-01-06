<?php

namespace App\Models\usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\usuario\rolesModel;


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


     // Relación con los roles
     public function roles()
     {
         return $this->hasMany(rolesModel::class, 'USUARIO_ID', 'ID_USUARIO');
     }
 
     // Método para verificar si el usuario tiene un rol específico
     public function hasRole($role)
     {
         return $this->roles()->where('NOMBRE_ROL', $role)->exists();
     }
 
     // Método para verificar si el usuario tiene alguno de los roles especificados
     public function hasAnyRole(array $roles)
     {
         return $this->roles()->whereIn('NOMBRE_ROL', $roles)->exists();
     }
 
     // Método para verificar si el usuario tiene todos los roles especificados
     public function hasAllRoles(array $roles)
     {
         $roleCount = $this->roles()->whereIn('NOMBRE_ROL', $roles)->count();
         return $roleCount === count($roles);
     }


     public function hasRoles(array $roles)
{
    return $this->hasAnyRole($roles);
}



}