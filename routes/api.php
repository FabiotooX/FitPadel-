<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\RegistroController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Prefijo v1 para versionado de API (buena práctica estándar)
Route::prefix('v1')->group(function () {
    // Login público: entrega un token válido cuando email/password son correctos.
    Route::post('login', [AuthController::class, 'login']);

    // Desde aquí todo queda protegido por Bearer Token de Sanctum.
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        // apiResource genera automáticamente las 5 rutas estándar:
        // GET /registros (index), POST /registros (store),
        // GET /registros/{id} (show), PUT/PATCH /registros/{id} (update),
        // DELETE /registros/{id} (destroy)
        Route::apiResource('registros', RegistroController::class);
    });
});
