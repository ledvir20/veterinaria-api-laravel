<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDuenoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $duenoId = $this->route('dueno')?->id ?? null;

        return [
            'nombres' => 'sometimes|string|max:255',
            'apellidos' => 'sometimes|string|max:255',
            'dni' => 'sometimes|string|size:8|unique:duenos,dni,' . $duenoId,
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
        ];
    }
}
