<?php

// Importamos la clase Route para definir rutas web
use Illuminate\Support\Facades\Route;

// Importamos los controladores
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\AdminUserController;

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
Route::get('/registro', [RegistroController::class, 'crear'])
    ->name('registro.crear'); 
// 'registro.crear' es el nombre de la ruta, útil para generar enlaces desde Blade con route('registro.crear')


// RUTA PARA GUARDAR LOS DATOS DEL FORMULARIO

// Ruta POST que recibe los datos enviados desde el formulario
Route::post('/registro', [RegistroController::class, 'guardar'])
    ->name('registro.guardar');
// 'registro.guardar' se usa en el atributo action del formulario HTML
// Esta ruta se encarga de validar, guardar en la base de datos y generar CSV


// RUTA PARA MOSTRAR EL HISTORIAL DE REGISTROS

// Ruta GET que muestra la lista de registros guardados
Route::get('/historial', [RegistroController::class, 'index'])
    ->name('registro.index');
// 'registro.index' permite crear enlaces desde Blade como route('registro.index')


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
});
