<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->string('dni_mascota')->unique();
            $table->string('nombre');
            $table->enum('especie', ['Perro', 'Gato', 'Otro']);
            $table->string('raza')->nullable();
            $table->enum('sexo', ['M', 'H']);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('color')->nullable();

            $table->foreignId('dueno_id')
                ->constrained('duenos')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
