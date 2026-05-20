<?php

namespace App\Http\Requests\Cargo;

use Illuminate\Foundation\Http\FormRequest;

class StoreCargoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cargo' => ['required', 'string', 'max:255'],
        ];
    }
}
