<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    /**
     * Mostrar el formulario de creación de usuario
     */
    public function crear()
    {
        return view('admin.usuarios.crear');
    }

    /**
     * Guardar el nuevo usuario en la base de datos
     */
    public function guardar(Request $request)
    {
        // Validar los datos del formulario
        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'role' => 'nullable|string|in:user,admin,coach',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.mixed_case' => 'La contraseña debe contener mayúsculas y minúsculas',
            'password.numbers' => 'La contraseña debe contener números',
            'password.symbols' => 'La contraseña debe contener caracteres especiales',
        ]);

        // Crear el nuevo usuario
        try {
            $usuario = User::create([
                'name' => $datos['name'],
                'email' => $datos['email'],
                'password' => Hash::make($datos['password']),
                'status' => $datos['status'] ?? 1,
            ]);

            // Opcionalmente, guardar el rol (si tienes tabla de roles)
            // $usuario->assignRole($datos['role'] ?? 'user');

            return redirect()
                ->route('home')
                ->with('success', "Usuario '{$usuario->name}' creado exitosamente. ID: {$usuario->id}");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage())
                ->withInput();
        }
    }
}
