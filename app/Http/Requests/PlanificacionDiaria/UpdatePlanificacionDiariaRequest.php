<?php

namespace App\Http\Requests\PlanificacionDiaria;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanificacionDiariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_estimada'           => ['sometimes', 'date'],
            'fecha_desarrollada'       => ['sometimes', 'date'],
            'fecha_presentacion'       => ['sometimes', 'date'],
            'contenidos_especificos'   => ['sometimes', 'string'],
            'actividades'              => ['sometimes', 'string'],
            'tareas'                   => ['sometimes', 'string'],
            'persona_cargo_cursado_id' => ['sometimes', 'integer', 'exists:persona_cargo_cursado,id'],
            'tipo_planificacion'       => ['sometimes', 'string', 'max:45'],
        ];
    }
}
