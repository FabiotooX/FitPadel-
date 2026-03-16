<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Endpoint de login para API con tokens personales de Sanctum.
     *
     * Como la API será usada por clientes externos (Postman u otra app),
     * no usamos sesión/cookies aquí, sino un Bearer Token.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        // Si las credenciales no son correctas devolvemos 401 (no autorizado).
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        // Se crea un token de acceso para que el cliente lo envíe en Authorization: Bearer <token>
        $plainTextToken = $user->createToken('api-v1-token')->plainTextToken;

        return response()->json([
            'message' => 'Login correcto.',
            'token_type' => 'Bearer',
            'access_token' => $plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Cierra la sesión API eliminando el token que se está usando actualmente.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logout correcto.',
        ]);
    }
}
