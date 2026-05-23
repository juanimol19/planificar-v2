<?php

namespace Database\Seeders;

use App\Models\PlanificacionAnual;
use Illuminate\Database\Seeder;

class PlanificacionAnualSeeder extends Seeder
{
    public function run(): void
    {
        $planificaciones = [
            [
                'fecha_presentacion'       => '2025-03-15',
                'aprendizajes_esperados'   => 'Comprender conceptos fundamentales del área',
                'saberes'                  => 'Teóricos y prácticos relacionados al contenido anual',
                'criterios'                => 'Participación, evaluación continua y proyectos integradores',
                'bibliografia'             => 'Sommerville, Ian. Ingeniería de Software. 10ma edición',
                'diagnostico'              => 'Buen nivel general con algunas dificultades de aplicación',
                'areas_id'                 => 1,
                'persona_cargo_cursado_id' => 1,
                'tipo_planificacion'       => 'Anual',
            ],
            [
                'fecha_presentacion'       => '2025-03-20',
                'aprendizajes_esperados'   => 'Desarrollar habilidades de pensamiento crítico',
                'saberes'                  => 'Conceptos interdisciplinares aplicados a la práctica',
                'criterios'                => 'Evaluación continua y resolución de problemas',
                'bibliografia'             => 'Pressman, Ingeniería del Software. 9na edición',
                'diagnostico'              => 'Grupo heterogéneo con potencial alto de aprendizaje',
                'areas_id'                 => 2,
                'persona_cargo_cursado_id' => 2,
                'tipo_planificacion'       => 'Trimestral',
            ],
        ];

        foreach ($planificaciones as $data) {
            PlanificacionAnual::create($data);
        }
    }
}
