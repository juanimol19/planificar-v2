<?php

namespace App\Http\Requests\Persona;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('persona');

        return [
            'apellidos'        => ['sometimes', 'string', 'max:255'],
            'nombres'          => ['sometimes', 'string', 'max:255'],
            'dni'              => ['sometimes', 'string', 'max:255', "unique:personas,dni,{$id}"],
            'e-mail'           => ['sometimes', 'email', 'max:255', "unique:personas,e-mail,{$id}"],
            'telefono'         => ['sometimes', 'string', 'max:255'],
            'direccion'        => ['sometimes', 'string', 'max:255'],
            'fecha_nacimiento' => ['sometimes', 'date'],
        ];
    }
}
