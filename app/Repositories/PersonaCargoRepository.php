<?php

namespace App\Repositories;

use App\Models\PersonaCargo;
use App\Repositories\Interfaces\PersonaCargoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonaCargoRepository implements PersonaCargoRepositoryInterface
{
    public function getAll(): Collection
    {
        return PersonaCargo::with(['persona', 'cargo', 'sitRevista'])->get();
    }

    public function findById(int $id): ?PersonaCargo
    {
        return PersonaCargo::with(['persona', 'cargo', 'sitRevista'])->find($id);
    }

    public function create(array $data): PersonaCargo
    {
        return PersonaCargo::create($data);
    }

    public function update(int $id, array $data): PersonaCargo
    {
        $personaCargo = PersonaCargo::findOrFail($id);
        $personaCargo->update($data);
        return $personaCargo;
    }

    public function delete(int $id): bool
    {
        $personaCargo = PersonaCargo::findOrFail($id);
        return $personaCargo->delete();
    }
}
