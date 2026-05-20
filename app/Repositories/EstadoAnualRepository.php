<?php

namespace App\Repositories;

use App\Models\EstadoAnual;
use App\Repositories\Interfaces\EstadoAnualRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EstadoAnualRepository implements EstadoAnualRepositoryInterface
{
    public function getAll(): Collection
    {
        return EstadoAnual::with('planificacionAnual')->get();
    }

    public function findById(int $id): ?EstadoAnual
    {
        return EstadoAnual::with('planificacionAnual')->find($id);
    }

    public function create(array $data): EstadoAnual
    {
        return EstadoAnual::create($data);
    }

    public function update(int $id, array $data): EstadoAnual
    {
        $estado = EstadoAnual::findOrFail($id);
        $estado->update($data);
        return $estado;
    }

    public function delete(int $id): bool
    {
        $estado = EstadoAnual::findOrFail($id);
        return $estado->delete();
    }
}
