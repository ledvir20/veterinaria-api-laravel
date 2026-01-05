<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistorialVeterinario;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HistorialVeterinarioController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['index', 'show']),
            // Solo quien tenga permiso puede crear
            new Middleware('permission:crear historiales', only: ['store']),
            // Solo quien tenga permiso puede eliminar
            new Middleware('permission:eliminar historiales', only: ['destroy']),
        ];
    }

    public function index()
    {
        return response()->json(
            HistorialVeterinario::with(['mascota', 'usuario'])->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'fecha_atencion' => 'required|date',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        $data['usuario_id'] = auth('api')->id();

        $historial = HistorialVeterinario::create($data);

        return response()->json($historial, 201);
    }

    public function show(HistorialVeterinario $historiale)
    {
        // cargar relaciones sobre la instancia ya vinculada
        $historiale->load(['mascota', 'usuario']);

        return response()->json($historiale);
    }

    public function update(Request $request, HistorialVeterinario $historiale)
    {
        $data = $request->validate([
            'fecha_atencion' => 'sometimes|date',
            'diagnostico' => 'sometimes|string',
            'tratamiento' => 'sometimes|string',
            'observaciones' => 'nullable|string',
        ]);

        $historiale->update($data);

        return response()->json($historiale);
    }

    public function destroy(HistorialVeterinario $historiale)
    {
        $historiale->delete();

        return response()->json([
            'message' => 'Historial veterinario eliminado correctamente'
        ]);
    }
}
