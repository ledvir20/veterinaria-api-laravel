<?php

use App\Models\Mascota;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'API is running']);
});


Route::get('/mascotas/{id}', function ($id) {
    // Buscamos la mascota con su dueño
    $mascota = Mascota::with('dueno')->findOrFail($id);

    return view('pdf.carnet', ['mascota' => $mascota]);
});
