<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Repositories\Interfaces\PersonaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonaRepository implements PersonaRepositoryInterface
{
    public function getAll(): Collection
    {
        return Persona::all();
    }

    public function getDocentes(): Collection
    {
        return Persona::whereHas('user.roles', function ($query) {
                $query->where('name', 'docente');
            })
            ->with([
                'user.roles',
                'personaCargos.cargo',
                'personaCargos.personaCargoCursados.cursado.curso',
            ])
            ->get();
    }

    public function findById(int $id): ?Persona
    {
        return Persona::find($id);
    }

    public function create(array $data): Persona
    {
        return Persona::create($data);
    }

    public function update(int $id, array $data): Persona
    {
        $persona = Persona::findOrFail($id);
        $persona->update($data);
        return $persona;
    }

    public function delete(int $id): bool
    {
        $persona = Persona::findOrFail($id);
        return $persona->delete();
    }
}