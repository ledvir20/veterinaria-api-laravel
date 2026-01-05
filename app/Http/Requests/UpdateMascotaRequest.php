<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMascotaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'sometimes|string|max:255',
            'especie' => 'sometimes|in:Perro,Gato,Otro',
            'raza' => 'nullable|string|max:255',
            'sexo' => 'sometimes|in:M,H',
            'fecha_nacimiento' => 'nullable|date',
            'color' => 'nullable|string|max:100',
            'dueno_id' => 'sometimes|exists:duenos,id',
        ];
    }
}
