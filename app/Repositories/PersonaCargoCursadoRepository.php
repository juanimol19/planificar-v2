<?php

namespace App\Repositories;

use App\Models\PersonaCargoCursado;
use App\Repositories\Interfaces\PersonaCargoCursadoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonaCargoCursadoRepository implements PersonaCargoCursadoRepositoryInterface
{
    public function getAll(): Collection
    {
        return PersonaCargoCursado::with(['personaCargo.persona', 'personaCargo.cargo', 'cursado.curso'])->get();
    }

    public function findById(int $id): ?PersonaCargoCursado
    {
        return PersonaCargoCursado::with(['personaCargo.persona', 'personaCargo.cargo', 'cursado.curso'])->find($id);
    }

    public function create(array $data): PersonaCargoCursado
    {
        return PersonaCargoCursado::create($data);
    }

    public function update(int $id, array $data): PersonaCargoCursado
    {
        $pcc = PersonaCargoCursado::findOrFail($id);
        $pcc->update($data);
        return $pcc;
    }

    public function delete(int $id): bool
    {
        $pcc = PersonaCargoCursado::findOrFail($id);
        return $pcc->delete();
    }
}
