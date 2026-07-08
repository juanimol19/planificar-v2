<?php

namespace App\Repositories;

use App\Models\PlanificacionAnual;
use App\Repositories\Interfaces\PlanificacionAnualRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlanificacionAnualRepository implements PlanificacionAnualRepositoryInterface
{
public function getAll(?int $personaCargoCursadoId = null): Collection
{
    $query = PlanificacionAnual::with(['area', 'personaCargoCursado.personaCargo.persona', 'personaCargoCursado.cursado.curso', 'estadosAnuales']);
    if ($personaCargoCursadoId) {
        $query->where('persona_cargo_cursado_id', $personaCargoCursadoId);
    }

    return $query->get();
}

    public function findById(int $id): ?PlanificacionAnual
{
    return PlanificacionAnual::with(['area', 'personaCargoCursado.personaCargo.persona', 'personaCargoCursado.cursado.curso', 'estadosAnuales'])->find($id);
}

    public function create(array $data): PlanificacionAnual
    {
        return PlanificacionAnual::create($data);
    }

    public function update(int $id, array $data): PlanificacionAnual
    {
        $planificacion = PlanificacionAnual::findOrFail($id);
        $planificacion->update($data);
        return $planificacion;
    }

    public function delete(int $id): bool
    {
        $planificacion = PlanificacionAnual::findOrFail($id);
        return $planificacion->delete();
    }
}
