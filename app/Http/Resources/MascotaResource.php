<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DuenoResource;
use App\Http\Resources\HistorialVeterinarioResource;

class MascotaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dni_mascota' => $this->dni_mascota,
            'nombre' => $this->nombre,
            'especie' => $this->especie,
            'raza' => $this->raza,
            'sexo' => $this->sexo,
            'fecha_nacimiento' => $this->when($this->fecha_nacimiento, function () {
                return $this->fecha_nacimiento->toDateString();
            }),
            'color' => $this->color,
            'dueno' => new DuenoResource($this->whenLoaded('dueno')),
            'historiales' => HistorialVeterinarioResource::collection($this->whenLoaded('historiales') ?? collect()),
            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
