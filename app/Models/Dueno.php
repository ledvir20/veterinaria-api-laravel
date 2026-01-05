<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dueno extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
        'direccion'
    ];

    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }
}
