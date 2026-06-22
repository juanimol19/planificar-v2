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
    }
}