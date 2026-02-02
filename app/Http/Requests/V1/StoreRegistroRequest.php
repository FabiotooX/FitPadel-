<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistroRequest extends FormRequest
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
        // Reglas de validación
        // required: campo obligatorio
        // string/integer/date: asegura el tipo de dato
        // max/min: límites de longitud o valor
        // in: solo permite valores específicos (lista cerrada)
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'fecha' => ['required', 'date'],
            'pasos' => ['required', 'integer', 'min:0'],
            'calorias' => ['required', 'integer', 'min:0'],
            'estado' => ['required', 'string', 'in:activo,inactivo,pendiente'], 
        ];
    }
}
