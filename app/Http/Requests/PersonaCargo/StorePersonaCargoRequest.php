<?php

namespace App\Http\Requests\PersonaCargo;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaCargoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'personas_id'    => ['required', 'integer', 'exists:personas,id'],
            'cargos_id'      => ['required', 'integer', 'exists:cargos,id'],
            'sit_revista_id' => ['required', 'integer', 'exists:sit_revista,id'],
        ];
    }
}
