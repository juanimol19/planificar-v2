<?php

namespace Database\Seeders;

use App\Models\Cursado;
use Illuminate\Database\Seeder;

class CursadoSeeder extends Seeder
{
    public function run(): void
    {
        $cursados = [
            ['anio_lectivo' => '2024', 'fecha_inicio' => '2024-03-01', 'fecha_fin' => '2024-12-10', 'cursos_id' => 1],
            ['anio_lectivo' => '2024', 'fecha_inicio' => '2024-03-01', 'fecha_fin' => '2024-12-10', 'cursos_id' => 2],
            ['anio_lectivo' => '2023', 'fecha_inicio' => '2023-03-01', 'fecha_fin' => '2023-12-15', 'cursos_id' => 3],
            ['anio_lectivo' => '2025', 'fecha_inicio' => '2025-03-01', 'fecha_fin' => '2025-07-30', 'cursos_id' => 4],
            ['anio_lectivo' => '2024', 'fecha_inicio' => '2024-03-01', 'fecha_fin' => '2024-12-10', 'cursos_id' => 5],
            ['anio_lectivo' => '2023', 'fecha_inicio' => '2023-03-01', 'fecha_fin' => '2023-12-15', 'cursos_id' => 6],
            ['anio_lectivo' => '2024', 'fecha_inicio' => '2024-03-01', 'fecha_fin' => '2024-12-10', 'cursos_id' => 7],
            ['anio_lectivo' => '2025', 'fecha_inicio' => '2025-03-01', 'fecha_fin' => '2025-07-30', 'cursos_id' => 8],
            ['anio_lectivo' => '2024', 'fecha_inicio' => '2024-03-01', 'fecha_fin' => '2024-12-10', 'cursos_id' => 9],
            ['anio_lectivo' => '2023', 'fecha_inicio' => '2023-03-01', 'fecha_fin' => '2023-12-15', 'cursos_id' => 10],
        ];

        foreach ($cursados as $data) {
            Cursado::create($data);
        }
    }
}
