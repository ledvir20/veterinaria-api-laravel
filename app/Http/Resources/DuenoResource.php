<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DuenoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'dni' => $this->dni,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'mascotas' => $this->whenLoaded('mascotas', function () {
                return $this->mascotas->map(function ($m) {
                    return [
                        'id' => $m->id,
                        'dni_mascota' => $m->dni_mascota,
                        'nombre' => $m->nombre,
                        'especie' => $m->especie,
                    ];
                });
            }),
        ];
    }
}
