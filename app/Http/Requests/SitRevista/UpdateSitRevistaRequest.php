<?php

namespace App\Http\Requests\SitRevista;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSitRevistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'revista' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
