<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Si la validación falla, devolver un error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Intentar autenticar al usuario
        if (Auth::attempt($request->only('email', 'password'))) {
            // La autenticación fue exitosa, devolver el usuario autenticado
            $user = Auth::user();
            return response()->json(['user' => $user]);
        } else {
            // La autenticación falló, devolver un mensaje de error
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        // Cerrar sesión del usuario autenticado
        Auth::logout();

        // Devolver una respuesta de éxito
        return response()->json(['message' => 'Logged out successfully']);
    }
}
