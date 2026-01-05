<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDuenoRequest;
use App\Http\Requests\UpdateDuenoRequest;
use App\Http\Resources\DuenoResource;
use App\Models\Dueno;
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
        return DuenoResource::collection(
            Dueno::with('mascotas')->get()
        );
    }

    public function store(StoreDuenoRequest $request)
    {
        $dueno = Dueno::create($request->validated());

        return (new DuenoResource($dueno->load('mascotas')))->response()->setStatusCode(201);
    }

    public function show(Dueno $dueno)
    {
        return new DuenoResource($dueno->load('mascotas'));
    }

    public function update(UpdateDuenoRequest $request, Dueno $dueno)
    {
        $dueno->update($request->validated());

        return new DuenoResource($dueno->fresh()->load('mascotas'));
    }

    public function destroy(Dueno $dueno)
    {
        $dueno->delete();

        return response()->json([
            'message' => 'Dueño eliminado correctamente'
        ]);
    }
}
