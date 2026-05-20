<?php

namespace App\Http\Requests\Curso;

use Illuminate\Foundation\Http\FormRequest;

class StoreCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ciclo'   => ['required', 'string', 'max:45'],
            'grado'   => ['required', 'string', 'max:45'],
            'seccion' => ['required', 'string', 'max:45'],
            'turno'   => ['required', 'string', 'max:45'],
        ];
    }
}
