<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;

// Ruta principal: pantalla de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('home'); // <- ¡Corregido!

// Ruta para mostrar el formulario de registro
Route::get('/registro', [RegistroController::class, 'crear'])->name('registro.crear');

// Ruta para guardar los datos del formulario
Route::post('/registro', [RegistroController::class, 'guardar'])->name('registro.guardar');

// Ruta para mostrar el historial de registros
Route::get('/registros', [RegistroController::class, 'index'])->name('registro.index');