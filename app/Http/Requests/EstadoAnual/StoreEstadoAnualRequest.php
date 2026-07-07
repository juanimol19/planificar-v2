<?php

namespace App\Http\Requests\EstadoAnual;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstadoAnualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
{
    return [
        'estado'                 => ['required', 'string', 'max:45'],
        'fecha'                  => ['required', 'date'],
        'observaciones'          => ['nullable', 'string'],
        'planificacion_anual_id' => ['required', 'integer', 'exists:planificacion_anual,id'],
    ];
}
}
