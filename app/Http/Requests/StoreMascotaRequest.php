<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMascotaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'especie' => 'required|in:Perro,Gato,Otro',
            'raza' => 'nullable|string|max:255',
            'sexo' => 'required|in:M,H',
            'fecha_nacimiento' => 'nullable|date',
            'color' => 'nullable|string|max:100',
            'dueno_id' => 'required|exists:duenos,id',
        ];
    }
}
