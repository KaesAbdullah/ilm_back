<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esta tabla es para las asistencias del alumno.
     */
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('clase_id')->constrained('classes');
            $table->foreignId('alumno_id')->constrained('users'); // Se necesitan el id de la clase y del alumno para ello.
            $table->boolean('estado'); // Estado de la asistencia: verdadero= si que estuvo / falso= no estuvo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
