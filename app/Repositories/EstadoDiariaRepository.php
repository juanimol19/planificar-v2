<?php

namespace App\Repositories;

use App\Models\EstadoDiaria;
use App\Repositories\Interfaces\EstadoDiariaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EstadoDiariaRepository implements EstadoDiariaRepositoryInterface
{
    public function getAll(): Collection
    {
        return EstadoDiaria::with('planificacionDiaria')->get();
    }

    public function findById(int $id): ?EstadoDiaria
    {
        return EstadoDiaria::with('planificacionDiaria')->find($id);
    }

    public function create(array $data): EstadoDiaria
    {
        return EstadoDiaria::create($data);
    }

    public function update(int $id, array $data): EstadoDiaria
    {
        $estado = EstadoDiaria::findOrFail($id);
        $estado->update($data);
        return $estado;
    }

    public function delete(int $id): bool
    {
        $estado = EstadoDiaria::findOrFail($id);
        return $estado->delete();
    }
}
