<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Prefijo v1 para versionado de API (buena práctica estándar)
Route::prefix('v1')->group(function () {
    // apiResource genera automáticamente las 5 rutas estándar:
    // GET /registros (index), POST /registros (store), 
    // GET /registros/{id} (show), PUT/PATCH /registros/{id} (update), 
    // DELETE /registros/{id} (destroy)
    Route::apiResource('registros', \App\Http\Controllers\Api\V1\RegistroController::class);
});
