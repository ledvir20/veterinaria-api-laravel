<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialVeterinario extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'historiales_veterinarios';

    protected $fillable = [
        'mascota_id',
        'usuario_id',
        'fecha_atencion',
        'diagnostico',
        'tratamiento',
        'observaciones'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
