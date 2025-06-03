<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esta es una tabla en relacion con usuarios y clase, para que el alumno tenga diferentes calses.
     */
    public function up(): void
    {
        Schema::create('class_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade'); // El id del usuario se necesita
            $table->foreignId('clase_id')->constrained('classes')->onDelete('cascade');; // Y el id de la clase
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_user');
    }
};
