<?php

namespace App\Http\Requests\Cargo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCargoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cargo' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
