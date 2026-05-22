<?php

namespace Database\Seeders;

use App\Models\PlanificacionDiaria;
use Illuminate\Database\Seeder;

class PlanificacionDiariaSeeder extends Seeder
{
    public function run(): void
    {
        $planificaciones = [
            [
                'fecha_estimada'           => '2025-11-28',
                'fecha_desarrollada'       => '2025-11-28',
                'fecha_presentacion'       => '2025-11-28',
                'contenidos_especificos'   => 'Aca van los contenidos específicos de la planificación',
                'actividades'              => 'Aca van las actividades de la planificación',
                'tareas'                   => 'Aca van las tareas de la planificación',
                'tipo_planificacion'       => 'semanal',
                'persona_cargo_cursado_id' => 8,
            ],
            [
                'fecha_estimada'           => '2025-11-29',
                'fecha_desarrollada'       => '2025-11-29',
                'fecha_presentacion'       => '2025-11-29',
                'contenidos_especificos'   => 'Contenidos ejemplo 2',
                'actividades'              => 'Actividades ejemplo 2',
                'tareas'                   => 'Tareas ejemplo 2',
                'tipo_planificacion'       => 'diaria',
                'persona_cargo_cursado_id' => 1,
            ],
            [
                'fecha_estimada'           => '2025-11-30',
                'fecha_desarrollada'       => '2025-11-30',
                'fecha_presentacion'       => '2025-11-30',
                'contenidos_especificos'   => 'Contenidos ejemplo 3',
                'actividades'              => 'Actividades ejemplo 3',
                'tareas'                   => 'Tareas ejemplo 3',
                'tipo_planificacion'       => 'mensual',
                'persona_cargo_cursado_id' => 2,
            ],
            [
                'fecha_estimada'           => '2025-12-01',
                'fecha_desarrollada'       => '2025-12-01',
                'fecha_presentacion'       => '2025-12-01',
                'contenidos_especificos'   => 'Contenidos ejemplo 4',
                'actividades'              => 'Actividades ejemplo 4',
                'tareas'                   => 'Tareas ejemplo 4',
                'tipo_planificacion'       => 'semanal',
                'persona_cargo_cursado_id' => 3, // corregido: era 'persona_cargo_cursada_id'
            ],
            [
                'fecha_estimada'           => '2025-12-02',
                'fecha_desarrollada'       => '2025-12-02',
                'fecha_presentacion'       => '2025-12-02',
                'contenidos_especificos'   => 'Contenidos ejemplo 5',
                'actividades'              => 'Actividades ejemplo 5',
                'tareas'                   => 'Tareas ejemplo 5',
                'tipo_planificacion'       => 'diaria',
                'persona_cargo_cursado_id' => 4,
            ],
            [
                'fecha_estimada'           => '2025-12-03',
                'fecha_desarrollada'       => '2025-12-03',
                'fecha_presentacion'       => '2025-12-03',
                'contenidos_especificos'   => 'Contenidos ejemplo 6',
                'actividades'              => 'Actividades ejemplo 6',
                'tareas'                   => 'Tareas ejemplo 6',
                'tipo_planificacion'       => 'mensual',
                'persona_cargo_cursado_id' => 5,
            ],
            [
                'fecha_estimada'           => '2025-12-04',
                'fecha_desarrollada'       => '2025-12-04',
                'fecha_presentacion'       => '2025-12-04',
                'contenidos_especificos'   => 'Contenidos ejemplo 7',
                'actividades'              => 'Actividades ejemplo 7',
                'tareas'                   => 'Tareas ejemplo 7',
                'tipo_planificacion'       => 'diaria',
                'persona_cargo_cursado_id' => 6,
            ],
            [
                'fecha_estimada'           => '2025-12-05',
                'fecha_desarrollada'       => '2025-12-05',
                'fecha_presentacion'       => '2025-12-05',
                'contenidos_especificos'   => 'Contenidos ejemplo 8',
                'actividades'              => 'Actividades ejemplo 8',
                'tareas'                   => 'Tareas ejemplo 8',
                'tipo_planificacion'       => 'semanal',
                'persona_cargo_cursado_id' => 7,
            ],
            [
                'fecha_estimada'           => '2025-12-06',
                'fecha_desarrollada'       => '2025-12-06',
                'fecha_presentacion'       => '2025-12-06',
                'contenidos_especificos'   => 'Contenidos ejemplo 9',
                'actividades'              => 'Actividades ejemplo 9',
                'tareas'                   => 'Tareas ejemplo 9',
                'tipo_planificacion'       => 'mensual',
                'persona_cargo_cursado_id' => 8,
            ],
            [
                'fecha_estimada'           => '2025-12-07',
                'fecha_desarrollada'       => '2025-12-07',
                'fecha_presentacion'       => '2025-12-07',
                'contenidos_especificos'   => 'Contenidos ejemplo 10',
                'actividades'              => 'Actividades ejemplo 10',
                'tareas'                   => 'Tareas ejemplo 10',
                'tipo_planificacion'       => 'diaria',
                'persona_cargo_cursado_id' => 9,
            ],
        ];

        foreach ($planificaciones as $data) {
            PlanificacionDiaria::create($data);
        }
    }
}
