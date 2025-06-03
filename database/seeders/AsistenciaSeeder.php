<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asistencia;

class AsistenciaSeeder extends Seeder
{
    // Ejecutara lo necesario
    public function run(): void
    {
        // Variables para alternar
        $clases = [1, 2, 5];
        $alumnos = [6, 7, 8, 9, 10];

        for ($i = 1; $i < 20; $i++) {
            if ($i <= 9) // Con esto se asegura si poner un 0 delante del numero del dia, o no
                Asistencia::create([
                    'fecha' => '2002-10-0' . $i, // Menor que 10, significa, solo 1 digito, por eso añado un 0
                    'clase_id' => $clases[($i - 1) % count($clases)], // Con estos, al crear, alternaran los id
                    'alumno_id' => $alumnos[($i - 1) % count($alumnos)],
                    'estado' => $i % 2 === 0,
                ]);
            else
                Asistencia::create([
                    'fecha' => '2000-09-' . $i, // Mayor que 9, significa 2 digitos
                    'clase_id' => $clases[($i - 1) % count($clases)],
                    'alumno_id' => $alumnos[($i - 1) % count($alumnos)],
                    'estado' => $i % 2 === 0,
                ]);
        }
    }
}
