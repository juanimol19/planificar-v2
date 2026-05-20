<?php

namespace App\Http\Requests\PersonaCargoCursado;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaCargoCursadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'persona_cargos_id' => ['required', 'integer', 'exists:persona_cargos,id'],
            'cursados_id'       => ['required', 'integer', 'exists:cursados,id'],
        ];
    }
}
