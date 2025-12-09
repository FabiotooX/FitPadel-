<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * UserController - Controlador de Gestión de Usuarios
 * 
 * Este controlador implementa el patrón REST (CRUD) para gestionar usuarios.
 * Utiliza Route::resource que genera automáticamente 7 rutas estándar:
 * - GET    /admin/users             → index()   (listar todos)
 * - GET    /admin/users/create      → create()  (mostrar formulario crear)
 * - POST   /admin/users             → store()   (guardar en BD)
 * - GET    /admin/users/{user}      → show()    (ver detalles)
 * - GET    /admin/users/{user}/edit → edit()    (mostrar formulario editar)
 * - PUT    /admin/users/{user}      → update()  (actualizar en BD)
 * - DELETE /admin/users/{user}      → destroy() (eliminar de BD)
 *
 */
class UserController extends Controller
{
    /**
     * index() - Listar todos los usuarios con paginación
     * 
     * ¿Cómo funciona?
     * - User::paginate(10) obtiene los usuarios de 10 en 10
     * - Esto es importante para aplicaciones grandes
     * - compact('users') envía la variable $users a la vista
     * 
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * create() - Mostrar el formulario para crear un nuevo usuario
     * 
     * ¿Cómo funciona?
     * - Solo devuelve la vista con el formulario vacío
     * - No hace operaciones en BD, solo presentación
     * 
     * ¿Por qué separar create() de store()?
     * - Separación de responsabilidades: GET muestra, POST guarda
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * store() - Guardar un nuevo usuario en la base de datos
     * 
     * ¿Cómo funciona?
     * 1. Valida los datos con reglas estrictas
     * 2. Cifra la contraseña con Hash
     * 3. Crea el usuario en la BD
     * 4. Redirige al listado con mensaje de éxito
     * 
     * ¿Qué hace cada validación?
     * - 'name' => required|string|max:255
     *   * required: el campo no puede estar vacío
     *   * string: debe ser texto
     *   * max:255: máximo 255 caracteres (tamaño del campo en BD)
     * 
     * - 'email' => required|email|unique:users,email
     *   * required: obligatorio
     *   * email: debe tener formato de email válido (ej: usuario@ejemplo.com)
     *   * unique:users,email: no puede haber otro email igual en la tabla 'users'
     * 
     * - 'password' =>
     *   * required: obligatoria
     *   * confirmed: debe ser igual a password_confirmation (seguridad)
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario con reglas robustas
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Contraseña obligatoria y debe coincidir
        ]);
        // Cifrar la contraseña antes de crear el usuario
        $validated['password'] = Hash::make($validated['password']);

        // Crear el usuario en la base de datos
        User::create($validated);

        // Redirigir al índice con mensaje de éxito
        return redirect()->route('admin.users.index')->with('success', __('User created successfully.'));
    }

    /**
     * show() - Mostrar los detalles de un usuario específico
     * 
     * ¿Cómo funciona?
     * - Laravel binding automático: {user} en la ruta se convierte en objeto User
     * - Esto significa que si la URL es /admin/users/5, obtenemos el usuario con id=5
     * - Si el id no existe, Laravel automáticamente devuelve error 404
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * edit() - Mostrar el formulario para editar un usuario específico
     * 
     * ¿Cómo funciona?
     * - Similar a show(), pero muestra un formulario con los datos del usuario
     * - Los campos del formulario vienen precargados con old('campo') o $user->campo
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * update() - Actualizar los datos de un usuario en la base de datos
     * 
     * ¿Cómo funciona?
     * 1. Valida los datos (similar a store, pero con cambios)
     * 2. Si hay contraseña nueva, la cifra; si no, mantiene la antigua
     * 3. Actualiza el usuario en BD
     * 4. Redirige con mensaje de éxito
     */
    public function update(Request $request, User $user)
    {
        // Validar datos permitiendo email duplicado del usuario actual
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // El ',  . $user->id' permite que el usuario mantenga su email actual
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // Contraseña opcional
        ]);

        // Si se introduce una nueva contraseña, la ciframos
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Si no se cambia la contraseña, la quitamos del array para no actualizarla
            unset($validated['password']);
        }

        // Actualizamos el usuario con los datos validados
        $user->update($validated);

        // Redirigimos a la lista de usuarios con mensaje de éxito
        return redirect()->route('admin.users.index') ->with ('success', __('User updated successfully.'));
    }

    /**
     * destroy() - Eliminar un usuario de la base de datos
     * 
     * ¿Cómo funciona?
     * 1. Verifica que el usuario no intente eliminar su propia cuenta
     * 2. Si todo está bien, elimina el usuario de BD
     * 3. Redirige con mensaje de éxito
     */
    public function destroy(User $user)
    {
        // auth()->id() obtiene el ID del usuario autenticado actualmente
        // Si coincide con el usuario a eliminar, rechazamos la operación
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index') ->with ('error', __('You cannot delete your own user account'));
        }

       // Eliminamos el usuario
        $user->delete();

        // Redirigimos a la lista de usuarios con mensaje de éxito
        return redirect()->route('admin.users.index') -> with('success', __('User deleted successfully.'));
    }
}
