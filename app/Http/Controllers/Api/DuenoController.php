<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dueno;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DuenoController extends Controller implements HasMiddleware
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
            Dueno::with('mascotas')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|size:8|unique:duenos',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        $dueno = Dueno::create($data);

        return response()->json($dueno, 201);
    }

    public function show(Dueno $dueno)
    {
        return response()->json(
            $dueno->load('mascotas')
        );
    }

    public function update(Request $request, Dueno $dueno)
    {
        $data = $request->validate([
            'nombres' => 'sometimes|string|max:255',
            'apellidos' => 'sometimes|string|max:255',
            'dni' => 'sometimes|string|size:8|unique:duenos,dni,' . $dueno->id,
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        $dueno->update($data);

        return response()->json($dueno);
    }

    public function destroy(Dueno $dueno)
    {
        $dueno->delete();

        return response()->json([
            'message' => 'Dueño eliminado correctamente'
        ]);
    }
}
