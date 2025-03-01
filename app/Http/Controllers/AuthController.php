<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/Módulos'); 
        }
        return view('auth.login');
    }
    
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');
    
    //     if (Auth::attempt(['EMPLEADO_CORREO' => $credentials['email'], 'password' => $credentials['password'], 'ACTIVO' => 1])) {
    //         return redirect('/Módulos'); 
    //     }
    
    //     return redirect()->back()->withErrors([
    //         'login_error' => 'Estas credenciales no coinciden con nuestros registros.',
    //     ]);
    // }



    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt(['EMPLEADO_CORREO' => $credentials['email'], 'password' => $credentials['password'], 'ACTIVO' => 1])) {
            $user = Auth::user();

            if ($user->USUARIO_TIPO == 1) { // Comparación correcta
                return redirect('/Módulos'); // Ruta corregida (sin tilde)
            } else {
                return redirect('/Alta');
            }
        }

        return redirect()->back()->withErrors([
            'login_error' => 'Estas credenciales no coinciden con nuestros registros.',
        ]);
    }



    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
