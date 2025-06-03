<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esta tabla es para las jusfiticaciones de una falta del alumno.
     */
    public function up(): void
    {
        Schema::create('reason', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asistencia_id')->constrained('attendance'); // el id de
            $table->text('motivo'); // Un texto de la justificacion del alumno
            $table->boolean('estado'); // verdadero= justificado / falso= sin justificar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reason');
    }
};
