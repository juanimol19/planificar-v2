<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            ['ciclo' => '1', 'grado' => '1°', 'seccion' => 'A', 'turno' => 'Mañana'],
            ['ciclo' => '1', 'grado' => '2°', 'seccion' => 'B', 'turno' => 'Tarde'],
            ['ciclo' => '1', 'grado' => '3°', 'seccion' => 'C', 'turno' => 'Mañana'],
            ['ciclo' => '2', 'grado' => '4°', 'seccion' => 'A', 'turno' => 'Tarde'],
            ['ciclo' => '2', 'grado' => '5°', 'seccion' => 'B', 'turno' => 'Mañana'],
            ['ciclo' => '3', 'grado' => '6°', 'seccion' => 'C', 'turno' => 'Tarde'],
            ['ciclo' => '3', 'grado' => '7°', 'seccion' => 'A', 'turno' => 'Mañana'],
            ['ciclo' => '1', 'grado' => '1°', 'seccion' => 'B', 'turno' => 'Tarde'],
            ['ciclo' => '1', 'grado' => '3°', 'seccion' => 'A', 'turno' => 'Mañana'],
            ['ciclo' => '2', 'grado' => '4°', 'seccion' => 'C', 'turno' => 'Tarde'],
            ['ciclo' => '2', 'grado' => '5°', 'seccion' => 'A', 'turno' => 'Mañana'],
            ['ciclo' => '3', 'grado' => '6°', 'seccion' => 'B', 'turno' => 'Tarde'],
            ['ciclo' => '3', 'grado' => '7°', 'seccion' => 'C', 'turno' => 'Mañana'],
            ['ciclo' => '1', 'grado' => '2°', 'seccion' => 'C', 'turno' => 'Tarde'],
        ];

        foreach ($cursos as $data) {
            Curso::create($data);
        }
    }
}
