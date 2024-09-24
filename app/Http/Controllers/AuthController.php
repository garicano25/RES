<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Redirigir al tablero si ya está autenticado
        if (Auth::check()) {
            return redirect('/tablero'); // Redirige a la URL directa del tablero
        }
        return view('auth.login');
    }
    
    // Procesar el login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt(['EMPLEADO_CORREO' => $credentials['email'], 'password' => $credentials['password'], 'ACTIVO' => 1])) {
            return redirect('/tablero'); // Redirige a la URL directa del tablero
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
