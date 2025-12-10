<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     * - Devuelve la vista `auth.login` que contiene el formulario.
     * - No realiza lógica adicional; solo presenta la página al usuario.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión.
     * - Valida los datos enviados (email y password).
     * - Intenta autenticar al usuario con `Auth::attempt`.
     * - Si tiene éxito: regeneramos la sesión para seguridad y redirigimos a `home`.
     * - Si falla: regresamos al formulario con un mensaje de error y conservamos el email.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // redirige al principal
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario.
     * - Llama a `Auth::logout()` para desconectar al usuario.
     * - Invalida la sesión y regenera el token CSRF por seguridad.
     * - Redirige a la página principal (`home`).
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}