<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracion de las clases
     */
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('profe_id')->constrained('users'); // Esto es el ID del profesor asignado a la clase.
            $table->enum('tipo', ['arabe','religion']); // Tipo de clase, arabe o religion
            $table->string('nivel'); // Nivel de la clase
            $table->integer('numero_alumnos')->default(0); // Cuantos alumnos hay en la clase.
            $table->string('imagen_horario'); // El horario, será una imagen. Se asignara el directorio.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
