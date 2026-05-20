<?php

namespace App\Repositories;

use App\Models\Cursado;
use App\Repositories\Interfaces\CursadoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CursadoRepository implements CursadoRepositoryInterface
{
    public function getAll(): Collection
    {
        return Cursado::with('curso')->get();
    }

    public function findById(int $id): ?Cursado
    {
        return Cursado::with('curso')->find($id);
    }

    public function create(array $data): Cursado
    {
        return Cursado::create($data);
    }

    public function update(int $id, array $data): Cursado
    {
        $cursado = Cursado::findOrFail($id);
        $cursado->update($data);
        return $cursado;
    }

    public function delete(int $id): bool
    {
        $cursado = Cursado::findOrFail($id);
        return $cursado->delete();
    }
}
