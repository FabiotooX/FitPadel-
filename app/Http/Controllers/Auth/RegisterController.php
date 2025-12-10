<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     * - Devuelve la vista `auth.register` con los campos para crear una cuenta.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Registra un nuevo usuario.
     * - Valida los datos del formulario (`name`, `email`, `password`).
     * - Crea el usuario en la tabla `users` guardando la contraseña hasheada.
     * - Logea automáticamente al usuario nuevo con `Auth::login`.
     * - Redirige a la página principal (`home`).
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // redirige al principal
        return redirect()->route('home');
    }
}