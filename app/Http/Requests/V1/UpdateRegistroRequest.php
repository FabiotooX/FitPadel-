<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // En una actualización, usamos 'sometimes' para permitir 
        // enviar solo los campos que queremos cambiar (PATCH/PUT parcial).
        // Si el campo existe en la petición, se aplican las reglas (required, string, sin...).
        return [
            'nombre' => ['sometimes', 'required', 'string', 'max:255'],
            'fecha' => ['sometimes', 'required', 'date'],
            'pasos' => ['sometimes', 'required', 'integer', 'min:0'],
            'calorias' => ['sometimes', 'required', 'integer', 'min:0'],
            'estado' => ['sometimes', 'required', 'string', 'in:activo,inactivo,pendiente'],
        ];
    }
}
