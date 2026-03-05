<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Registro;
use App\Http\Requests\V1\StoreRegistroRequest;
use App\Http\Requests\V1\UpdateRegistroRequest;
use App\Http\Resources\V1\RegistroResource;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra todos los registros.
     * Usamos RegistroResource::collection para transformar la lista completa
     * y devolver un JSON limpio.
     */
    public function index()
    {
        return RegistroResource::collection(Registro::all());
    }

    /**
     * Store a newly created resource in storage.
     * Crea un nuevo registro en la base de datos.
     * Recibe StoreRegistroRequest ya validado automáticamente.
     */
    public function store(StoreRegistroRequest $request)
    {
        $registro = Registro::create($request->validated());

        return (new RegistroResource($registro))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     * Muestra un registro individual.
     * Laravel busca automáticamente el ID gracias al "Route Model Binding" (Registro $registro).
     */
    public function show(Registro $registro)
    {
        return new RegistroResource($registro);
    }

    /**
     * Update the specified resource in storage.
     * Actualiza un registro existente.
     * Recibe UpdateRegistroRequest con las reglas de validación (algunas pueden ser opcionales).
     */
    public function update(UpdateRegistroRequest $request, Registro $registro)
    {
        $registro->update($request->validated());
        return new RegistroResource($registro);
    }

    /**
     * Remove the specified resource from storage.
     * Elimina el registro y devuelve un codigo 204 (Sin contenido),
     * que es el estándar para borrados exitosos.
     */
    public function destroy(Registro $registro)
    {
        $registro->delete();
        return response()->noContent();
    }
}
