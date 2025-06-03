<?php

namespace Database\Seeders;

use App\Models\Clase;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Ejecucion de seeders de clase
     */
    public function run(): void
    {
        Clase::create([
            'nombre' => 'Clase Arabe A',
            'profe_id' => 2,
            'tipo' => 'arabe',
            'nivel' => 'A1',
            'numero_alumnos' => 2,
            'imagen_horario' => '/horarios/horario1.png',
        ]);

        Clase::create([
            'nombre' => 'Clase Religion A',
            'profe_id' => 3,
            'tipo' => 'religion',
            'nivel' => 'A1',
            'numero_alumnos' => 3,
            'imagen_horario' => '/horarios/horario2.png',
        ]);
    }
}
