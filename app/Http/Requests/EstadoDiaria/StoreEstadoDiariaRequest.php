<?php

namespace App\Http\Requests\EstadoDiaria;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstadoDiariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado'                   => ['required', 'string', 'max:45'],
            'fecha'                    => ['required', 'date'],
            'planificacion_diaria_id'  => ['required', 'integer', 'exists:planificacion_diaria,id'],
        ];
    }
}
