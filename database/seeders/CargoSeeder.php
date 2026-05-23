<?php

namespace Database\Seeders;

use App\Models\Cargo;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
            'Director 1° categoria',
            'Director 2° categoria',
            'Director 3° categoria',
            'Vice-Director 1° categoria',
            'Vice-Director 2° categoria',
            'Vice-Director 3° categoria',
            'Secretario 1° categoria',
            'Secretario 2° categoria',
            'Secretario 3° categoria',
            'Maestro',
            'Maestro Especial Música',
            'Maestro Especial ED. Física',
            'Maestro Especial Plástica',
            'Maestro Especial Tecnología',
        ];

        foreach ($cargos as $cargo) {
            Cargo::create(['cargo' => $cargo]);
        }
    }
}
