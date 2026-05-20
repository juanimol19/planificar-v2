<?php

namespace App\Http\Requests\PersonaCargo;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaCargoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'personas_id'    => ['sometimes', 'integer', 'exists:personas,id'],
            'cargos_id'      => ['sometimes', 'integer', 'exists:cargos,id'],
            'sit_revista_id' => ['sometimes', 'integer', 'exists:sit_revista,id'],
        ];
    }
}
