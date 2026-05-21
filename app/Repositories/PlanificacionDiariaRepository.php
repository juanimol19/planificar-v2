<?php

namespace App\Repositories;

use App\Models\PlanificacionDiaria;
use App\Repositories\Interfaces\PlanificacionDiariaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlanificacionDiariaRepository implements PlanificacionDiariaRepositoryInterface
{
    public function getAll(): Collection
    {
        return PlanificacionDiaria::with(['personaCargoCursado'])->get();
    }

    public function findById(int $id): ?PlanificacionDiaria
    {
        return PlanificacionDiaria::with(['personaCargoCursado', 'estadosDiarias'])->find($id);
    }

    public function create(array $data): PlanificacionDiaria
    {
        return PlanificacionDiaria::create($data);
    }

    public function update(int $id, array $data): PlanificacionDiaria
    {
        $planificacion = PlanificacionDiaria::findOrFail($id);
        $planificacion->update($data);
        return $planificacion;
    }

    public function delete(int $id): bool
    {
        $planificacion = PlanificacionDiaria::findOrFail($id);
        return $planificacion->delete();
    }
}
