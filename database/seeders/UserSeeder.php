<?php

namespace Database\Seeders;

use App\Models\Cursado;
use App\Models\Persona;
use App\Models\PersonaCargo;
use App\Models\PersonaCargoCursado;
use App\Models\SitRevista;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── SitRevista de prueba ──────────────────────────────────────
        $sitRevista = SitRevista::firstOrCreate(['revista' => 'Titular']);

        // ── Director ──────────────────────────────────────────────────
        $director = User::firstOrCreate(
            ['email' => 'director@colegio.com'],
            [
                'name'     => 'Director',
                'password' => Hash::make('123456789'),
            ]
        );

        $director->assignRole('director');

        if (!$director->persona) {
            Persona::create([
                'user_id'          => $director->id,
                'nombres'          => 'Director',
                'apellidos'        => '',
                'dni'              => '',
                'e-mail'           => 'director@colegio.com',
                'telefono'         => '',
                'direccion'        => '',
                'fecha_nacimiento' => null,
            ]);
        }

        // ── Docentes ──────────────────────────────────────────────────
        $docentesData = [
            ['name' => 'Docente Uno',    'email' => 'user1@colegio.com', 'nombres' => 'Docente', 'apellidos' => 'Uno',    'curso_id' => 1],
            ['name' => 'Docente Dos',    'email' => 'user2@colegio.com', 'nombres' => 'Docente', 'apellidos' => 'Dos',    'curso_id' => 2],
            ['name' => 'Docente Tres',   'email' => 'user3@colegio.com', 'nombres' => 'Docente', 'apellidos' => 'Tres',   'curso_id' => 3],
            ['name' => 'Docente Cuatro', 'email' => 'user4@colegio.com', 'nombres' => 'Docente', 'apellidos' => 'Cuatro', 'curso_id' => 4],
            ['name' => 'Docente Cinco',  'email' => 'user5@colegio.com', 'nombres' => 'Docente', 'apellidos' => 'Cinco',  'curso_id' => 5],
        ];

        foreach ($docentesData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('123456'),
                ]
            );

            $user->assignRole('docente');

            if (!$user->persona) {
                $persona = Persona::create([
                    'user_id'          => $user->id,
                    'nombres'          => $data['nombres'],
                    'apellidos'        => $data['apellidos'],
                    'dni'              => null,
                    'e-mail'           => null,
                    'telefono'         => '',
                    'direccion'        => '',
                    'fecha_nacimiento' => null,
                ]);
            } else {
                $persona = $user->persona;
            }

            // PersonaCargo
            $personaCargo = PersonaCargo::firstOrCreate([
                'personas_id'    => $persona->id,
                'cargos_id'      => 1,
                'sit_revista_id' => $sitRevista->id,
            ]);

            // Cursado para este docente
            $cursado = Cursado::firstOrCreate(
                ['cursos_id' => $data['curso_id'], 'anio_lectivo' => 2026],
                [
                    'fecha_inicio' => '2026-03-01',
                    'fecha_fin'    => '2026-12-15',
                ]
            );

            // PersonaCargoCursado
            PersonaCargoCursado::firstOrCreate([
                'persona_cargos_id' => $personaCargo->id,
                'cursados_id'       => $cursado->id,
            ]);
        }

        // ── Secretario ────────────────────────────────────────────────
        $secretario = User::firstOrCreate(
            ['email' => 'user6@colegio.com'],
            [
                'name'     => 'Secretario Uno',
                'password' => Hash::make('123456'),
            ]
        );

        $secretario->assignRole('secretario');

        if (!$secretario->persona) {
            Persona::create([
                'user_id'          => $secretario->id,
                'nombres'          => 'Secretario',
                'apellidos'        => 'Uno',
                'dni'              => null,
                'e-mail'           => null,
                'telefono'         => '',
                'direccion'        => '',
                'fecha_nacimiento' => null,
            ]);
        }
    }
}