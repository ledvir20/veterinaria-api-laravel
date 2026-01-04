<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
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

    public function dueno()
    {
        return $this->belongsTo(Dueno::class);
    }

    public function historiales()
    {
        return $this->hasMany(HistorialVeterinario::class);
    }
}
