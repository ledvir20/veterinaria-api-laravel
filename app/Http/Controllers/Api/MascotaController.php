<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMascotaRequest;
use App\Http\Requests\UpdateMascotaRequest;
use App\Http\Resources\MascotaResource;
use App\Models\Mascota;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MascotaController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['index', 'show']),
        ];
    }

    public function index(Request $request)
    {
        $request->validate([
            'especie' => 'sometimes|string|in:Perro,Gato,Ave,Reptil,Otro',
            'raza' => 'sometimes|string|max:100',
            'dueno_id' => 'sometimes|integer|exists:duenos,id',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ]);

        $query = Mascota::query();


        if ($paginated = request()->query('per_page')) {
            return MascotaResource::collection(
                $query->with(['dueno'])->paginate($paginated)
            );
        }
        return MascotaResource::collection(
            $query->with(['dueno'])->get()
        );
    }

    public function store(StoreMascotaRequest $request)
    {
        /** @var \App\Models\Mascota $mascota */
        $mascota = Mascota::create($request->validated());

        return (new MascotaResource($mascota->load(['dueno'])))->response()->setStatusCode(201);
    }

    public function show(Mascota $mascota)
    {
        return new MascotaResource($mascota->load(['dueno', 'historiales']));
    }

    public function update(UpdateMascotaRequest $request, Mascota $mascota)
    {
        $mascota->update($request->validated());

        return new MascotaResource($mascota->fresh()->load(['dueno']));
    }

    public function destroy(Mascota $mascota)
    {
        $mascota->delete();

        return response()->json([
            'message' => 'Mascota eliminada correctamente'
        ]);
    }

    public function descargarCarnet($id)
    {
        // Buscamos la mascota con su dueño
        $mascota = Mascota::with('dueno')->findOrFail($id);

        // Cargamos la vista y pasamos los datos
        $pdf = Pdf::loadView('pdf.carnet', compact('mascota'))
            ->setOption('isHtml5ParserEnabled', true);

        // Configurar tamaño de papel: Personalizado o A4 (aquí usaremos A4 para imprimir fácil)
        $pdf->setPaper('a4', 'portrait');

        // Opción A: Descargar directamente
        return $pdf->download('carnet-' . $mascota->dni_mascota . '.pdf');

        // Opción B: Ver en el navegador (útil para pruebas)
        // return $pdf->stream();
    }
}
