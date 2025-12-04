<?php

// Importamos la clase Route para definir rutas web
use Illuminate\Support\Facades\Route;

// Importamos los controladores
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*

| Rutas Web

| Aquí definimos todas las rutas accesibles desde el navegador.
| Cada ruta puede apuntar a:
|   - Una función anónima (closure)
|   - Un método de un controlador
| Las rutas pueden tener nombre, middleware y tipos (GET, POST, etc.)
*/


// RUTA PRINCIPAL (HOME)

// Ruta GET para la página principal de la aplicación
Route::get('/', function () {
    // Retorna la vista 'home.blade.php' ubicada en resources/views
    return view('home');
})->name('home'); // 'home' es el nombre de la ruta para poder usar route('home') en enlaces


// RUTA PARA MOSTRAR EL FORMULARIO DE REGISTRO
// Ruta GET que muestra el formulario de registro físico
// Ruta GET que muestra la lista de registros guardados
// Ruta POST que recibe los datos enviados desde el formulario

// NOTAS IMPORTANTES

/*
 * - Cada ruta tiene un nombre (->name('...')) que facilita generar URLs y redirecciones.
 *   Ejemplo: route('registro.guardar') devuelve automáticamente la URL '/registro' para POST.
 * - Las rutas GET muestran vistas o datos, y las POST envían datos al servidor.
 * - Si deseas proteger rutas para usuarios autenticados, se puede usar middleware:
 *   Ejemplo: ->middleware('auth') para que solo usuarios logueados puedan acceder.
 */

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Rutas protegidas de registro (requieren autenticación)
    Route::get('/registro', [RegistroController::class, 'crear'])
        ->name('registro.crear');
    Route::post('/registro', [RegistroController::class, 'guardar'])
        ->name('registro.guardar');
    Route::get('/historial', [RegistroController::class, 'index'])
        ->name('registro.index');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Ruta de prueba para AdminLTE
    Route::get('/admin/prueba', function () {
        return view('admin.prueba');
    })->name('admin.prueba');

    // Rutas para gestión de usuarios
    Route::get('/admin/usuarios/crear', [AdminUserController::class, 'crear'])
        ->name('admin.usuarios.crear');
    Route::post('/admin/usuarios', [AdminUserController::class, 'guardar'])
        ->name('admin.usuarios.guardar');

    // Rutas CRUD para usuarios (protegidas con autenticación)
    // Comentadas en espera de usar Route::resource
    /*
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    */

    // Ruta resource para usuarios
    Route::resource('admin/users', UserController::class, ['as' => 'admin']);
});

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});
