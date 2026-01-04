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
        Schema::create('historiales_veterinarios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mascota_id')
                ->constrained('mascotas')
                ->onDelete('cascade');

            $table->foreignId('usuario_id')
                ->constrained('users')
                ->onDelete('restrict');

            $table->dateTime('fecha_atencion');
            $table->text('diagnostico');
            $table->text('tratamiento');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_veterinarios');
    }
};
