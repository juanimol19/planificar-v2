<?php

namespace App\Http\Requests\Persona;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $personaId = $this->user()->persona?->id;

        return [
            'nombres'          => ['sometimes', 'string', 'max:255'],
            'apellidos'        => ['sometimes', 'string', 'max:255'],
            'dni'              => ['sometimes', 'string', 'max:20', "unique:personas,dni,{$personaId}"],
            'e-mail'           => ['sometimes', 'email', 'max:255', "unique:personas,e-mail,{$personaId}"],
            'telefono'         => ['sometimes', 'string', 'max:255'],
            'direccion'        => ['sometimes', 'string', 'max:255'],
            'fecha_nacimiento' => ['sometimes', 'date'],
        ];
    }
}