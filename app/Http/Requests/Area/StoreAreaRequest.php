<?php

namespace App\Http\Requests\Area;

use Illuminate\Foundation\Http\FormRequest;

class StoreAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'area' => ['required', 'string', 'max:45'],
            'tipo' => ['required', 'string', 'max:45'],
        ];
    }
}
