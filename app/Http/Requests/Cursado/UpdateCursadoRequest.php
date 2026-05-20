<?php

namespace App\Http\Requests\Cursado;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCursadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'anio_lectivo' => ['sometimes', 'string', 'max:40'],
            'fecha_inicio' => ['sometimes', 'date'],
            'fecha_fin'    => ['sometimes', 'date', 'after:fecha_inicio'],
            'cursos_id'    => ['sometimes', 'integer', 'exists:cursos,id'],
        ];
    }
}
