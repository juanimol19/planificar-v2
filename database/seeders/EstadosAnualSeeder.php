<?php

namespace Database\Seeders;

use App\Models\EstadoAnual;
use Illuminate\Database\Seeder;

class EstadosAnualSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['estado' => 'Pendiente',   'fecha' => '2024-01-01', 'planificacion_anual_id' => 1],
            ['estado' => 'En Proceso',  'fecha' => '2024-01-01', 'planificacion_anual_id' => 2],
            ['estado' => 'Completado',  'fecha' => '2024-01-01', 'planificacion_anual_id' => 1],
            ['estado' => 'Cancelado',   'fecha' => '2024-01-01', 'planificacion_anual_id' => 2],
            ['estado' => 'Revisado',    'fecha' => '2024-01-01', 'planificacion_anual_id' => 2],
            ['estado' => 'Aprobado',    'fecha' => '2024-01-01', 'planificacion_anual_id' => 1],
            ['estado' => 'Archivado',   'fecha' => '2024-01-01', 'planificacion_anual_id' => 2],
            ['estado' => 'Rechazado',   'fecha' => '2024-01-01', 'planificacion_anual_id' => 1],
            ['estado' => 'En Espera',   'fecha' => '2024-01-01', 'planificacion_anual_id' => 1],
            ['estado' => 'Finalizado',  'fecha' => '2024-01-01', 'planificacion_anual_id' => 2],
        ];

        foreach ($estados as $data) {
            EstadoAnual::create($data);
        }
    }
}
