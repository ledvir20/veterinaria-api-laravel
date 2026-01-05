<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHistorialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fecha_atencion' => 'sometimes|date',
            'diagnostico' => 'sometimes|string',
            'tratamiento' => 'sometimes|string',
            'observaciones' => 'nullable|string',
        ];
    }
}
