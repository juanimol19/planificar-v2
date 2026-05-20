<?php

namespace App\Repositories;

use App\Models\Cargo;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CargoRepository implements CargoRepositoryInterface
{
    public function getAll(): Collection
    {
        return Cargo::all();
    }

    public function findById(int $id): ?Cargo
    {
        return Cargo::find($id);
    }

    public function create(array $data): Cargo
    {
        return Cargo::create($data);
    }

    public function update(int $id, array $data): Cargo
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->update($data);
        return $cargo;
    }

    public function delete(int $id): bool
    {
        $cargo = Cargo::findOrFail($id);
        return $cargo->delete();
    }
}
