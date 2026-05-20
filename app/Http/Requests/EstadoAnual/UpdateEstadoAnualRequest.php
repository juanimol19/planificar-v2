<?php

namespace App\Http\Requests\EstadoAnual;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstadoAnualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado'                 => ['sometimes', 'string', 'max:45'],
            'fecha'                  => ['sometimes', 'date'],
            'planificacion_anual_id' => ['sometimes', 'integer', 'exists:planificacion_anual,id'],
        ];
    }
}
