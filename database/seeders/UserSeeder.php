<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
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
        $docentes = [
            ['name' => 'Docente Uno',   'email' => 'user1@colegio.com', 'nombres' => 'Docente',  'apellidos' => 'Uno'],
            ['name' => 'Docente Dos',   'email' => 'user2@colegio.com', 'nombres' => 'Docente',  'apellidos' => 'Dos'],
            ['name' => 'Docente Tres',  'email' => 'user3@colegio.com', 'nombres' => 'Docente',  'apellidos' => 'Tres'],
            ['name' => 'Docente Cuatro','email' => 'user4@colegio.com', 'nombres' => 'Docente',  'apellidos' => 'Cuatro'],
            ['name' => 'Docente Cinco', 'email' => 'user5@colegio.com', 'nombres' => 'Docente',  'apellidos' => 'Cinco'],
        ];

        foreach ($docentes as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('123456'),
                ]
            );

            $user->assignRole('docente');

            if (!$user->persona) {
                Persona::create([
                    'user_id'          => $user->id,
                    'nombres'          => $data['nombres'],
                    'apellidos'        => $data['apellidos'],
                    'dni'              => null,
                    'e-mail'           => null,
                    'telefono'         => '',
                    'direccion'        => '',
                    'fecha_nacimiento' => null,
                ]);
            }
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