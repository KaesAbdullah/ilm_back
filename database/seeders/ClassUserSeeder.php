<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassUserSeeder extends Seeder
{
    /**
     * Un seeder para la relacion de Clase Alumno
     */
    public function run(): void
    {
        // Se asignan alumnos para las clases
        for ($i = 6; $i < 8; $i++) {
            DB::table('class_user')->insert([
                'usuario_id' => $i,
                'clase_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 8; $i < 11; $i++) {
            DB::table('class_user')->insert([
                'usuario_id' => $i,
                'clase_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
