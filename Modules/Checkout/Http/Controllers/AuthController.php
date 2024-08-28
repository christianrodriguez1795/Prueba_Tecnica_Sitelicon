<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Modules\Checkout\Entities\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    /**
     * Crea un nuevo usuario y lo autentica.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos de entrada
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Crear el usuario
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Autenticar al usuario
            Auth::login($user);

            // Crear un token para el usuario
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            // Retornar una respuesta JSON con el usuario autenticado y el token
            return response()->json([
                'mensaje' => 'Usuario creado y autenticado exitosamente!',
                'usuario' => $user,
                'token' => $token,
            ], 201);
        } catch (ValidationException $e) {
            // Manejar errores de validación
            return response()->json([
                'mensaje' => 'La validación falló.',
                'errores' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            // Manejar errores de base de datos (por ejemplo, error de duplicado)
            return response()->json([
                'mensaje' => 'Error en la base de datos.',
                'error' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            // Manejar errores generales
            return response()->json([
                'mensaje' => 'Ocurrió un error inesperado.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
