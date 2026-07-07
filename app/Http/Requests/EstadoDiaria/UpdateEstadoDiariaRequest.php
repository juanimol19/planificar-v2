<?php

namespace App\Http\Requests\EstadoDiaria;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstadoDiariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
{
    return [
        'estado'                  => ['sometimes', 'string', 'max:45'],
        'fecha'                   => ['sometimes', 'date'],
        'observaciones'           => ['nullable', 'string'],
        'planificacion_diaria_id' => ['sometimes', 'integer', 'exists:planificacion_diaria,id'],
    ];
}
}
