<?php

namespace App\Http\Requests\SitRevista;

use Illuminate\Foundation\Http\FormRequest;

class StoreSitRevistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'revista' => ['required', 'string', 'max:255'],
        ];
    }
}
