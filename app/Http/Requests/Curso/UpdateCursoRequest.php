<?php

namespace App\Http\Requests\Curso;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ciclo'   => ['sometimes', 'string', 'max:45'],
            'grado'   => ['sometimes', 'string', 'max:45'],
            'seccion' => ['sometimes', 'string', 'max:45'],
            'turno'   => ['sometimes', 'string', 'max:45'],
        ];
    }
}
