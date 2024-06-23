<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        // Validar las credenciales
        $credentials = $request->only('email', 'password');

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Verificar el tipo de usuario
            if ($user->type == 1) {
                return response()->json(['role' => 'admin'], 200);
            } else {
                return response()->json(['role' => 'user'], 200);
            }
        }

        // Si las credenciales son incorrectas, devolver un error
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }
}
