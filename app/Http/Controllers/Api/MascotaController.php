<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

class MascotaController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['index', 'show']),
        ];
    }

    public function index()
    {
        return response()->json(
            Mascota::with('dueno')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|in:Perro,Gato,Otro',
            'raza' => 'nullable|string',
            'sexo' => 'required|in:M,H',
            'fecha_nacimiento' => 'nullable|date',
            'color' => 'nullable|string',
            'dueno_id' => 'required|exists:duenos,id',
        ]);

        // Ya no es necesario generar el dni_mascota aquí
        // $data['dni_mascota'] = 'PET-' . strtoupper(Str::random(8));

        // El modelo Mascota se encargará de generar el dni_mascota automáticamente
        $mascota = Mascota::create($data);

        return response()->json($mascota, 201);
    }

    public function show(Mascota $mascota)
    {
        return response()->json(
            $mascota->load(['dueno', 'historiales'])
        );
    }

    public function update(Request $request, Mascota $mascota)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'especie' => 'sometimes|in:Perro,Gato,Otro',
            'raza' => 'nullable|string',
            'sexo' => 'sometimes|in:M,H',
            'fecha_nacimiento' => 'nullable|date',
            'color' => 'nullable|string',
        ]);

        $mascota->update($data);

        return response()->json($mascota);
    }

    public function destroy(Mascota $mascota)
    {
        $mascota->delete();

        return response()->json([
            'message' => 'Mascota eliminada correctamente'
        ]);
    }
}
