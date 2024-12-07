<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\usuario\usuarioModel;
use Illuminate\Support\Facades\Hash;



use DB;


class usuarioController extends Controller
{
 


    public function Tablausuarios()
{
    try {
        $tabla = usuarioModel::get();

        foreach ($tabla as $value) {
       

            $value->EMPLEADO_NOMBRES= $value->EMPLEADO_NOMBRE . ' ' . $value->EMPLEADO_APELLIDOPATERNO . ' ' . $value->EMPLEADO_APELLIDOMATERNO . '<br>' . $value->EMPLEADO_CARGO;
            $value->EMPLEADO_CORREOS= $value->EMPLEADO_CORREO . '<br>' . $value->EMPLEADO_TELEFONO;


            if ($value->USUARIO_TIPO == 1) {
                $value->USUARIO_TIPOS = 'Empleado';
            }

            if ($value->ACTIVO == 0) {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_USUARIO . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_USUARIO . '" checked><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
            }
        }

        return response()->json([
            'data' => $tabla,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}


public function mostrarFotoUsuario($usuario_id)
{
    $foto = usuarioModel::findOrFail($usuario_id);
    return Storage::response($foto->FOTO_USUARIO);
}


public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:
                if ($request->ID_USUARIO == 0) {
                    // Crear nuevo usuario
                    DB::statement('ALTER TABLE usuarios AUTO_INCREMENT=1;');

                    $datosUsuario = $request->all();
                    $datosUsuario['PASSWORD'] = Hash::make($request->PASSWORD);

                    $usuarios = usuarioModel::create($datosUsuario);
                    $usuarioId = $usuarios->ID_USUARIO;

                    if ($request->hasFile('FOTO_USUARIO')) {
                        $imagen = $request->file('FOTO_USUARIO');
                        $rutaCarpetaUsuario = 'usuarios/' . $usuarioId;
                        $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                        $rutaCompleta = $imagen->storeAs($rutaCarpetaUsuario, $nombreArchivo);
                        $usuarios->FOTO_USUARIO = $rutaCompleta;
                        $usuarios->save();
                    }
                } else {
                    if (isset($request->ELIMINAR)) {
                        if ($request->ELIMINAR == 1) {
                            // Desactivar usuario
                            usuarioModel::where('ID_USUARIO', $request['ID_USUARIO'])->update(['ACTIVO' => 0]);
                            $response['code'] = 1;
                            $response['usuario'] = 'Desactivada';
                        } else {
                            // Activar usuario
                            usuarioModel::where('ID_USUARIO', $request['ID_USUARIO'])->update(['ACTIVO' => 1]);
                            $response['code'] = 1;
                            $response['usuario'] = 'Activada';
                        }
                    } else {
                        $usuarios = usuarioModel::find($request->ID_USUARIO);

                        if ($request->filled('PASSWORD')) {
                            $request['PASSWORD'] = Hash::make($request->PASSWORD);
                        }

                        if ($request->hasFile('FOTO_USUARIO')) {
                            // Eliminar la foto anterior si existe
                            if ($usuarios->FOTO_USUARIO && Storage::exists($usuarios->FOTO_USUARIO)) {
                                Storage::delete($usuarios->FOTO_USUARIO);
                            }

                            // Obtener la nueva imagen
                            $imagen = $request->file('FOTO_USUARIO');
                            $rutaCarpetaUsuario = 'usuarios/' . $usuarios->ID_USUARIO;
                            $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                            $rutaCompleta = $imagen->storeAs($rutaCarpetaUsuario, $nombreArchivo);

                            // Actualizar la ruta de la nueva imagen en el modelo
                            $usuarios->FOTO_USUARIO = $rutaCompleta;
                        }

                        // Actualizar otros datos del usuario
                        $usuarios->update($request->except('FOTO_USUARIO'));
                        $usuarios->save();

                        $response['code'] = 1;
                        $response['usuario'] = 'Actualizada';
                    }
                    return response()->json($response);
                }

                $response['code'] = 1;
                $response['usuario'] = $usuarios;
                return response()->json($response);

            default:
                $response['code'] = 1;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json('Error al guardar la jerarquía: ' . $e->getMessage());
    }
}



// public function store(Request $request)
// {
//     try {
//         switch (intval($request->api)) {
//             case 1:
//                 if ($request->ID_USUARIO == 0) {
//                     // Crear nuevo usuario
//                     DB::statement('ALTER TABLE usuarios AUTO_INCREMENT=1;');

//                     $datosUsuario = $request->all();
//                     $datosUsuario['PASSWORD'] = Hash::make($request->PASSWORD);

//                     $usuarios = usuarioModel::create($datosUsuario);
//                     $usuarioId = $usuarios->ID_USUARIO;

//                     if ($request->hasFile('FOTO_USUARIO')) {
//                         $imagen = $request->file('FOTO_USUARIO');
//                         $rutaCarpetaUsuario = 'usuarios/' . $usuarioId;
//                         $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
//                         $rutaCompleta = $imagen->storeAs($rutaCarpetaUsuario, $nombreArchivo);
//                         $usuarios->FOTO_USUARIO = $rutaCompleta;
//                         $usuarios->save();
//                     }
//                 } else {
//                     if (isset($request->ELIMINAR)) {
//                         if ($request->ELIMINAR == 1) {
//                             $usuarios = usuarioModel::where('ID_USUARIO', $request['ID_USUARIO'])->update(['ACTIVO' => 0]);
//                             $response['code'] = 1;
//                             $response['usuario'] = 'Desactivada';
//                         } else {
//                             $usuarios = usuarioModel::where('ID_USUARIO', $request['ID_USUARIO'])->update(['ACTIVO' => 1]);
//                             $response['code'] = 1;
//                             $response['usuario'] = 'Activada';
//                         }
//                     } else {
//                         $usuarios = usuarioModel::find($request->ID_USUARIO);

//                         if ($request->filled('PASSWORD')) {
//                             $request['PASSWORD'] = Hash::make($request->PASSWORD);
//                         }

//                         if ($request->hasFile('FOTO_USUARIO')) {
//                             if ($usuarios->FOTO_USUARIO && Storage::exists($usuarios->FOTO_USUARIO)) {
//                                 Storage::delete($usuarios->FOTO_USUARIO);
//                             }
//                             // Obtener la nueva imagen
//                             $imagen = $request->file('FOTO_USUARIO');
//                             $rutaCarpetaUsuario = 'usuarios/' . $usuarios->ID_USUARIO;
//                             $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
//                             $rutaCompleta = $imagen->storeAs($rutaCarpetaUsuario, $nombreArchivo);
//                             $request->merge(['FOTO_USUARIO' => $rutaCompleta]);
//                         }

//                         // Actualizar los datos del usuario
//                         $usuarios->update($request->all());
//                         $response['code'] = 1;
//                         $response['usuario'] = 'Actualizada';
//                     }
//                     return response()->json($response);
//                 }

//                 $response['code'] = 1;
//                 $response['usuario'] = $usuarios;
//                 return response()->json($response);

//             default:
//                 $response['code'] = 1;
//                 $response['msj'] = 'Api no encontrada';
//                 return response()->json($response);
//         }
//     } catch (Exception $e) {
//         return response()->json('Error al guardar la jerarquía: ' . $e->getMessage());
//     }
// }



}
