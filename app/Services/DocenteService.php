<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\PersonaRepositoryInterface;
use App\Repositories\Interfaces\PersonaCargoRepositoryInterface;
use App\Repositories\Interfaces\CursadoRepositoryInterface;
use App\Repositories\Interfaces\PersonaCargoCursadoRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DocenteService
{
    public function __construct(
        protected PersonaRepositoryInterface $personaRepository,
        protected PersonaCargoRepositoryInterface $personaCargoRepository,
        protected CursadoRepositoryInterface $cursadoRepository,
        protected PersonaCargoCursadoRepositoryInterface $personaCargoCursadoRepository,
    ) {}

    public function crearDocente(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // 1. Crear User
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole(Role::findByName('docente', 'api'));

            // 2. Crear Persona (datos reales, no placeholder)
            $persona = $this->personaRepository->create([
                'user_id'          => $user->id,
                'apellidos'        => $data['apellidos'],
                'nombres'          => $data['nombres'],
                'dni'              => $data['dni'] ?? null,
                'e-mail'           => null,
                'telefono'         => $data['telefono'],
                'direccion'        => $data['direccion'],
                'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
            ]);

            // 3. Crear PersonaCargo
            $personaCargo = $this->personaCargoRepository->create([
                'personas_id'    => $persona->id,
                'cargos_id'      => $data['cargos_id'],
                'sit_revista_id' => $data['sit_revista_id'],
            ]);

            // 4. Crear Cursado (nuevo, para el curso elegido)
            $cursado = $this->cursadoRepository->create([
                'anio_lectivo'  => $data['anio_lectivo'],
                'fecha_inicio'  => $data['fecha_inicio'],
                'fecha_fin'     => $data['fecha_fin'],
                'cursos_id'     => $data['cursos_id'],
            ]);

            // 5. Vincular PersonaCargo con Cursado
            $personaCargoCursado = $this->personaCargoCursadoRepository->create([
                'persona_cargos_id' => $personaCargo->id,
                'cursados_id'       => $cursado->id,
            ]);

            return [
                'user'                  => $user,
                'persona'               => $persona,
                'persona_cargo'         => $personaCargo,
                'cursado'               => $cursado,
                'persona_cargo_cursado' => $personaCargoCursado,
            ];
        });
    }
}