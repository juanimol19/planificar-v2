<?php

namespace App\Http\Requests\Persona;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'apellidos'        => ['required', 'string', 'max:255'],
            'nombres'          => ['required', 'string', 'max:255'],
            'dni'              => ['required', 'string', 'max:255', 'unique:personas,dni'],
            'e-mail'           => ['required', 'email', 'max:255', 'unique:personas,e-mail'],
            'telefono'         => ['required', 'string', 'max:255'],
            'direccion'        => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'date'],
        ];
    }
}
