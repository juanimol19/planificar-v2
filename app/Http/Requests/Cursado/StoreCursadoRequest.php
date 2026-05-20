<?php

namespace App\Http\Requests\Cursado;

use Illuminate\Foundation\Http\FormRequest;

class StoreCursadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'anio_lectivo' => ['required', 'string', 'max:40'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin'    => ['required', 'date', 'after:fecha_inicio'],
            'cursos_id'    => ['required', 'integer', 'exists:cursos,id'],
        ];
    }
}
