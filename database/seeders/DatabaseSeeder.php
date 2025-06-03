<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use Database\Seeders\UserSeeder;
//use Database\Seeders\ClassSeeder;
//use Database\Seeders\ClassUserSeeder;
//use Database\Seeders\AsistenciaSeeder;
use Database\Seeders\ReasonSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders.
     */
    public function run(): void
    {
        $this->call([
            //UserSeeder::class,
            //ClassSeeder::class,
            //ClassUserSeeder::class,
            //AsistenciaSeeder::class,
            //ReasonSeeder::class
        ]);
    }
}
