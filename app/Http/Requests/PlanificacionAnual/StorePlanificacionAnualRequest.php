<?php

namespace App\Http\Requests\PlanificacionAnual;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanificacionAnualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_presentacion'       => ['required', 'date'],
            'aprendizajes_esperados'   => ['nullable', 'string'],
            'saberes'                  => ['nullable', 'string'],
            'criterios'                => ['nullable', 'string'],
            'bibliografia'             => ['required', 'string'],
            'diagnostico'              => ['required', 'string'],
            'contenido'                => ['required', 'array'],
            'grado'                    => ['required', 'string'],
            'ciclo'                    => ['required', 'string'],
            'anio'                     => ['required', 'string'],
            'saberes_transversales'    => ['nullable', 'string'],
            'areas_id'                 => ['required', 'integer', 'exists:areas,id'],
            'persona_cargo_cursado_id' => ['required', 'integer', 'exists:persona_cargo_cursado,id'],
            'tipo_planificacion'       => ['required', 'string', 'max:255'],
        ];
    }
}