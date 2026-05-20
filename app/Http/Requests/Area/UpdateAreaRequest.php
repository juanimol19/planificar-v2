<?php

namespace App\Http\Requests\Area;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'area' => ['sometimes', 'string', 'max:45'],
            'tipo' => ['sometimes', 'string', 'max:45'],
        ];
    }
}
