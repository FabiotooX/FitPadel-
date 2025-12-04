<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Mostrar un listado de todos los usuarios con paginación.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Mostrar el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Guardar un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', __('User created successfully.'));
    }

    /**
     * Mostrar los detalles de un usuario específico.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Mostrar el formulario para editar un usuario específico.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualizar los datos de un usuario en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Si la contraseña no viene vacía, se cifra; si no, se mantiene la antigua
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', __('User updated successfully.'));
    }

    /**
     * Eliminar un usuario de la base de datos (previniendo auto-eliminación).
     */
    public function destroy(User $user)
    {
        // Prevenir que un usuario se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                            ->with('error', __('You cannot delete your own user account.'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', __('User deleted successfully.'));
    }
}
