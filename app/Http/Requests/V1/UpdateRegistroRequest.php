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
        return [
            'nombre' => ['sometimes', 'required', 'string', 'max:50'],
            'fecha' => ['sometimes', 'required', 'date'],
            'pasos' => ['sometimes', 'required', 'integer', 'min:0'],
            'calorias' => ['sometimes', 'required', 'integer', 'min:0'],
            'estado' => ['sometimes', 'required', 'string', 'in:Bien,Normal,Mal'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser un texto.',
            'integer' => 'El campo :attribute debe ser un numero entero.',
            'date' => 'El campo :attribute debe ser una fecha valida.',
            'max' => 'El campo :attribute no puede tener mas de :max caracteres.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'in' => 'El campo :attribute debe ser uno de estos valores: Bien, Normal o Mal.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre' => 'nombre',
            'fecha' => 'fecha',
            'pasos' => 'pasos',
            'calorias' => 'calorias',
            'estado' => 'estado',
        ];
    }
}
