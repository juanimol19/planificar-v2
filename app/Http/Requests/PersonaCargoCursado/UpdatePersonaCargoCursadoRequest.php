<?php

namespace App\Http\Requests\PersonaCargoCursado;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaCargoCursadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'persona_cargos_id' => ['sometimes', 'integer', 'exists:persona_cargos,id'],
            'cursados_id'       => ['sometimes', 'integer', 'exists:cursados,id'],
        ];
    }
}
