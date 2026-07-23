<?php

namespace App\Http\Requests\PlanificacionAnual;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanificacionAnualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_presentacion'       => ['sometimes', 'date'],
            'aprendizajes_esperados'   => ['sometimes', 'string'],
            'saberes'                  => ['sometimes', 'string'],
            'criterios'                => ['sometimes', 'string'],
            'bibliografia'             => ['sometimes', 'string'],
            'diagnostico'              => ['sometimes', 'string'],
            'contenido'                => ['sometimes', 'array'],
            'grado'                    => ['sometimes', 'string'],
            'ciclo'                    => ['sometimes', 'string'],
            'anio'                     => ['sometimes', 'string'],
            'saberes_transversales'    => ['sometimes', 'string'],
            'areas_id'                 => ['sometimes', 'integer', 'exists:areas,id'],
            'persona_cargo_cursado_id' => ['sometimes', 'integer', 'exists:persona_cargo_cursado,id'],
            'tipo_planificacion'       => ['sometimes', 'string', 'max:255'],
        ];
    }
}