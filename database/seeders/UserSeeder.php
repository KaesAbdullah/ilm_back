<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Esto es para ejecutar los seeders para los usuarios
     */
    public function run(): void
    {
        // ADMINISTRADOR /*
        //User::create([
        //    'dni' => '35353532L',
        //    'rol' => 'admin',
        //    'nombre' => 'Shadi',
        //    'apellido1' => 'Karbal',
        //    'apellido2' => 'Handi',
        //    'fecha_nacimiento' => '2003-05-03',
        //    'genero' => 'M',
        //    'numero_telefono' => '654546123',
        //    'email' => 'admin@gmail.com',
        //    'password' => Hash::make('admin123'),
        //]);

        // PROFESORES
        //User::create([
        //    'dni' => '15141412S',
        //    'rol' => 'profe',
        //    'nombre' => 'Sara',
        //     'apellido1' => 'Martin',
        //    'apellido2' => 'Garcia',
        //    'fecha_nacimiento' => '1990-05-03',
        //    'genero' => 'F',
        //    'numero_telefono' => '354546123',
        //    'email' => 'sara@gmail.com',
        //    'password' => Hash::make('profe123'),
        //]);

        //User::create([
        //    'dni' => '45141412R',
        //    'rol' => 'profe',
        //    'nombre' => 'Emiliano',
        //    'apellido1' => 'Torres',
        //    'apellido2' => 'Garcia',
        //    'fecha_nacimiento' => '1990-01-03',
        //    'genero' => 'M',
        //    'numero_telefono' => '654536123',
        //    'email' => 'emiliano@gmail.com',
        //    'password' => Hash::make('profe123'),
        //]);

        // ALUMNOS
        //for ($i = 1; $i < 6; $i++) {
        //    User::create([
        //        'dni' => $i . '234425D',
        //        'rol' => 'alumno',
        //        'nombre' => 'Alumno' . $i,
        //        'apellido1' => 'Martin',
        //        'apellido2' => 'Garcia',
        //        'fecha_nacimiento' => '1990-05-0' . $i,
        //        'genero' => $i % 2 === 0 ? 'F' : 'M', // Genero de alumno prueba, random
        //        'numero_telefono' => '6502050' . $i,
        //        'email' => 'alumno' . $i . '@gmail.com',
        //        'password' => Hash::make('alumno123'),
        //    ]);
        //}

        // ESTO GENERARA LO NECESARIO
        $faker = Faker::create('es_ES'); // Español

        // Profesores
        for ($i = 0; $i < 30; $i++) {
            User::create([
                'dni' => strtoupper($faker->unique()->randomNumber(8, true)) . $faker->randomLetter(),
                'rol' => 'profe',
                'nombre' => $faker->firstName,
                'apellido1' => $faker->lastName,
                'apellido2' => $faker->lastName,
                'fecha_nacimiento' => $faker->date('Y-m-d', '2000-01-01'),
                'genero' => $faker->randomElement(['M', 'F']),
                'numero_telefono' => $faker->unique()->numerify('6########'),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('profe123'),
            ]);
        }

        // Alumnos
        for ($i = 0; $i < 160; $i++) {
            User::create([
                'dni' => strtoupper($faker->unique()->randomNumber(8, true)) . $faker->randomLetter(),
                'rol' => 'alumno',
                'nombre' => $faker->firstName,
                'apellido1' => $faker->lastName,
                'apellido2' => $faker->lastName,
                'fecha_nacimiento' => $faker->date('Y-m-d', '2007-01-01'),
                'genero' => $faker->randomElement(['M', 'F']),
                'numero_telefono' => $faker->unique()->numerify('6########'),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('alumno123'),
            ]);
        }
    }
}
