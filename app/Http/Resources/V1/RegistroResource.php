<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 
     * Este método convierte nuestro modelo (Base de Datos) a lo que ve el usuario (JSON).
     * Es útil para:
     * 1. Ocultar campos internos (como created_at si no se quieren enseñar).
     * 2. Cambiar nombres de claves si fuera necesario.
     * 3. Asegurar que la API siempre devuelva la misma estructura aunque cambie la BD.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'fecha' => $this->fecha,
            'pasos' => $this->pasos,
            'calorias' => $this->calorias,
            'estado' => $this->estado,
            // 'created_at' => $this->created_at, // Opcional
            // 'updated_at' => $this->updated_at, // Opcional
        ];
    }
}
