<?php

namespace Database\Seeders;

use App\Models\EstadoDiaria;
use Illuminate\Database\Seeder;

class EstadosDiariaSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['estado' => 'En Espera',  'fecha' => '2025-11-28', 'planificacion_diaria_id' => 1],
            ['estado' => 'Pendiente',  'fecha' => '2024-01-01', 'planificacion_diaria_id' => 2],
            ['estado' => 'En Proceso', 'fecha' => '2024-01-01', 'planificacion_diaria_id' => 1],
            ['estado' => 'Completado', 'fecha' => '2024-01-01', 'planificacion_diaria_id' => 3],
            ['estado' => 'Cancelado',  'fecha' => '2024-01-01', 'planificacion_diaria_id' => 7],
            ['estado' => 'Revisado',   'fecha' => '2024-01-01', 'planificacion_diaria_id' => 4],
            ['estado' => 'Aprobado',   'fecha' => '2024-01-01', 'planificacion_diaria_id' => 8],
            ['estado' => 'Archivado',  'fecha' => '2024-01-01', 'planificacion_diaria_id' => 9],
            ['estado' => 'Rechazado',  'fecha' => '2024-01-01', 'planificacion_diaria_id' => 6],
            ['estado' => 'En Espera',  'fecha' => '2024-01-01', 'planificacion_diaria_id' => 6],
            ['estado' => 'Finalizado', 'fecha' => '2024-01-01', 'planificacion_diaria_id' => 3],
        ];

        foreach ($estados as $data) {
            EstadoDiaria::create($data);
        }
    }
}
