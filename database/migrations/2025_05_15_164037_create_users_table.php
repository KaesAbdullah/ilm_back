<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracion que creara la tabla de usuarios, con sus diferentes datos.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('dni')->unique(); // El DNI es unico
            $table->enum('rol', ['admin', 'profe', 'alumno']); // El tipo `rol` del usuario
            $table->string('nombre');
            $table->string('apellido1');
            $table->string('apellido2'); // Nombre y los apellidos del usuario
            $table->date('fecha_nacimiento'); // Fecha de nacimiento del usuario
            $table->enum('genero', ['M', 'F']); // Genero del user `masculino o femenino`
            $table->string('numero_telefono'); // Numero de contacto
            $table->string('email')->unique(); // El email, es unico
            $table->string('password'); // Contraseña
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
