<?php

// Importamos la clase Route para definir rutas web
use Illuminate\Support\Facades\Route;

// Importamos los controladores
use App\Http\Controllers\RegistroController;
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

    /**
     * CRUD de Usuarios
     *
     * Usamos `Route::resource('admin/users', UserController::class, ['as' => 'admin'])`
     * que genera las siete rutas estándar (index, create, store, show,
     * edit, update, destroy). Las rutas generadas tendrán nombres como:
     * `admin.users.index`, `admin.users.create`, `admin.users.store`, etc.
     *
     * Estas rutas están dentro del grupo protegido por los middleware definidos
     * arriba (auth:sanctum, Jetstream session, verified). Por tanto el CRUD
     * sólo es accesible por usuarios autenticados y verificados.
     */
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
