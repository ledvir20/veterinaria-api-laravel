<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistorialVeterinarioResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'mascota_id' => $this->mascota_id,
            'usuario_id' => $this->usuario_id,
            'fecha_atencion' => optional($this->fecha_atencion)->toDateString(),
            'diagnostico' => $this->diagnostico,
            'tratamiento' => $this->tratamiento,
            'observaciones' => $this->observaciones,
            'mascota' => $this->whenLoaded('mascota', function () {
                return [
                    'id' => $this->mascota->id,
                    'nombre' => $this->mascota->nombre,
                    'dni_mascota' => $this->mascota->dni_mascota,
                ];
            }),
            'usuario' => $this->whenLoaded('usuario', function () {
                return [
                    'id' => $this->usuario->id,
                    'name' => $this->usuario->name ?? null,
                    'email' => $this->usuario->email ?? null,
                ];
            }),
            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
