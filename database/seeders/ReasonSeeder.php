<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    public function run(): void
    {

        $asistencias = [1, 2, 3, 5, 7, 10, 15, 19]; // Variable para alternar

        for ($i = 1; $i < 21; $i++) {
            Reason::create([
                'asistencia_id' => $asistencias[($i - 1) % count($asistencias)],
                'motivo' => "Este es el motivo de la justificacion " . $i . ". Justifico que estuve en el medico por dolor de algo... Falta...",
                'estado' => $i % 2 === 0,
            ]);
        }
    }
}
