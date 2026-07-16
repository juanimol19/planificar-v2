<?php

namespace App\Http\Requests\Docente;

use Illuminate\Foundation\Http\FormRequest;

class CrearDocenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Datos de usuario
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',

            // Datos de persona
            'apellidos'             => 'required|string|max:255',
            'nombres'               => 'required|string|max:255',
            'dni'                   => 'nullable|string|unique:personas,dni',
            'telefono'              => 'required|string|max:255',
            'direccion'             => 'required|string|max:255',
            'fecha_nacimiento'      => 'nullable|date',

            // Datos de persona_cargo
            'cargos_id'             => 'required|integer|exists:cargos,id',
            'sit_revista_id'        => 'required|integer|exists:sit_revista,id',

            // Datos de cursado (curso ya elegido + año lectivo nuevo)
            'cursos_id'             => 'required|integer|exists:cursos,id',
            'anio_lectivo'          => 'required|string|max:40',
            'fecha_inicio'          => 'required|date',
            'fecha_fin'             => 'required|date|after_or_equal:fecha_inicio',
        ];
    }
}