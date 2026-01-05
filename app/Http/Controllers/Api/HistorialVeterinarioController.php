<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HistorialVeterinarioResource;
use App\Http\Requests\StoreHistorialRequest;
use App\Http\Requests\UpdateHistorialRequest;
use App\Models\HistorialVeterinario;
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
        return HistorialVeterinarioResource::collection(
            HistorialVeterinario::with(['mascota', 'usuario'])->get()
        );
    }

    public function store(StoreHistorialRequest $request)
    {
        $data = $request->validated();

        $data['usuario_id'] = auth('api')->id();

        $historial = HistorialVeterinario::create($data);

        return (new HistorialVeterinarioResource($historial->load(['mascota', 'usuario'])))->response()->setStatusCode(201);
    }

    public function show(HistorialVeterinario $historiale)
    {
        // cargar relaciones sobre la instancia ya vinculada
        $historiale->load(['mascota', 'usuario']);

        return new HistorialVeterinarioResource($historiale);
    }

    public function update(UpdateHistorialRequest $request, HistorialVeterinario $historiale)
    {
        $historiale->update($request->validated());

        return new HistorialVeterinarioResource($historiale->fresh()->load(['mascota', 'usuario']));
    }

    public function destroy(HistorialVeterinario $historiale)
    {
        $historiale->delete();
        return response()->json([
            'message' => 'Historial veterinario eliminado correctamente'
        ]);
    }
}
