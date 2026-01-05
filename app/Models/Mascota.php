<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'dni_mascota',
        'nombre',
        'especie',
        'raza',
        'sexo',
        'fecha_nacimiento',
        'color',
        'dueno_id'
    ];

    /**
     * Boot del modelo para autogenerar el DNI
     */
    protected static function booted()
    {
        static::creating(function ($mascota) {
            // 1. Definir el prefijo: MPH + Año (ej: MPH-2026-)
            $year = date('Y');
            $prefix = "MPH-{$year}-";

            // 2. Buscar el último registro que coincida con este prefijo para obtener la secuencia
            // Usamos lockForUpdate() para evitar duplicados si dos personas registran al mismo tiempo
            $lastMascota = self::where('dni_mascota', 'like', "{$prefix}%")
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            // 3. Calcular el siguiente número
            if ($lastMascota) {
                // Extraemos los últimos 5 dígitos (ej: 00005) y sumamos 1
                $sequence = intval(substr($lastMascota->dni_mascota, -5)) + 1;
            } else {
                // Si es el primero del año
                $sequence = 1;
            }

            // 4. Formatear con ceros a la izquierda (ej: 00001) y asignar
            $mascota->dni_mascota = $prefix . str_pad($sequence, 5, '0', STR_PAD_LEFT);
        });
    }

    public function dueno()
    {
        return $this->belongsTo(Dueno::class);
    }

    public function historiales()
    {
        return $this->hasMany(HistorialVeterinario::class);
    }
}
